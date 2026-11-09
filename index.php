<?php
require_once __DIR__ . '/includes/auth.php';
$user = current_user();
if ($user && $user['role'] === 'admin' && ($_GET['view'] ?? '') !== 'site') redirect('admin/dashboard.php');
$one = function (string $sql): int { try { return (int)db()->query($sql)->fetchColumn(); } catch (Throwable $e) { return 0; } };
$live = $one("SELECT COUNT(*) FROM listings WHERE status = 'approved' AND (deadline IS NULL OR deadline >= CURDATE())");
$workers = $one("SELECT COUNT(*) FROM users WHERE role = 'worker' AND status = 'active'");
$employers = $one("SELECT COUNT(*) FROM users WHERE role = 'employer' AND status = 'active'");
$cats = db()->query("SELECT c.id, c.name, COUNT(l.id) n FROM categories c
    LEFT JOIN listings l ON l.category_id = c.id AND l.status = 'approved'
    GROUP BY c.id ORDER BY n DESC, c.name LIMIT 8")->fetchAll();
$recent = search_listings(['per_page' => 6])['rows'];
$recommended = ($user && $user['role'] === 'worker') ? recommended_for((int)$user['id'], 4) : [];
$plans = featured_plans();
$walletOn = setting_on('wallet_enabled');
$minWd = (int)setting('min_withdrawal'); $wdFee = (int)setting('withdrawal_fee'); $wdPct = (int)setting('withdrawal_fee_percent');
$site = (($_GET['view'] ?? '') === 'site');
$pageTitle = 'Your Opportunities, Your Future';
require __DIR__ . '/includes/header.php';
?>
<section class="hero">
  <h1>Find work. Find talent.<br>Pata Kazi.</h1>
  <p>Jobs, short-term tasks and freelance services from across Kenya, in one place that works on your phone.</p>
  <form class="search" action="<?= url('opportunities.php') ?>" method="get">
    <?php if ($site): ?><input type="hidden" name="view" value="site"><?php endif; ?>
    <input type="search" name="q" placeholder="Search jobs, tasks, services…" aria-label="Search">
    <select name="type" aria-label="Type"><option value="">All</option><option value="job">Jobs</option><option value="task">Tasks</option><option value="service">Services</option></select>
    <button class="btn" type="submit">Search</button>
  </form>
  <?php if (!$user): ?><a class="btn gold" href="<?= url('register.php') ?>">Register free</a> <a class="btn outline light" href="#how">How it works</a><?php endif; ?>
</section>

<div class="stats">
  <div class="stat"><strong><?= $live ?></strong><span>Live opportunities</span></div>
  <div class="stat"><strong><?= $workers ?></strong><span>Job seekers &amp; freelancers</span></div>
  <div class="stat"><strong><?= $employers ?></strong><span>Employers</span></div>
</div>

<?php if ($recommended): ?>
<section><h2>Recommended for you</h2><div class="grid"><?php foreach ($recommended as $l) echo listing_card($l); ?></div></section>
<?php endif; ?>

<section id="about">
  <h2>What is PataKazi?</h2>
  <p>PataKazi is a Kenyan marketplace that connects people who need work done with people who can do it. You can find a <strong>job</strong>, pick up a <strong>short-term task</strong>, or offer your skills as a <strong>freelance service</strong>. Employers post openings, review applicants and choose the right person — all from a phone or computer.</p>
  <div class="features">
    <div class="feature"><b>💼 Jobs</b><p>Full-time and part-time vacancies from employers across Kenya's counties.</p></div>
    <div class="feature"><b>⚡ Tasks</b><p>Short, one-off pieces of work with a clear price — great for quick income.</p></div>
    <div class="feature"><b>🛠️ Services</b><p>Freelancers list what they offer and clients contact them directly.</p></div>
    <div class="feature"><b>👤 Profiles</b><p>Workers add skills and experience once, and apply in a tap.</p></div>
    <div class="feature"><b>📊 Tracking</b><p>See every application move from Submitted to Reviewed, Shortlisted and Selected.</p></div>
    <div class="feature"><b>🔖 Saved listings</b><p>Bookmark opportunities and come back to them later.</p></div>
    <div class="feature"><b>★ Featured listings</b><p>Employers and freelancers can promote a listing to the top of results.</p></div>
    <?php if ($walletOn): ?><div class="feature"><b>💰 M-Pesa wallet</b><p>Top up by M-Pesa, spend instantly, and withdraw back to your phone.</p></div><?php endif; ?>
    <div class="feature"><b>🛡️ Safety checks</b><p>Listings can be reviewed by our team, and anyone can report a suspicious post.</p></div>
  </div>
</section>

<section id="how">
  <h2>How it works</h2>
  <div class="two-col">
    <div class="card"><h3>If you're looking for work</h3>
      <ol class="steps"><li><b>Create a free account</b> as a job seeker / freelancer.</li><li><b>Build your profile</b> with your headline, skills, county and experience.</li><li><b>Search or get recommendations</b> matched to your skills, then apply with one tap.</li><li><b>Track your applications</b> and get chosen by employers.</li></ol>
      <a class="btn" href="<?= url('register.php') ?>">Start as a worker</a></div>
    <div class="card"><h3>If you're hiring</h3>
      <ol class="steps"><li><b>Register a business account</b> with your business name.</li><li><b>Post a job or task</b> with pay, county and deadline.</li><li><b>Review applicants</b> and move them through shortlisted to selected.</li><li><b>Boost visibility</b> by featuring your listing when you need more reach.</li></ol>
      <a class="btn gold" href="<?= url($user && $user['role'] === 'employer' ? 'employer/post-job.php' : 'register.php') ?>">Post a job</a></div>
  </div>
</section>

<?php if ($walletOn): ?>
<section id="wallet">
  <h2>Your PataKazi wallet</h2>
  <div class="card">
    <p>Keep money in your wallet to pay for featured listings instantly, without waiting for an M-Pesa prompt each time.</p>
    <ul>
      <li><b>Deposit</b> any amount from KSh 10 with an M-Pesa prompt on your phone.</li>
      <li><b>Spend</b> from your balance on featured listings.</li>
      <li><b>Withdraw</b> your unused balance to your M-Pesa (minimum KSh <?= number_format($minWd) ?>; <?= ($wdFee > 0 || $wdPct > 0) ? 'fee ' . implode(', ', array_filter([$wdPct > 0 ? $wdPct . '% of the amount' : '', $wdFee > 0 ? ($wdPct > 0 ? 'minimum ' : '') . 'KSh ' . number_format($wdFee) : ''])) . ' per withdrawal' : 'no withdrawal fee' ?>). Withdrawals get a quick security review first, and need your password.</li>
    </ul>
    <p class="small muted">Every wallet movement appears in your history, so you can always see where your money went.</p>
  </div>
</section>
<?php endif; ?>

<section id="pricing">
  <h2>What does it cost?</h2>
  <div class="card">
    <p><strong>Job seekers never pay</strong> to see opportunities or apply.<?php if (setting_on('posting_fee_enabled') && fees_ready()): ?> Employers pay a platform fee of <strong><?= posting_fee_percent() ?>% of the pay</strong> when they post a job or task (refunded if we don't approve it).<?php else: ?> Posting is free for employers, too.<?php endif; ?> Optional extras:</p>
    <div class="plans">
      <?php foreach ($plans as $d => $p): ?><div class="plan"><strong>★ Featured <?= e($p['label']) ?></strong><span>KSh <?= number_format($p['price']) ?></span></div><?php endforeach; ?>
    </div>
    <p class="small muted">Featuring puts your listing first in search results with a gold badge. It improves visibility; it does not guarantee applicants, hires or earnings.</p>
  </div>
</section>

<section id="safety">
  <h2>Staying safe</h2>
  <div class="card"><ul>
    <li>A real employer will <b>never ask you to pay</b> to get a job. If a listing does, report it.</li>
    <li>Listings are checked by our team before they go live (when review is switched on).</li>
    <li>Use the <b>Report</b> button on any listing — we investigate every report.</li>
    <li>Passwords are stored securely, and we sign you out of other devices when you change your password.</li>
  </ul><p class="small muted">PataKazi connects people with opportunities. We do not guarantee employment or earnings.</p></div>
</section>

<?php if (setting_on('referrals_enabled')): ?>
<section id="refer"><div class="card refer-band">
  <h2>🎁 Refer a friend, earn money</h2>
  <p>Invite a job seeker and earn <b>KSh <?= number_format((int)setting('ref_worker_reward')) ?></b> when they apply to their first opportunity. Invite an employer and earn <b>KSh <?= number_format((int)setting('ref_employer_reward')) ?></b> when their first listing goes live.<?= (int)setting('ref_welcome_bonus') > 0 ? ' New members get a KSh ' . number_format((int)setting('ref_welcome_bonus')) . ' welcome bonus too.' : '' ?></p>
  <a class="btn gold" href="<?= url($user ? 'referrals.php' : 'register.php') ?>"><?= $user ? 'Get my referral link' : 'Join and start earning' ?></a>
</div></section>
<?php endif; ?>
<section id="faq">
  <h2>Common questions</h2>
  <details class="faq"><summary>Is PataKazi free?</summary><p>Yes for job seekers. <?= (setting_on('posting_fee_enabled') && fees_ready()) ? 'Employers pay a ' . posting_fee_percent() . '% platform fee on the pay when posting a job or task; featuring and plans are optional.' : 'Employers post for free; paid featuring is optional.' ?></p></details>
  <details class="faq"><summary>Who can post services?</summary><p>Any registered freelancer. Clients see your contact details once they log in.</p></details>
  <details class="faq"><summary>How do I get paid for work?</summary><p>Agree the terms directly with the employer or client. PataKazi does not currently hold payments between users, so only pay or accept payment for work you are confident about.</p></details>
  <?php if ($walletOn): ?><details class="faq"><summary>How long do withdrawals take?</summary><p>Requests are reviewed by our team, then sent to your M-Pesa. You can follow each step in your wallet.</p></details><?php endif; ?>
  <details class="faq"><summary>I forgot my password.</summary><p>Use “Forgot your password?” on the login page and we'll email you a reset link.</p></details>
</section>

<section>
  <h2>Popular categories</h2>
  <div class="chips"><?php foreach ($cats as $c): ?><a class="chip" href="<?= url('opportunities.php?category=' . (int)$c['id'] . ($site ? '&view=site' : '')) ?>"><?= e($c['name']) ?> <small>(<?= (int)$c['n'] ?>)</small></a><?php endforeach; ?></div>
</section>

<section>
  <h2>Recently published</h2>
  <?php if ($recent): ?><div class="grid"><?php foreach ($recent as $l) echo listing_card($l); ?></div>
  <?php else: ?><p class="muted">No opportunities yet — be the first to post one.</p><?php endif; ?>
  <p><a href="<?= url('opportunities.php' . ($site ? '?view=site' : '')) ?>">Browse all opportunities →</a></p>
</section>

<?php if (!$user): ?>
<section class="cta"><h2>Ready to get started?</h2><p>Create your free account in a minute.</p>
  <a class="btn" href="<?= url('register.php') ?>">Register free</a> <a class="btn outline" href="<?= url('login.php') ?>">Log in</a></section>
<?php endif; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>
