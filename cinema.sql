CREATE DATABASE IF NOT EXISTS cinema
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE cinema;

CREATE TABLE users (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50)  NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);


CREATE TABLE bookings (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT NOT NULL,
    movie      VARCHAR(100) NOT NULL,
    name       VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL,
    screening  VARCHAR(20) NOT NULL,
    tickets    INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE movies (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    title    VARCHAR(100) NOT NULL UNIQUE,
    genre    VARCHAR(50)  NOT NULL,
    duration INT          NOT NULL,
    poster   VARCHAR(150) NOT NULL,
    times    VARCHAR(100) NOT NULL,
    price    DECIMAL(6,2) NOT NULL
);

INSERT INTO movies (title, genre, duration, poster, times, price) VALUES
('Spiderman',   'Action',          120, 'images/spiderman.jpg', '2:00 PM,5:00 PM,8:00 PM', 10.00),
('The Sandman', 'Science Fiction', 105, 'images/sand.jpg',      '1:00 PM,4:00 PM,7:00 PM', 12.00);