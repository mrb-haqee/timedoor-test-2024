<?php

$sql = "SELECT a.id AS 'id author', a.name AS 'Author Name', COUNT(r.id) AS 'Voter'
        FROM authors a
        JOIN books b ON a.id = b.author_id
        LEFT JOIN ratings r ON b.id = r.book_id
        GROUP BY a.id
        ORDER BY Voter DESC
        LIMIT 10";

$stmt = $pdo->prepare($sql);
$stmt->execute();

$i = 1;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  echo "<tr>
             <td>" . $i . "</td>
             <td>" . $row["Author Name"] . "</td>
             <td>" . $row["Voter"] . "</td>
           </tr>";
  $i++;
}
