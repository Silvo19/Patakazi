<?php
require_once __DIR__ . '/includes/auth.php';
$user = require_role('employer', 'worker');
$pageTitle = 'Refer & earn';
require __DIR__ . '/includes/header.php';
if (!referrals_ready()): ?><div class="alert error">Referrals aren't set up yet. The site owner must run <code>database/migration-v4.sql</code>.</div>
<?php require __DIR__ . '/includes/footer.php'; exit; endif;
if (!setting_on('referrals_enabled')): ?><div class="alert info">The referral programme is paused right now.</div>
<?php require __DIR__ . '/includes/footer.php'; exit; endif;

$me = (int)$user['id'];
$code = ensure_referral_code($me);
$link = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . url('register.php?ref=' . $code);
$rw = (int)setting('ref_worker_reward'); $re = (int)setting('ref_employer_reward'); $wb = (int)setting('ref_welcome_bonus');
$st = db()->prepare("SELECT r.*, u.full_name FROM referrals r JOIN users u ON u.id = r.referred_id WHERE r.referrer_id = ? ORDER BY r.id DESC LIMIT 100");
$st->execute([$me]); $rows = $st->fetchAll();
$earned = array_sum(array_map(fn($r) => $r['status'] === 'rewarded' ? (float)$r['reward_amount'] : 0, $rows));
$pending = count(array_filter($rows, fn($r) => $r['status'] === 'pending'));
$mask = function (string $n): string { $p = preg_split('/\s+/', trim($n)); return $p[0] . (isset($p[1]) ? ' ' . mb_strtoupper(mb_substr($p[1], 0, 1)) . '.' : ''); };
$shareText = ($user['role'] === 'employer' ? 'Hire (and find) talent on PataKazi — ' : 'Find jobs, tasks and gigs on PataKazi — ') . 'join with my code ' . $code . ': ' . $link;
?>
<h1>🎁 Refer &amp; earn</h1>
<p class="muted">Invite people you know. When they get going on PataKazi, <strong>you both get money in your wallet</strong>.</p>

<div class="card refcard center">
  <span class="muted">Your referral code</span>
  <div class="refcode"><?= e($code) ?></div>
  <p class="small break"><?= e($link) ?></p>
  <div class="row-inline" style="justify-content:center">
    <button type="button" class="btn small" data-copy="<?= e($link) ?>">Copy link</button>
    <a class="btn outline small" target="_blank" rel="noopener" href="https://wa.me/?text=<?= rawurlencode($shareText) ?>">WhatsApp</a>
    <button type="button" class="btn outline small" data-share data-title="Join PataKazi" data-url="<?= e($link) ?>">Share…</button>
  </div>
</div>

<div class="stats">
  <div class="stat"><strong><?= count($rows) ?></strong><span>People invited</span></div>
  <div class="stat"><strong><?= $pending ?></strong><span>Waiting to qualify</span></div>
  <div class="stat"><strong>KSh <?= number_format($earned) ?></strong><span>You've earned</span></div>
</div>

<section class="card"><h2>How rewards work</h2>
  <ul class="ticks">
    <li><b>Invite a job seeker / freelancer:</b> when they complete their profile (headline + skills) and apply to their first opportunity, you earn <b>KSh <?= number_format($rw) ?></b>.</li>
    <li><b>Invite an employer:</b> when their first job, task or service listing is approved, you earn <b>KSh <?= number_format($re) ?></b>. <?= $user['role'] === 'employer' ? 'Great for businesses you work with!' : '' ?></li>
    <?php if ($wb > 0): ?><li><b>They get a welcome bonus</b> of KSh <?= number_format($wb) ?> in their wallet too.</li><?php endif; ?>
    <li>Rewards go straight to your <a href="<?= url('wallet/index.php') ?>">wallet</a>. Spend them on featuring or withdraw to M-Pesa.</li>
  </ul>
  <p class="small muted">One reward per person invited. Fake or self-referred accounts are voided. There is a limit of <?= (int)setting('ref_monthly_cap') ?: 'no' ?> rewards per 30 days.</p></section>

<h2>People you invited</h2>
<?php if ($rows): ?><div class="table-wrap"><table class="table"><tr><th>Who</th><th>Joined as</th><th>Status</th><th>Your reward</th></tr>
<?php foreach ($rows as $r): ?><tr><td><?= e($mask($r['full_name'])) ?><br><small class="muted"><?= e(date('j M Y', strtotime($r['created_at']))) ?></small></td>
<td><?= $r['role'] === 'employer' ? 'Employer' : 'Job seeker' ?></td>
<td><span class="badge s-<?= $r['status'] === 'rewarded' ? 'approved' : ($r['status'] === 'void' ? 'rejected' : 'pending') ?>"><?= e($r['status'] === 'pending' ? 'Waiting' : ucfirst($r['status'])) ?></span><?= $r['note'] ? '<br><small class="muted">' . e($r['note']) . '</small>' : '' ?></td>
<td><?= $r['status'] === 'rewarded' ? '+KSh ' . number_format((float)$r['reward_amount']) : '—' ?></td></tr><?php endforeach; ?></table></div>
<?php else: ?><div class="empty">No one yet — share your link above to get started.</div><?php endif; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>
