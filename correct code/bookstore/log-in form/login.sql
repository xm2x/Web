-- 1. Create and Select Database
CREATE DATABASE IF NOT EXISTS bookstore_db;
USE bookstore_db;

-- 2. USERS TABLE (Your Code)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- 3. PRODUCTS TABLE (Required for Main Page)
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    category VARCHAR(100) DEFAULT 'General'
);

-- 4. INSERT PRODUCTS (So your website isn't empty)
INSERT INTO products (title, image, price, category) VALUES 
('Book Title 1', 'Book Cover Designer - David Gardias (1).jpeg', 19.99, 'Design'),
('Marketing Colors', 'How to Use Colors in Marketing and Advertising.jpeg', 24.99, 'Business'),
('Nightbooks', 'Nightbooks.jpeg', 14.99, 'Fiction'),
('Animation Concepts', 'Концептуальная иллюстрация и анимация.jpeg', 29.99, 'Art'),
('Sci-Fi Best', 'The Best Sci-Fi Books of All Time _ Penguin Random House.jpeg', 12.99, 'Sci-Fi'),
('Business Covers', 'Premade Book Covers - Premade Non-fiction, Business Book Covers -_.jpeg', 18.50, 'Business'),
('Special Edition', 'download (23).jpg', 9.99, 'General');

-- 5. ORDERS TABLE (For Future Shopping Cart Features)
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- 6. TEST USER (Optional: Login with test@test.com / 123)
INSERT INTO users (full_name, email, password) 
VALUES ('Test User', 'test@test.com', '123');