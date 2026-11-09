<?php
require_once __DIR__ . '/includes/auth.php';
$user = require_login();
$ok = true; $items = [];
if (is_post()) {
    csrf_verify();
    try {
        if (($_POST['action'] ?? '') === 'clear') db()->prepare('DELETE FROM notifications WHERE user_id = ?')->execute([$user['id']]);
        else db()->prepare('UPDATE notifications SET is_read = 1 WHERE user_id = ?')->execute([$user['id']]);
    } catch (Throwable $e) { }
    redirect('notifications.php');
}
try {
    $st = db()->prepare('SELECT * FROM notifications WHERE user_id = ? ORDER BY id DESC LIMIT 50'); $st->execute([$user['id']]); $items = $st->fetchAll();
    db()->prepare('UPDATE notifications SET is_read = 1 WHERE user_id = ?')->execute([$user['id']]); // opening the page marks them read
} catch (Throwable $e) { $ok = false; }
$pageTitle = 'Notifications';
require __DIR__ . '/includes/header.php';
?>
<h1>🔔 Notifications</h1>
<?php if (!$ok): ?><div class="alert error">Notifications aren't set up yet. The site owner must run <code>database/migration-upgrade.sql</code>.</div>
<?php elseif ($items): ?>
<form method="post" class="row-inline"><?= csrf_field() ?><button class="btn outline small" name="action" value="clear" data-confirm-btn>Clear all</button></form>
<ul class="timeline">
<?php foreach ($items as $n): $valid = $n['link'] && preg_match('/^[a-zA-Z0-9_\-\/]+\.php(\?[a-zA-Z0-9=&_\-]*)?$/', $n['link']); ?>
  <li class="<?= $n['is_read'] ? '' : 'unread' ?>"><span class="ico"><?= $n['is_read'] ? '•' : '🔵' ?></span><div>
    <strong><?= $valid ? '<a href="' . e(url($n['link'])) . '">' . e($n['title']) . '</a>' : e($n['title']) ?></strong>
    <div class="small"><?= e((string)$n['body']) ?></div><div class="small muted"><?= e(time_ago($n['created_at'])) ?></div></div></li>
<?php endforeach; ?></ul>
<?php else: ?><div class="empty">You're all caught up. Updates about your applications, payments and listings appear here.</div><?php endif; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>
