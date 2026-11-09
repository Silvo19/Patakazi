<?php
require_once __DIR__ . '/includes/auth.php';
$id = (int)($_GET['id'] ?? 0);
$st = db()->prepare("SELECT l.*, c.name AS category_name, CASE WHEN u.role = 'admin' THEN 'PataKazi' ELSE COALESCE(ep.business_name, u.full_name) END AS poster,
    u.email AS poster_email" . verified_select() . ", u.phone AS poster_phone, ep.description AS poster_about
    FROM listings l JOIN users u ON u.id = l.owner_id
    LEFT JOIN employer_profiles ep ON ep.user_id = l.owner_id
    LEFT JOIN categories c ON c.id = l.category_id WHERE l.id = ?");
$st->execute([$id]);
$l = $st->fetch();
$user = current_user();
$canSee = $l && ($l['status'] === 'approved' || ($user && ($user['role'] === 'admin' || (int)$user['id'] === (int)$l['owner_id'])));
if (!$canSee) { http_response_code(404); $pageTitle = 'Not found'; require __DIR__ . '/includes/header.php'; echo '<div class="empty">This listing is not available.</div>'; require __DIR__ . '/includes/footer.php'; exit; }

$expired = $l['deadline'] && $l['deadline'] < date('Y-m-d');
$open = $l['status'] === 'approved' && !$expired;

if (is_post()) {
    csrf_verify();
    $u = require_login();
    $act = (string)($_POST['action'] ?? '');
    $pdo = db();
    if ($act === 'apply') {
        if ($u['role'] !== 'worker' || $l['type'] === 'service' || !$open || (int)$l['owner_id'] === (int)$u['id']) {
            flash('error', 'You cannot apply to this listing.');
        } else {
            $msg = mb_substr(trim((string)($_POST['message'] ?? '')), 0, 1000);
            $ins = $pdo->prepare('INSERT IGNORE INTO applications (listing_id, worker_id, message) VALUES (?,?,?)');
            $ins->execute([$id, $u['id'], $msg]);
            if ($ins->rowCount()) { log_activity('application_submitted', 'listing', $id, $l['title'], (int)$u['id']); notify((int)$l['owner_id'], 'New applicant 📨', $u['full_name'] . ' applied to ' . $l['title'], applicants_link((int)$l['owner_id'], $id)); referral_check((int)$u['id']); }
            flash($ins->rowCount() ? 'success' : 'info', $ins->rowCount() ? 'Application submitted. Good luck!' : 'You already applied to this listing.');
        }
    } elseif ($act === 'save' && $u['role'] === 'worker') {
        $pdo->prepare('INSERT IGNORE INTO saved_listings (user_id, listing_id) VALUES (?,?)')->execute([$u['id'], $id]);
        flash('success', 'Saved.');
    } elseif ($act === 'unsave') {
        $pdo->prepare('DELETE FROM saved_listings WHERE user_id = ? AND listing_id = ?')->execute([$u['id'], $id]);
        flash('info', 'Removed from saved.');
    } elseif ($act === 'report') {
        $reason = trim((string)($_POST['reason'] ?? ''));
        if (mb_strlen($reason) < 5 || mb_strlen($reason) > 255) flash('error', 'Please describe the problem (5–255 characters).');
        else { $pdo->prepare('INSERT INTO reports (reporter_id, listing_id, reason) VALUES (?,?,?)')->execute([$u['id'], $id, $reason]); log_activity('report_filed', 'listing', $id, mb_substr($reason, 0, 200)); notify_admins('Listing reported 🚩', $l['title'] . ': ' . mb_substr($reason, 0, 100), 'admin/dashboard.php'); flash('success', 'Thanks — our team will review this listing.'); }
    }
    redirect('job-details.php?id=' . $id);
}

$applied = $saved = false;
if ($user) {
    $q = db()->prepare('SELECT 1 FROM applications WHERE listing_id = ? AND worker_id = ?'); $q->execute([$id, $user['id']]); $applied = (bool)$q->fetch();
    $q = db()->prepare('SELECT 1 FROM saved_listings WHERE listing_id = ? AND user_id = ?'); $q->execute([$id, $user['id']]); $saved = (bool)$q->fetch();
}
$pageTitle = $l['title'];
require __DIR__ . '/includes/header.php';
?>
<article class="detail">
  <div class="badges"><span class="badge type-<?= e($l['type']) ?>"><?= e(type_label($l['type'])) ?></span>
    <?php if (!empty($l['verified'])): ?><span class="badge verified">✔ Verified employer</span><?php endif; ?>
    <?php if ($l['status'] !== 'approved'): ?><span class="badge warn"><?= e(ucfirst($l['status'])) ?></span><?php endif; ?></div>
  <h1><?= e($l['title']) ?></h1>
  <p class="muted"><?= e($l['poster']) ?> · <?= e($l['county'] ?: 'Kenya') ?> · <?= e($l['category_name'] ?? 'General') ?> · <?= e(time_ago($l['created_at'])) ?></p>
  <p class="pay big"><?= e(format_pay($l)) ?></p>
  <?php if ($l['deadline']): ?><p class="muted">Deadline: <?= e(date('j M Y', strtotime($l['deadline']))) ?><?= $expired ? ' (closed)' : '' ?></p><?php endif; ?>
  <div class="prose"><?= nl2br(e($l['description'])) ?></div>
  <?php $shareUrl = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . url('job-details.php?id=' . $id); $shareText = $l['title'] . ' on PataKazi'; ?>
  <p class="share"><a class="btn outline small" target="_blank" rel="noopener" href="https://wa.me/?text=<?= rawurlencode($shareText . ' ' . $shareUrl) ?>">Share on WhatsApp</a>
  <button class="btn outline small" type="button" data-share data-title="<?= e($shareText) ?>" data-url="<?= e($shareUrl) ?>">Share…</button></p>

  <div class="actions">
  <?php if (!$user): ?>
    <a class="btn" href="<?= url('login.php?next=' . urlencode('job-details.php?id=' . $id)) ?>">Log in to <?= $l['type'] === 'service' ? 'contact' : 'apply' ?></a>
  <?php elseif ($l['type'] === 'service'): ?>
    <div class="card"><strong>Contact</strong><p><?= e($l['poster_email']) ?><?= $l['poster_phone'] ? ' · ' . e($l['poster_phone']) : '' ?></p>
      <?php if ($user['role'] !== 'admin' && (int)$user['id'] !== (int)$l['owner_id']): ?><form method="post" action="<?= url('messages/start.php') ?>"><?= csrf_field() ?><input type="hidden" name="listing_id" value="<?= (int)$l['id'] ?>"><button class="btn small" type="submit">💬 Message on PataKazi</button></form><?php endif; ?>
      <p class="small muted">Agree terms clearly before paying anyone. PataKazi does not guarantee outcomes.</p></div>
  <?php elseif ($user['role'] === 'worker' && $open && (int)$l['owner_id'] !== (int)$user['id']): ?>
    <?php if ($applied): ?><div class="alert info">You have applied to this listing. Track it in <a href="<?= url('worker/applications.php') ?>">your applications</a>.</div>
    <?php else: ?>
      <form method="post" class="card"><?= csrf_field() ?><input type="hidden" name="action" value="apply">
        <label>Message to the employer (optional)<textarea name="message" rows="4" maxlength="1000"></textarea></label>
        <button class="btn" type="submit">Apply now</button></form>
    <?php endif; ?>
  <?php endif; ?>

  <?php if ($user && $user['role'] === 'worker'): ?>
    <form method="post"><?= csrf_field() ?><input type="hidden" name="action" value="<?= $saved ? 'unsave' : 'save' ?>">
      <button class="btn outline" type="submit"><?= $saved ? '★ Saved' : '☆ Save for later' ?></button></form>
  <?php endif; ?>
  </div>

  <?php if ($user && (int)$user['id'] !== (int)$l['owner_id']): ?>
  <details class="report"><summary>Report this listing</summary>
    <form method="post"><?= csrf_field() ?><input type="hidden" name="action" value="report">
      <label>What is wrong? (scam, asks for payment, misleading…)<textarea name="reason" rows="3" maxlength="255" required></textarea></label>
      <button class="btn outline small" type="submit">Submit report</button></form>
  </details>
  <?php endif; ?>
</article>
<?php require __DIR__ . '/includes/footer.php'; ?>
