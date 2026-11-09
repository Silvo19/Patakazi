<?php
require_once __DIR__ . '/includes/auth.php';
if ($u = current_user()) redirect(dashboard_path($u['role']));

$error = '';
$email = '';
if (is_post()) {
    csrf_verify();
    $email = strtolower(trim((string)($_POST['email'] ?? '')));
    $password = (string)($_POST['password'] ?? '');
    if (($_SESSION['lock_until'] ?? 0) > time()) {
        $error = 'Too many attempts. Please wait a few minutes and try again.';
    } else {
        $st = db()->prepare('SELECT id, password_hash, role, status FROM users WHERE email = ?');
        $st->execute([$email]);
        $row = $st->fetch();
        $hash = $row['password_hash'] ?? password_hash('dummy-password', PASSWORD_DEFAULT); // constant-ish timing
        $ok = password_verify($password, $hash) && $row;
        if ($ok && $row['status'] !== 'active') {
            $error = 'This account has been suspended. Contact support.';
        } elseif ($ok) {
            unset($_SESSION['fails'], $_SESSION['lock_until']);
            if (password_needs_rehash($row['password_hash'], PASSWORD_DEFAULT))
                db()->prepare('UPDATE users SET password_hash = ? WHERE id = ?')->execute([password_hash($password, PASSWORD_DEFAULT), $row['id']]);
            login_user($row);
            log_activity('login', 'user', (int)$row['id'], '', (int)$row['id']);
            $next = (string)($_GET['next'] ?? '');
            if (preg_match('/^[a-zA-Z0-9_\-\/]+\.php(\?[a-zA-Z0-9=&_\-]*)?$/', $next)) redirect($next);
            redirect(dashboard_path($row['role']));
        } else {
            $_SESSION['fails'] = ($_SESSION['fails'] ?? 0) + 1;
            if ($_SESSION['fails'] >= 5) { $_SESSION['lock_until'] = time() + 300; $_SESSION['fails'] = 0; }
            log_activity('login_failed', 'user', null, 'email: ' . mb_substr($email, 0, 100), null);
            $error = 'Incorrect email or password.';
        }
    }
}
$noAdmin = is_dir(__DIR__ . '/setup')
    && in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true)
    && (int)db()->query("SELECT COUNT(*) FROM users WHERE role = 'admin'")->fetchColumn() === 0;
$demoBox = in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true);
if ($demoBox) { try { $demoBox = (int)db()->query("SELECT COUNT(*) FROM users WHERE email LIKE '%@patakazi.demo'")->fetchColumn() > 0; } catch (Throwable $e) { $demoBox = false; } }
$bodyClass = 'bg-auth';
$pageTitle = 'Log in';
require __DIR__ . '/includes/header.php';
?>
<?php if ($noAdmin): ?>
<div class="alert info"><strong>First time here?</strong> No administrator exists yet. <a href="<?= url('setup/create-admin.php') ?>">Create the admin account →</a></div>
<?php endif; ?>
<section class="form-card">
  <h1>Welcome back</h1>
  <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
  <form method="post">
    <?= csrf_field() ?>
    <label>Email <input type="email" name="email" value="<?= e($email) ?>" required autofocus></label>
    <label>Password <input type="password" name="password" required autocomplete="current-password"></label>
    <p class="small"><a href="<?= url('forgot-password.php') ?>">Forgot your password?</a></p>
    <button class="btn block" type="submit">Log in</button>
  </form>
  <p class="center muted">New here? <a href="<?= url('register.php') ?>">Create an account</a></p>
</section>
<?php if ($demoBox): ?>
<section class="form-card card demo-box"><strong>🎭 Demo accounts</strong> <span class="small muted">(password: Demo@12345)</span>
  <div class="row-inline">
    <?php foreach (['admin@patakazi.demo' => 'Admin', 'pro@patakazi.demo' => 'Employer Pro', 'business@patakazi.demo' => 'Employer Business', 'employer@patakazi.demo' => 'Employer Free', 'worker@patakazi.demo' => 'Job seeker', 'worker2@patakazi.demo' => 'Job seeker 2', 'freelancer@patakazi.demo' => 'Freelancer'] as $em => $lbl): ?>
      <button type="button" class="btn outline small" data-demo="<?= e($em) ?>"><?= e($lbl) ?></button><?php endforeach; ?>
  </div></section>
<script>
document.querySelectorAll('[data-demo]').forEach(function (b) { b.addEventListener('click', function () {
  document.querySelector('input[name=email]').value = b.dataset.demo; document.querySelector('input[name=password]').value = 'Demo@12345';
  document.querySelector('form[method=post] button[type=submit]').focus(); }); });
</script>
<?php endif; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>
