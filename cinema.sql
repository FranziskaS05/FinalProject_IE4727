CREATE DATABASE IF NOT EXISTS cinema
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE cinema;

CREATE TABLE users (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50)  NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Booking form
CREATE TABLE bookings (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT NOT NULL,
    movie      VARCHAR(100) NOT NULL,
    name       VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL,
    screening  VARCHAR(20)  NOT NULL,
    tickets    INT NOT NULL
);