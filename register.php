<?php
require_once __DIR__ . '/includes/auth.php';
if ($u = current_user()) redirect(dashboard_path($u['role']));
if (!setting_on('registration_open')) {
    $pageTitle = 'Sign-ups closed';
    require __DIR__ . '/includes/header.php';
    echo '<section class="form-card"><h1>Sign-ups are closed for now</h1><p class="muted">New accounts are paused. Please check back soon, or <a href="' . url('login.php') . '">log in</a> if you already have an account.</p></section>';
    require __DIR__ . '/includes/footer.php';
    exit;
}

$errors = [];
$old = ['full_name' => '', 'email' => '', 'phone' => '', 'role' => 'worker', 'business_name' => '', 'ref' => ''];
$old['ref'] = (string)($_SESSION['ref'] ?? '');

if (is_post()) {
    csrf_verify();
    foreach ($old as $k => $_) $old[$k] = trim((string)($_POST[$k] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    $confirm  = (string)($_POST['confirm'] ?? '');

    if (mb_strlen($old['full_name']) < 3 || mb_strlen($old['full_name']) > 120) $errors[] = 'Enter your full name.';
    if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Enter a valid email address.';
    $phone = null;
    if ($old['phone'] !== '') {
        $phone = normalize_phone($old['phone']);
        if (!$phone) $errors[] = 'Enter a valid Kenyan phone number (e.g. 0712345678).';
    }
    if (!in_array($old['role'], ['worker', 'employer'], true)) $errors[] = 'Choose an account type.';
    if ($old['role'] === 'employer' && mb_strlen($old['business_name']) < 2) $errors[] = 'Enter your business name.';
    $refUserId = 0;
    if ($old['ref'] !== '' && referrals_ready()) {
        $rf = db()->prepare("SELECT id FROM users WHERE referral_code = ? AND status = 'active'");
        $rf->execute([strtoupper($old['ref'])]); $refUserId = (int)$rf->fetchColumn();
        if (!$refUserId) $errors[] = 'That referral code is not valid. Clear the box to continue without one.';
    }
    if (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password))
        $errors[] = 'Password must be at least 8 characters with letters and numbers.';
    if ($password !== $confirm) $errors[] = 'Passwords do not match.';

    if (!$errors) {
        $st = db()->prepare('SELECT id FROM users WHERE email = ?');
        $st->execute([strtolower($old['email'])]);
        if ($st->fetch()) $errors[] = 'An account with that email already exists.';
    }
    if (!$errors) {
        $pdo = db();
        try {
            $pdo->beginTransaction();
            $params = [$old['full_name'], strtolower($old['email']), $phone, password_hash($password, PASSWORD_DEFAULT), $old['role']];
            $cols = 'full_name, email, phone, password_hash, role'; $marks = '?,?,?,?,?';
            if (referrals_ready()) { $cols .= ', referral_code'; $marks .= ',?'; $params[] = new_referral_code(); }
            $pdo->prepare("INSERT INTO users ($cols) VALUES ($marks)")->execute($params);
            $id = (int)$pdo->lastInsertId();
            if ($refUserId) create_referral($refUserId, $id, $old['role']);
            if ($old['role'] === 'worker') $pdo->prepare('INSERT INTO worker_profiles (user_id) VALUES (?)')->execute([$id]);
            else $pdo->prepare('INSERT INTO employer_profiles (user_id, business_name) VALUES (?,?)')->execute([$id, $old['business_name']]);
            $pdo->commit();
            login_user(['id' => $id]);
            log_activity('user_registered', 'user', $id, $old['role'] . ': ' . $old['full_name'], $id);
            flash('success', 'Welcome to PataKazi! Complete your profile to get started.');
            redirect($old['role'] === 'worker' ? 'worker/profile.php' : 'employer/dashboard.php');
        } catch (PDOException $ex) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            $errors[] = 'Could not create your account. Please try again.';
        }
    }
}
$bodyClass = 'bg-auth';
$pageTitle = 'Create your account';
require __DIR__ . '/includes/header.php';
?>
<section class="form-card">
  <h1>Create your account</h1>
  <?php foreach ($errors as $er): ?><div class="alert error"><?= e($er) ?></div><?php endforeach; ?>
  <form method="post" novalidate>
    <?= csrf_field() ?>
    <label>I am a
      <select name="role" data-role-toggle>
        <option value="worker" <?= $old['role'] === 'worker' ? 'selected' : '' ?>>Job seeker / freelancer</option>
        <option value="employer" <?= $old['role'] === 'employer' ? 'selected' : '' ?>>Employer / business</option>
      </select>
    </label>
    <label data-employer-only>Business name
      <input type="text" name="business_name" value="<?= e($old['business_name']) ?>" maxlength="150">
    </label>
    <label>Full name <input type="text" name="full_name" value="<?= e($old['full_name']) ?>" required maxlength="120"></label>
    <label>Email <input type="email" name="email" value="<?= e($old['email']) ?>" required></label>
    <label>Phone (optional) <input type="tel" name="phone" value="<?= e($old['phone']) ?>" placeholder="0712345678"></label>
    <label>Password <input type="password" name="password" required minlength="8" autocomplete="new-password"></label>
    <label>Confirm password <input type="password" name="confirm" required autocomplete="new-password"></label>
    <?php if (setting_on('referrals_enabled')): ?><label>Referral code (optional) <input type="text" name="ref" value="<?= e($old['ref']) ?>" maxlength="12" style="text-transform:uppercase" placeholder="e.g. K7M2XQP"></label><?php endif; ?>
    <button class="btn block" type="submit">Create account</button>
  </form>
  <p class="center muted">Already registered? <a href="<?= url('login.php') ?>">Log in</a></p>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
