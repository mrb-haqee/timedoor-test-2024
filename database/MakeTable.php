<?php

$sql = "
-- Tabel untuk daftar penulis (authors)
CREATE TABLE IF NOT EXISTS authors (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL
);

-- Tabel untuk kategori buku (book_categories)
CREATE TABLE IF NOT EXISTS book_categories (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) UNIQUE NOT NULL
);

-- Tabel untuk daftar buku (books)
CREATE TABLE IF NOT EXISTS books (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) UNIQUE NOT NULL,
    author_id INT(11) NOT NULL,
    category_id INT(11) NOT NULL,
    FOREIGN KEY (author_id) REFERENCES authors(id),
    FOREIGN KEY (category_id) REFERENCES book_categories(id)
);

-- Tabel untuk daftar penilaian (ratings)
CREATE TABLE IF NOT EXISTS ratings (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    book_id INT(11) NOT NULL,
    rating INT(1) NOT NULL,
    FOREIGN KEY (book_id) REFERENCES books(id)
);
";

$pdo->exec($sql);

echo "Create Table successfully\n\n";
