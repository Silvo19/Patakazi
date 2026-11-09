<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/mailer.php';
header('Referrer-Policy: no-referrer'); // keep the token out of Referer headers

$token = (string)($_GET['token'] ?? $_POST['token'] ?? '');
$row = false;
if (preg_match('/^[a-f0-9]{64}$/', $token)) {
    $st = db()->prepare("SELECT pr.id, pr.user_id, u.email, u.full_name FROM password_resets pr JOIN users u ON u.id = pr.user_id
        WHERE pr.token_hash = ? AND pr.used_at IS NULL AND pr.expires_at > NOW() AND u.status = 'active'");
    $st->execute([hash('sha256', $token)]);
    $row = $st->fetch();
}
$errors = [];
if ($row && is_post()) {
    csrf_verify();
    $pw = (string)($_POST['password'] ?? ''); $cf = (string)($_POST['confirm'] ?? '');
    if (strlen($pw) < 8 || !preg_match('/[A-Za-z]/', $pw) || !preg_match('/\d/', $pw)) $errors[] = 'Password must be at least 8 characters with letters and numbers.';
    if ($pw !== $cf) $errors[] = 'Passwords do not match.';
    if (!$errors) {
        $pdo = db();
        $pdo->beginTransaction();
        $pdo->prepare('UPDATE users SET password_hash = ?, password_changed_at = NOW() WHERE id = ?')->execute([password_hash($pw, PASSWORD_DEFAULT), $row['user_id']]);
        $pdo->prepare('UPDATE password_resets SET used_at = NOW() WHERE user_id = ? AND used_at IS NULL')->execute([$row['user_id']]);
        $pdo->commit();
        log_activity('password_reset_completed', 'user', (int)$row['user_id'], '', (int)$row['user_id']);
        send_mail($row['email'], 'Your PataKazi password was changed',
            "Hello {$row['full_name']},\n\nYour PataKazi password was just changed. If this wasn't you, reset it again immediately and contact support.\n\n— PataKazi");
        logout_user(); session_start();
        unset($_SESSION['fails'], $_SESSION['lock_until']);
        flash('success', 'Password updated. Please log in with your new password.');
        redirect('login.php');
    }
}
$bodyClass = 'bg-auth';
$pageTitle = 'Reset password';
require __DIR__ . '/includes/header.php';
?>
<section class="form-card">
<?php if (!$row): ?>
  <h1>Link not valid</h1>
  <div class="alert error">This reset link is invalid, already used, or has expired.</div>
  <p class="center"><a class="btn" href="<?= url('forgot-password.php') ?>">Request a new link</a></p>
<?php else: ?>
  <h1>Choose a new password</h1>
  <?php foreach ($errors as $er): ?><div class="alert error"><?= e($er) ?></div><?php endforeach; ?>
  <form method="post"><?= csrf_field() ?><input type="hidden" name="token" value="<?= e($token) ?>">
    <label>New password <input type="password" name="password" required minlength="8" autocomplete="new-password" autofocus></label>
    <label>Confirm new password <input type="password" name="confirm" required autocomplete="new-password"></label>
    <button class="btn block" type="submit">Update password</button>
  </form>
<?php endif; ?>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
