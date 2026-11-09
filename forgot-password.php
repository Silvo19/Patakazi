<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/mailer.php';
if ($u = current_user()) redirect(dashboard_path($u['role']));

$done = false; $email = ''; $error = '';
if (is_post()) {
    csrf_verify();
    $email = strtolower(trim((string)($_POST['email'] ?? '')));
    $now = time();
    $_SESSION['reset_hits'] = array_values(array_filter($_SESSION['reset_hits'] ?? [], fn($t) => $t > $now - 900));
    if (count($_SESSION['reset_hits']) >= 5) {
        $error = 'Too many requests. Please wait 15 minutes and try again.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Enter a valid email address.';
    } else {
        $_SESSION['reset_hits'][] = $now;
        $pdo = db();
        $st = $pdo->prepare("SELECT id, full_name FROM users WHERE email = ? AND status = 'active'");
        $st->execute([$email]);
        $row = $st->fetch();
        if ($row) {
            $c = $pdo->prepare('SELECT COUNT(*) FROM password_resets WHERE user_id = ? AND created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)');
            $c->execute([$row['id']]);
            if ((int)$c->fetchColumn() < 3) {
                $token = bin2hex(random_bytes(32));
                $pdo->prepare('UPDATE password_resets SET used_at = NOW() WHERE user_id = ? AND used_at IS NULL')->execute([$row['id']]);
                $pdo->prepare('INSERT INTO password_resets (user_id, token_hash, expires_at, request_ip) VALUES (?,?,DATE_ADD(NOW(), INTERVAL 1 HOUR),?)')
                    ->execute([$row['id'], hash('sha256', $token), substr((string)($_SERVER['REMOTE_ADDR'] ?? ''), 0, 45)]);
                log_activity('password_reset_requested', 'user', (int)$row['id'], '', (int)$row['id']);
                $link = APP_URL . BASE_URL . '/reset-password.php?token=' . $token;
                $body = "Hello " . $row['full_name'] . ",\n\nWe received a request to reset your PataKazi password.\n"
                      . "Use this link within 1 hour:\n\n$link\n\n"
                      . "If you did not ask for this, ignore this email — your password stays the same.\n\n— PataKazi";
                send_mail($email, 'Reset your PataKazi password', $body);
            }
        }
        $done = true; // same response whether or not the account exists
    }
}
$bodyClass = 'bg-auth';
$pageTitle = 'Forgot password';
require __DIR__ . '/includes/header.php';
?>
<section class="form-card">
  <h1>Forgot your password?</h1>
  <?php if ($done): ?>
    <div class="alert success">If an account exists for that email, we've sent a reset link. It expires in 1 hour. Check your spam folder too.</div>
    <?php if (MAIL_MODE === 'log'): ?><div class="alert info">Dev mode: emails are saved in <code>storage/mail.log</code>.</div><?php endif; ?>
    <p class="center"><a href="<?= url('login.php') ?>">Back to log in</a></p>
  <?php else: ?>
    <p class="muted">Enter your account email and we'll send you a link to choose a new password.</p>
    <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
    <form method="post"><?= csrf_field() ?>
      <label>Email <input type="email" name="email" value="<?= e($email) ?>" required autofocus></label>
      <button class="btn block" type="submit">Send reset link</button>
    </form>
    <p class="center muted"><a href="<?= url('login.php') ?>">Back to log in</a></p>
  <?php endif; ?>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
