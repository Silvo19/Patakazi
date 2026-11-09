# PataKazi — setup (XAMPP)
1. Copy this folder to `C:\xampp\htdocs\PataKazi` (keep the folder name, or change `BASE_URL` in includes/functions.php).
2. Start Apache + MySQL in XAMPP. In phpMyAdmin, import `database/patakazi.sql`.
3. Open http://localhost/PataKazi/setup/create-admin.php, create your admin (the link also shows on the login page). The setup folder then deletes itself.
4. Open http://localhost/PataKazi/

Flow: employers/freelancers post → admin approves in Admin > Listings → live on the site.
Before going live: set a real MySQL password in config/database.php, enable HTTPS, turn off display_errors.

## Password reset
- Already imported the first SQL? Run `database/migration-password-reset.sql` once in phpMyAdmin.
- Edit `config/mail.php`. Default `MAIL_MODE = 'log'` saves emails to `storage/mail.log` — open it to copy the reset link while testing.
- For real emails use `'smtp'` (Gmail needs an App Password) and set `APP_URL` to your live address.

## Account & payments
- Users can change their password at *Password* in the menu (other devices are signed out).
- Already imported an older SQL? Run `database/migration-payments.sql` once.
- M-Pesa: fill `config/daraja.php` (Consumer Key/Secret). Locally run `ngrok http 80` and set `DARAJA_CALLBACK_BASE` to the https URL it gives you.
- Test: log in as employer, get a listing approved, press ★ Feature. Sandbox does not prompt a real phone; it returns a simulated result.
- Logs: `storage/daraja.log`. Prices: `featured_plans()` in `config/daraja.php`.
- Go-live: apply for a production shortcode/passkey with Safaricom, set `DARAJA_ENV='production'`, use HTTPS on your real domain.

## Admin control
- Admin has its own menu and never sees worker/employer pages. *View site* previews the public site.
- *Admin > Settings*: pause sign-ups, jobs, tasks or services, auto-publish, per-user listing limit, featured prices, site announcement.
- *Admin > + Post*: publish jobs/tasks/services as PataKazi (live instantly). Others can keep posting normally.
- Already imported an older SQL? Run `database/migration-settings.sql` once.

## Wallet, withdrawals & activity
- Already imported an older SQL? Run `database/migration-wallet.sql` once (wallet, withdrawals, activity log).
- Users: **Wallet** in the menu — deposit by M-Pesa, pay for featuring from balance, withdraw (needs password, admin-reviewed).
- Admin: **Withdrawals** (approve & pay via M-Pesa B2C, or pay manually and enter the receipt; reject = automatic refund), **Progress** (pipelines + needs-attention), **Activity** (full log of every action).
- Automatic payouts need B2C details in `config/daraja.php` and Safaricom's certificate in `config/cert/`. Without them, pay users yourself and press *Mark paid*.

## Upgrade (v2)
- Run `database/migration-upgrade.sql` once if you imported an older SQL (notifications + admin payouts).
- **Admin > 💸 Profits**: revenue vs money owed to users, 30-day chart, books-balance check, and your own payout flow (password + emailed 6-digit code; B2C or manual). Exports under each table.
- **Modern features**: dark mode, installable app (PWA: manifest + service worker + icons), notification bell and mobile tab bar, share to WhatsApp, CSV exports.
- Set `MAIL_MODE`/SMTP in `config/mail.php` so payout codes reach your inbox (dev mode writes them to `storage/mail.log`). For install-as-app, the site must be served over HTTPS (localhost also works).

## v3: chat, employer plans, suggestions
- Run `database/migration-v3.sql` once if you imported an older SQL (chat + subscriptions).
- **Chat**: employer <-> applicant (once someone has applied) and anyone <-> freelancer on service listings. Messages page, bell alerts, 4-second live updates, rate-limited.
- **Employer plans** (Free / Business / Pro, 30 days each): listing limits, featuring discount, Verified badge, search priority, applicant CSV export. Paid by wallet or M-Pesa; admin sets prices/limits in Settings and can grant/revoke under *Employer plans*. Plan revenue is counted in Profits.
- Free employers are limited to 3 active listings by default (Settings > Employer plans; 0 = unlimited).
- Live search suggestions as you type.

## v4: referrals, backgrounds, demo accounts
- Run `database/migration-v4.sql` once if you imported an older SQL (referral codes + rewards).
- **Refer & earn**: every member has a code/link. A referred job seeker qualifies after completing their profile and applying; a referred employer after their first listing is approved. Both sides get wallet credit (amounts, welcome bonus and monthly cap in Settings). Admin: *Referrals* page; rewards are subtracted as a cost on Profits.
- **Backgrounds**: generated mesh-gradient images in `assets/images/` (hero, login, banners) with a frosted-glass login card.
- **Demo accounts**: open `http://localhost/PataKazi/demo/` and press *Load demo data* (password for every account: `Demo@12345`). Quick-login buttons appear on the login page on localhost. **Delete the `demo` folder before going live.**

## v5: KSh 500 referrals + platform fee
- Run `database/migration-v5.sql` once if you imported an older SQL (posting fee, refunds). Until then the fee is simply switched off.
- **Referral reward is KSh 500** for every qualified referral (job seeker or employer), plus a KSh 20 welcome bonus for the new member. If you saved Settings earlier, update the old amounts there (Settings > Referral rewards).
- **Posting fee**: employers pay a platform fee of at least 20% of the pay (default 20%) when posting a job or task. The listing waits for payment (wallet or M-Pesa), then goes to review (or live with auto-approve). If you reject the listing, the fee is refunded to their wallet automatically. Turn on/off and set the % in Settings > Platform fees.
- Optional **withdrawal fee %** (default 0) sits next to it, in case you also want to take a cut when users cash out.
