-- Alter books table to store file content in database
ALTER TABLE books ADD COLUMN file_content LONGBLOB DEFAULT NULL;
ALTER TABLE books ADD COLUMN file_name VARCHAR(255) DEFAULT NULL;
ALTER TABLE books ADD COLUMN file_extension VARCHAR(10) DEFAULT NULL;
ALTER TABLE books ADD COLUMN file_size INT DEFAULT NULL;

-- Alter chapters table to store file content in database
ALTER TABLE chapters ADD COLUMN file_content LONGBLOB DEFAULT NULL;
ALTER TABLE chapters ADD COLUMN file_name VARCHAR(255) DEFAULT NULL;
ALTER TABLE chapters ADD COLUMN file_extension VARCHAR(10) DEFAULT NULL;
ALTER TABLE chapters ADD COLUMN file_size INT DEFAULT NULL;
