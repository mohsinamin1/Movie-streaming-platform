USE movie_streaming;
INSERT INTO plans (name, price, max_screens, hd_available, uhd_available)
VALUES
('Basic', 4.99, 1, 0, 0),
('Standard', 9.99, 2, 1, 0),
('Premium', 14.99, 4, 1, 1)
ON DUPLICATE KEY UPDATE name = name;

INSERT INTO movies (title, description, duration_min, release_year, language, rating, imdb_score, is_featured)
VALUES
('The Last Orbit', 'Sci-fi thriller set in deep space.', 118, 2024, 'en', 'PG-13', 7.8, 1),
('Hidden River', 'Crime mystery in a small town.', 104, 2023, 'en', 'PG-13', 7.1, 1)
ON DUPLICATE KEY UPDATE title = title;

INSERT INTO series (title, description, total_seasons, status, language, rating, imdb_score, is_featured)
VALUES
('City Codes', 'Detective drama solving cyber crimes.', 2, 'ongoing', 'en', 'TV-14', 8.0, 1),
('Campus Lives', 'University life and friendships.', 1, 'completed', 'en', 'TV-PG', 7.3, 1)
ON DUPLICATE KEY UPDATE title = title;

INSERT INTO episodes (series_id, season_number, episode_number, title, description, duration_min, air_date)
SELECT s.id, 1, 1, CONCAT(s.title, ' Episode 1'), 'Pilot episode', 42, '2024-01-01'
FROM series s
WHERE s.title IN ('City Codes', 'Campus Lives')
ON DUPLICATE KEY UPDATE title = VALUES(title);

INSERT INTO banners (title, image_url, link_url, region, display_order, is_active)
VALUES
('Featured This Week', 'https://placehold.co/1200x400', '/browse-movies.php', 'global', 1, 1)
ON DUPLICATE KEY UPDATE title = title;
