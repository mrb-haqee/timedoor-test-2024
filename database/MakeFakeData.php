<?php

echo "======================================\n";
echo "=====Fake data generation process=====\n";
echo "======================================\n\n";

$pdo->beginTransaction();

// Count the number of rows in the table
function CountData($pdo, $table)
{
    $countQuery = $pdo->query("SELECT COUNT(*) FROM $table");
    return (int) $countQuery->fetchColumn();
}

$DataAuthors = CountData($pdo, "authors");
if ($DataAuthors < 1000) {
    $remainingRows = 1000 - $DataAuthors;

    $insert = $pdo->prepare("INSERT INTO authors (name) VALUES (:authorName)");

    for ($i = 0; $i < $remainingRows; $i++) {
        $authorName = $faker->unique()->name;
        $insert->bindParam(':authorName', $authorName, PDO::PARAM_STR);
        $insert->execute();
    }

    echo "Author data has been added\n";
} else {
    echo "Author data already contains 1000 rows\n";
}

$DataBookCategories = CountData($pdo, "book_categories");
if ($DataBookCategories < 3000) {
    $remainingRows = 3000 - $DataBookCategories;

    $categories = [];

    for ($i = 0; $i < $remainingRows; $i++) {
        do {
            $words = $faker->words(2);
            $category = implode(' ', $words);
        } while (isset($categories[$category]));

        $categories[$category] = true;
    }

    $categories = array_keys($categories);

    $insert = $pdo->prepare("INSERT INTO book_categories (category_name) VALUES (:categoryName)");

    for ($i = 0; $i < $remainingRows; $i++) {
        $categoryName = $categories[$i % count($categories)];
        $insert->bindParam(':categoryName', $categoryName, PDO::PARAM_STR);
        $insert->execute();
    }

    echo "Book_categories data has been added\n";
} else {
    echo "Book_categories data already contains 3000 rows\n";
}

$DataBooks = CountData($pdo, "books");
if ($DataBooks < 100000) {
    $remainingRows = 100000 - $DataBooks;

    $books = [];

    for ($i = 0; $i < $remainingRows; $i++) {
        do {
            $words = $faker->words(4);
            $book = implode(' ', $words);
        } while (isset($books[$book]));

        $books[$book] = true;
    }

    $books = array_keys($books);

    $insert = $pdo->prepare("INSERT INTO books (title, author_id, category_id) VALUES (:title, :authorId, :categoryId)");

    for ($i = 0; $i < $remainingRows; $i++) {

        $bookTitle = $books[$i % count($books)];
        $authorId = $faker->numberBetween(1, 1000);
        $categoryId = $faker->numberBetween(1, 3000);

        $insert->bindParam(':title', $bookTitle, PDO::PARAM_STR);
        $insert->bindParam(':authorId', $authorId, PDO::PARAM_INT);
        $insert->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);

        $insert->execute();
    }

    echo "Books data has been added\n";
} else {
    echo "Books data already contains 100.000 rows\n";
}

$DataRatings = CountData($pdo, "ratings");
if ($DataRatings < 500000) {
    $remainingRows = 500000 - $DataRatings;

    $insert = $pdo->prepare("INSERT INTO ratings (book_id, rating) VALUES (:bookId, :rating)");

    for ($i = 0; $i < $remainingRows; $i++) {
        if ($i < 15000) {
            // vote for a good book
            $bookId = $faker->numberBetween(100, 120);
            $rating = $faker->numberBetween(8, 10);
        } else if ($i < 30000) {
            $bookId = $faker->numberBetween(121, 140);
            $rating = $faker->numberBetween(6, 8);
        } else if ($i < 45000) {
            $bookId = $faker->numberBetween(141, 160);
            $rating = $faker->numberBetween(4, 6);
        } else if ($i < 60000) {
            $bookId = $faker->numberBetween(161, 180);
            $rating = $faker->numberBetween(3, 5);
        } else {
            $bookId = $faker->numberBetween(1, 100000);
            $rating = $faker->numberBetween(1, 7);
        }

        $insert->bindParam(':bookId', $bookId, PDO::PARAM_INT);
        $insert->bindParam(':rating', $rating, PDO::PARAM_INT);
        $insert->execute();
    }

    echo "Rating_books data has been added\n";
} else {
    echo "Rating_books data already contains 500.000 rows\n";
}

$pdo->commit();
