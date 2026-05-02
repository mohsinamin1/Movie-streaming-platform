# Movie Streaming Platform (Schema Unchanged)

## Stack
- PHP 8+
- MySQL
- HTML/CSS/JS

## Setup
1. Create database and import your original schema SQL file.
2. Edit `app/config/config.php` with your DB credentials.
3. Run seed scripts:
   - `scripts/seed_admin_user.sql`
   - `scripts/seed_sample_data.sql`
4. Serve project from local server (XAMPP/WAMP) and open `/public`.

## Default Admin Rule
- Admin email: admin@example.com
- Admin password: admin123
- Any logged-in user with username `admin` is treated as admin.

## Reviews Without Schema Change
- Reviews are stored in `notifications.message` JSON payload with `type='recommendation'`.
- Status flow: `pending` -> `approved` or `rejected`.
