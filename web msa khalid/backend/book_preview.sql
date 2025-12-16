-- Create database
CREATE DATABASE IF NOT EXISTS bookstore_db;
USE bookstore_db;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Books table
CREATE TABLE IF NOT EXISTS books (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    description TEXT,
    cover_image_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Chapters table
CREATE TABLE IF NOT EXISTS chapters (
    id INT PRIMARY KEY AUTO_INCREMENT,
    book_id INT NOT NULL,
    chapter_number INT NOT NULL,
    title VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);

-- Book pages table (stores image paths for each page)
CREATE TABLE IF NOT EXISTS book_pages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    chapter_id INT NOT NULL,
    page_number INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (chapter_id) REFERENCES chapters(id) ON DELETE CASCADE
);

-- Reading progress table
CREATE TABLE IF NOT EXISTS reading_progress (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    current_chapter INT DEFAULT 1,
    current_page INT DEFAULT 1,
    last_read TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_book (user_id, book_id)
);

-- Sample data: Insert a test book
INSERT INTO books (title, author, description, cover_image_path) VALUES
('Reincarnation of the Veteran Soldier', 'Example Author', 'A brave soldier finds himself reborn in a world of magic and destiny...', 'images/cover.jpg');

-- Sample chapters
INSERT INTO chapters (book_id, chapter_number, title) VALUES
(1, 1, 'Chapter 1 — New Life'),
(1, 2, 'Chapter 2 — Training'),
(1, 3, 'Chapter 3 — Return');

-- Sample pages (using placeholder paths - replace with real image paths)
INSERT INTO book_pages (chapter_id, page_number, image_path) VALUES
(1, 1, 'images/page1.jpg'),
(1, 2, 'images/page2.jpg'),
(1, 3, 'images/page3.jpg'),
(2, 1, 'images/ch2page1.jpg'),
(2, 2, 'images/ch2page2.jpg'),
(3, 1, 'images/ch3page1.jpg');