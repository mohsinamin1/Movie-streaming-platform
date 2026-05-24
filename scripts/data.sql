-- ============================================
-- MOVIE STREAMING PLATFORM DATABASE
-- Run this in phpMyAdmin to create the database
-- ============================================

CREATE DATABASE IF NOT EXISTS movie_streaming_platform 
    CHARACTER SET utf8mb4 
    COLLATE utf8mb4_unicode_ci;

USE movie_streaming_platform;

-- Plans Table
CREATE TABLE plans (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE,
    price DECIMAL(10,2) NOT NULL,
    max_screens INT DEFAULT 1,
    hd_available BOOLEAN DEFAULT FALSE,
    uhd_available BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Users Table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL UNIQUE,
    username VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    country VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP
);

-- Subscriptions Table
CREATE TABLE subscriptions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    plan_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE,
    status VARCHAR(20) CHECK (status IN ('active','paused','cancelled','expired')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (plan_id) REFERENCES plans(id)
);

-- Payments Table
CREATE TABLE payments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    subscription_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    currency VARCHAR(10) DEFAULT 'USD',
    method VARCHAR(50) NOT NULL,
    status VARCHAR(20) CHECK (status IN ('pending','completed','failed','refunded')),
    paid_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (subscription_id) REFERENCES subscriptions(id) ON DELETE CASCADE
);

-- Profiles Table
CREATE TABLE profiles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    avatar_url TEXT,
    is_kids BOOLEAN DEFAULT FALSE,
    age_limit INT DEFAULT 18,
    language_pref VARCHAR(10) DEFAULT 'en',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Devices Table
CREATE TABLE devices (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    device_name VARCHAR(150) NOT NULL,
    device_type VARCHAR(50) CHECK (device_type IN ('smart_tv','mobile','tablet','desktop','console','other')),
    os VARCHAR(100),
    last_active TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Active Sessions Table
CREATE TABLE active_sessions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    device_id INT NOT NULL,
    token TEXT UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (device_id) REFERENCES devices(id) ON DELETE CASCADE
);

-- Notifications Table
CREATE TABLE notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    type VARCHAR(50) CHECK (type IN ('new_content','payment','subscription','system','recommendation')),
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Genres Table
CREATE TABLE genres (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) UNIQUE,
    description TEXT
);

-- Tags Table
CREATE TABLE tags (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) UNIQUE
);

-- Languages Table
CREATE TABLE languages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(10) UNIQUE,
    name VARCHAR(100) NOT NULL
);

-- Studios Table
CREATE TABLE studios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(200) UNIQUE,
    country VARCHAR(100),
    website VARCHAR(255),
    description TEXT,
    founded_year INT
);

-- Cast Members Table
CREATE TABLE cast_members (
    id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(200) NOT NULL,
    birth_date DATE,
    nationality VARCHAR(100),
    bio TEXT,
    photo_url TEXT
);

-- Movies Table
CREATE TABLE movies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(300) NOT NULL,
    description TEXT,
    duration_min INT NOT NULL,
    release_year INT,
    language VARCHAR(10),
    rating VARCHAR(10),
    imdb_score DECIMAL(3,1),
    poster_url TEXT,
    trailer_url TEXT,
    is_featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Series Table
CREATE TABLE series (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(300) NOT NULL,
    description TEXT,
    total_seasons INT DEFAULT 1,
    status VARCHAR(20) CHECK (status IN ('ongoing','completed','cancelled')),
    language VARCHAR(10),
    rating VARCHAR(10),
    imdb_score DECIMAL(3,1),
    poster_url TEXT,
    trailer_url TEXT,
    is_featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Episodes Table
CREATE TABLE episodes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    series_id INT NOT NULL,
    season_number INT NOT NULL,
    episode_number INT NOT NULL,
    title VARCHAR(300) NOT NULL,
    description TEXT,
    duration_min INT NOT NULL,
    air_date DATE,
    thumbnail_url TEXT,
    UNIQUE(series_id, season_number, episode_number),
    FOREIGN KEY (series_id) REFERENCES series(id) ON DELETE CASCADE
);

