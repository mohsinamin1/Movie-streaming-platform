# Movie Streaming Platform

## Group Information
- Group Number: 17
- Group Members:
  - Muhammad Mohsin - 24P-0596
  - Muhammad Abdullah Khan - 24P-0735

## Project Title
Movie Streaming Platform

## Short Description
A PHP and MySQL based movie streaming website where users can browse movies and series, search content, register/login, and submit reviews. An admin panel is included to manage movies, series, genres, cast, tags, banners, and reviews.

## GitHub Repository URL
- https://github.com/mohsinamin1/Movie-streaming-platform

## Technologies Used
- PHP 8+
- MySQL
- PDO (prepared statements)
- HTML
- CSS
- JavaScript
- XAMPP / Apache
- phpMyAdmin

## How to Install and Run the Application

### 1. Place the Project in XAMPP htdocs
Copy the project folder into your XAMPP `htdocs` directory. Example:

```text
c:\xampp\htdocs\Movie-streaming-platform
```

### 2. Start Apache and MySQL
Open XAMPP Control Panel and start:
- Apache
- MySQL

### 3. Create the Database in phpMyAdmin
Open phpMyAdmin in your browser:

```text
http://localhost/phpmyadmin
```

Then:
- Click **Databases**
- Create a database named `movie_streaming`
- Choose collation `utf8mb4_unicode_ci`
- Click **Create**

### 4. Import the SQL Files
Select the `movie_streaming` database, then use **Import** to upload these files in order:

1. `scripts/movie_streaming_platform.sql`
2. `scripts/seed_admin_user.sql`
3. `scripts/seed_sample_data.sql`
4. `scripts/add-relationships.sql`

If phpMyAdmin gives a file size error, increase `upload_max_filesize` and `post_max_size` in `php.ini`, then restart Apache.

### 5. Update Database Credentials
Edit `app/config/config.php` and set:
- `DB_HOST`
- `DB_PORT`
- `DB_NAME`
- `DB_USER`
- `DB_PASS`

Also make sure `APP_URL` matches your folder name:

```text
http://localhost/Movie-streaming-platform/public
```

### 6. Run the Project
Open this link in your browser:

```text
http://localhost/Movie-streaming-platform/public/
```

## Initial Admin Credentials
These credentials are seeded by `scripts/seed_admin_user.sql`:

- Email: `admin@example.com`
- Username: `admin`
- Password: `admin123`

## Notes
- Reviews are stored in `notifications.message` as JSON with `type='recommendation'`.
- If the website shows an error, check `C:\xampp\apache\logs\error.log`.
- The project uses PDO prepared statements to reduce SQL injection risk.
