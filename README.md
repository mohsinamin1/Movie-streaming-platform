# Movie Streaming Platform (Schema Unchanged)

## Stack
- PHP 8+
- MySQL
- HTML/CSS/JS

## Setup
1. Place the project in your Apache `htdocs` folder, for example:

   - `c:\xampp\htdocs\Movie-streaming-platform`

2. Start Apache and MySQL using the XAMPP Control Panel.

3. Create the database and import the schema using phpMyAdmin (step-by-step):

   - Open: http://localhost/phpmyadmin
   - Click **Databases** → create database name: `movie_streaming` → Collation: `utf8mb4_unicode_ci` → **Create**
   - Select the `movie_streaming` database in the left sidebar → **Import** → Browse to `c:\xampp\htdocs\Movie-streaming-platform\scripts\movie_streaming_platform.sql` → **Go**

4. Import seed data (order matters):

   - Import `c:\xampp\htdocs\Movie-streaming-platform\scripts\seed_admin_user.sql` → **Go**
   - Import `c:\xampp\htdocs\Movie-streaming-platform\scripts\seed_sample_data.sql` → **Go**

5. Create the join tables (if not present):

   - Import `c:\xampp\htdocs\Movie-streaming-platform\scripts\add-relationships.sql` (creates movie_cast, movie_genres, movie_tags, series_cast, series_genres, series_tags)

6. Update application configuration:

   - Edit `app/config/config.php` and set `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME` to match your MySQL settings.
   - Ensure `APP_URL` points to the public folder: `http://localhost/Movie-streaming-platform/public`

7. Open the app in your browser:

   - http://localhost/Movie-streaming-platform/public/

## Default Admin Rule
- Admin email: admin@example.com
- Admin password: admin123
- Any logged-in user with username `admin` is treated as admin.

Initial seeded admin (from `scripts/seed_admin_user.sql`):

- Email: admin@example.com
- Username: admin
- Password: admin123 (the seed inserts a hashed password; use this to sign in)

Notes and troubleshooting
- If phpMyAdmin import fails due to file size, increase `upload_max_filesize` and `post_max_size` in `php.ini` and restart Apache, or use the MySQL CLI:

```powershell
"C:\xampp\mysql\bin\mysql.exe" -u root -p movie_streaming < "c:\xampp\htdocs\Movie-streaming-platform\scripts\movie_streaming_platform.sql"
```

- If you see errors in the browser, check Apache error log: `C:\xampp\apache\logs\error.log` and ensure `app/config/config.php` DB credentials match your MySQL setup.

## Reviews Without Schema Change
- Reviews are stored in `notifications.message` JSON payload with `type='recommendation'`.
- Status flow: `pending` -> `approved` or `rejected`.
