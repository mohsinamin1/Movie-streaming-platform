-- Admin credentials: admin@example.com / admin123
USE movie_streaming;
INSERT INTO users (email, username, password_hash, country)
VALUES ('admin@example.com', 'admin', '$2y$10$andV7RAceuadNP59tiK5geBo5jcqGXPMn55iNINldyxD5faL.5Xpe', 'PK')
ON DUPLICATE KEY UPDATE
	username = VALUES(username),
	password_hash = VALUES(password_hash),
	country = VALUES(country);
