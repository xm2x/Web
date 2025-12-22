-- 1. Create and Select Database
CREATE DATABASE IF NOT EXISTS bookstore_db;
USE bookstore_db;

-- 2. Cleanup 
-- We disable checks to drop tables safely, then re-enable them.
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

-- 3. USERS TABLE
-- This table must exist before 'orders' can reference it.
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    plans VARCHAR(100) DEFAULT 'Free',
    password VARCHAR(255) NOT NULL
);

-- 4. PRODUCTS TABLE
-- This table must exist before 'orders' can reference it.
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    category VARCHAR(100) DEFAULT 'General',
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE subscription (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    duration_days INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO subscription (id, name, price, duration_days) VALUES 
(8, 'Basic Plan', 9.99, 30),
(9, 'Premium Plan', 19.99, 30),
(10, 'Premium-Plus Plan', 49.99, 30),
(11, 'Family Plan', 29.99, 30);

CREATE TABLE CONTACT_MESSAGES (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);







-- 5. ORDERS TABLE
-- This table references both 'users' and 'products'.
-- If a user or product ID is missing during an INSERT, it will throw the error you saw.
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_product_id FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
-- 6. INSERT ADMIN USER
-- Add the admin user to the database
INSERT INTO users (full_name, email, password) 
VALUES ('System Admin', 'admin@gmail.com', 'admin123');

-- 6. INSERT TEST USER
-- Essential: This provides a valid 'user_id' (1) for your PHP sessions to use.
INSERT INTO users (id, full_name, email, password) 
VALUES (0, 'Test User', 'test@test.com', '123');

-- 7. INSERT PRODUCTS
-- Essential: These provide valid 'product_id' values for your "Add to Cart" buttons.
INSERT INTO products (title, author, image, price, category, description) VALUES 
('Book Title 1', 'David Gardias', 'Book Cover Designer - David Gardias (1).jpeg', 19.99, 'best_seller', 'A top-rated book in our collection.'),
('Marketing Colors', 'Expert Author', 'How to Use Colors in Marketing and Advertising.jpeg', 24.99, 'science', 'Learn the psychology of color in business.'),
('Nightbooks', 'J.A. White', 'Nightbooks.jpeg', 14.99, 'horror', 'A scary story for those who love the dark.'),
('Animation Concepts', 'Artist Name', 'Концептуальная иллюстрация и анимация.jpeg', 29.99, 'science', 'Deep dive into animation techniques.'),
('Sci-Fi Best', 'Penguin Classics', 'The Best Sci-Fi Books of All Time _ Penguin Random House.jpeg', 12.99, 'science_fiction', 'A collection of the greatest sci-fi hits.'),
('Special Edition', 'Various', 'download (23).jpg', 9.99, 'fantasy', 'A limited release special edition.'),
('Classic Mystery', 'Agatha Christie', 'download (17).jpg', 15.00, 'mystery', 'A thrilling mystery to keep you guessing.');