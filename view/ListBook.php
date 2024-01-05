<?php

function Display($stmt)
{
    if ($stmt->rowCount() > 0) {
        $i = 1;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
             <td>" . $i . "</td>
             <td>" . $row["Book Name"] . "</td>
             <td>" . $row["Category Name"] . "</td>
             <td>" . $row["Author Name"] . "</td>
             <td>" . $row["Average Rating"] . "</td>
             <td>" . $row["Voter"] . "</td>
           </tr>";
            $i++;
        }
    } else {
        echo "<tr><td colspan='6'><center>Tidak ada hasil yang ditemukan</center></td></tr>";
    }
}

if (isset($_POST['submit-list'])) {
    // Get data using the form
    $limit = isset($_POST['shown']) ? $_POST['shown'] : 10;
    $search = isset($_POST['search']) ? '%' . $_POST['search'] . '%' : '';

    $sql = "SELECT 
             b.id AS 'id Book',
             b.title AS 'Book Name',
             bc.category_name AS 'Category Name',
             a.name AS 'Author Name',
             ROUND(AVG(r.rating), 2) AS 'Average Rating',
             COUNT(r.id) AS 'Voter'
         FROM books b
         INNER JOIN authors a ON b.author_id = a.id
         INNER JOIN book_categories bc ON b.category_id = bc.id
         LEFT JOIN ratings r ON b.id = r.book_id
         WHERE b.title LIKE :nama_buku OR a.name LIKE :nama_author
         GROUP BY b.id, b.title, bc.category_name, a.name
         ORDER BY AVG(r.rating) DESC
         LIMIT $limit";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':nama_buku', $search, PDO::PARAM_STR);
    $stmt->bindParam(':nama_author', $search, PDO::PARAM_STR);

    $stmt->execute();
    Display($stmt);
} else {
    // get data when first reloaded
    $limit = 10;
    $sql = "SELECT 
         b.id AS 'id Book',
         b.title AS 'Book Name',
         bc.category_name AS 'Category Name',
         a.name AS 'Author Name',
         ROUND(AVG(r.rating), 2) AS 'Average Rating',
         COUNT(r.id) AS 'Voter'
     FROM books b
     INNER JOIN authors a ON b.author_id = a.id
     INNER JOIN book_categories bc ON b.category_id = bc.id
     LEFT JOIN ratings r ON b.id = r.book_id
     GROUP BY b.id, b.title, bc.category_name, a.name
     ORDER BY AVG(r.rating) DESC
     LIMIT $limit";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    Display($stmt);
}
