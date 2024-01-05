<?php

if (isset($_GET['author_id'])) {
    $selectedAuthorId = $_GET['author_id'];

    // Get data book by author_id
    $sqlBooks = "SELECT id, title FROM books WHERE author_id = :author_id ORDER BY title";
    $stmtBooks = $pdo->prepare($sqlBooks);
    $stmtBooks->bindParam(':author_id', $selectedAuthorId);
    $stmtBooks->execute();

    $bookOptions = "";

    // Loop through the book query results and create a dropdown selection
    while ($row = $stmtBooks->fetch(PDO::FETCH_ASSOC)) {
        $bookOptions .= '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
    }

    echo $bookOptions;
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['author_id']) && isset($_POST['book_id']) && isset($_POST['rat'])) {

        $authorId = $_POST['author_id'];
        $bookId = $_POST['book_id'];
        $rating = $_POST['rat'];

        $sql = "INSERT INTO ratings (book_id, rating) VALUES (:book_id, :rating)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        $stmt->execute();

        echo "Data berhasil disimpan";
        exit;
    }
}