-- Banners Table
CREATE TABLE banners (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    image_url TEXT NOT NULL,
    link_url TEXT,
    region VARCHAR(50) DEFAULT 'global',
    display_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    valid_from TIMESTAMP,
    valid_until TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- SAMPLE DATA INSERTION
-- ============================================

INSERT INTO plans (name, price, max_screens, hd_available, uhd_available) VALUES
('Basic', 9.99, 1, TRUE, FALSE),
('Standard', 15.99, 2, TRUE, TRUE),
('Premium', 19.99, 4, TRUE, TRUE);

INSERT INTO users (email, username, password_hash, country) VALUES
('john.doe@email.com', 'johndoe', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'USA'),
('jane.smith@email.com', 'janesmith', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'UK'),
('mike.wilson@email.com', 'mikew', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Canada');

INSERT INTO subscriptions (user_id, plan_id, start_date, end_date, status) VALUES
(1, 2, '2024-01-01', '2024-12-31', 'active'),
(2, 3, '2024-02-15', '2025-02-14', 'active'),
(3, 1, '2024-03-01', '2024-03-31', 'expired');

INSERT INTO payments (user_id, subscription_id, amount, method, status, paid_at) VALUES
(1, 1, 15.99, 'credit_card', 'completed', '2024-01-01 10:00:00'),
(2, 2, 19.99, 'paypal', 'completed', '2024-02-15 14:30:00');

INSERT INTO profiles (user_id, name, is_kids, age_limit) VALUES
(1, 'John', FALSE, 18),
(1, 'Kids Profile', TRUE, 7),
(2, 'Jane', FALSE, 18),
(3, 'Mike', FALSE, 18);

INSERT INTO devices (user_id, device_name, device_type, os) VALUES
(1, 'iPhone 15', 'mobile', 'iOS 17'),
(1, 'Samsung TV', 'smart_tv', 'Tizen'),
(2, 'MacBook Pro', 'desktop', 'macOS'),
(3, 'iPad Air', 'tablet', 'iPadOS');

INSERT INTO notifications (user_id, type, message) VALUES
(1, 'new_content', 'New season of Stranger Things is now available!'),
(2, 'payment', 'Your subscription payment was successful.'),
(1, 'recommendation', 'Based on your watch history, you might like The Witcher.');

INSERT INTO genres (name, description) VALUES
('Action', 'High-energy films with physical stunts and fights'),
('Drama', 'Serious, emotional storytelling'),
('Comedy', 'Humorous and entertaining content'),
('Sci-Fi', 'Science fiction and futuristic themes'),
('Horror', 'Scary and suspenseful content'),
('Romance', 'Love stories and relationships'),
('Thriller', 'Suspenseful and exciting narratives'),
('Documentary', 'Non-fiction educational content');

INSERT INTO tags (name) VALUES
('Trending'), ('New Release'), ('Award Winner'), ('Classic'), ('Binge-worthy'), ('Family Friendly');

INSERT INTO languages (code, name) VALUES
('en', 'English'), ('es', 'Spanish'), ('fr', 'French'), ('de', 'German'), ('hi', 'Hindi'), ('ja', 'Japanese');

INSERT INTO studios (name, country, founded_year) VALUES
('Netflix Studios', 'USA', 1997),
('Warner Bros', 'USA', 1923),
('Marvel Studios', 'USA', 1993),
('BBC Studios', 'UK', 1964),
('Studio Ghibli', 'Japan', 1985);

INSERT INTO cast_members (full_name, nationality, bio) VALUES
('Leonardo DiCaprio', 'USA', 'Academy Award-winning actor known for Titanic and Inception'),
('Scarlett Johansson', 'USA', 'Versatile actress known for Marvel and indie films'),
('Robert Downey Jr.', 'USA', 'Iron Man actor and Hollywood icon'),
('Emma Watson', 'UK', 'Harry Potter star and activist'),
('Tom Hanks', 'USA', 'Beloved actor known for Forrest Gump and Cast Away');

INSERT INTO movies (title, description, duration_min, release_year, language, rating, imdb_score, is_featured) VALUES
('Inception', 'A thief who steals corporate secrets through dream-sharing technology', 148, 2010, 'en', 'PG-13', 8.8, TRUE),
('The Dark Knight', 'Batman faces the Joker, a criminal mastermind', 152, 2008, 'en', 'PG-13', 9.0, TRUE),
('Interstellar', 'A team of explorers travel through a wormhole in space', 169, 2014, 'en', 'PG-13', 8.6, FALSE),
('Parasite', 'A poor family schemes to become employed by a wealthy family', 132, 2019, 'ko', 'R', 8.5, TRUE),
('The Matrix', 'A hacker discovers the truth about his reality', 136, 1999, 'en', 'R', 8.7, FALSE);

INSERT INTO series (title, description, total_seasons, status, language, rating, imdb_score, is_featured) VALUES
('Stranger Things', 'Kids in a small town uncover supernatural mysteries', 4, 'ongoing', 'en', 'TV-14', 8.7, TRUE),
('The Witcher', 'A monster hunter navigates a dangerous fantasy world', 3, 'ongoing', 'en', 'TV-MA', 8.0, TRUE),
('Breaking Bad', 'A chemistry teacher turns to cooking meth', 5, 'completed', 'en', 'TV-MA', 9.5, FALSE),
('Money Heist', 'A criminal mastermind plans the biggest heist in history', 5, 'completed', 'es', 'TV-MA', 8.2, FALSE),
('Squid Game', 'Desperate people compete in deadly children games', 1, 'completed', 'ko', 'TV-MA', 8.0, TRUE);


