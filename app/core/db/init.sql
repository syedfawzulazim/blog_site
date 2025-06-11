CREATE DATABASE IF NOT EXISTS blog_db;

USE blog_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

INSERT INTO users (name, email, password)
VALUES ('Adnan', 'adnan@example.com', 'pass');

INSERT INTO users (name, email, password)
VALUES ('Syed', 'syed@example.com', '1234');
