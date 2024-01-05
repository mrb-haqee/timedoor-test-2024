<?php
define('ROOT_DIR', __DIR__);


require_once(ROOT_DIR . '/vendor/autoload.php');
require_once(ROOT_DIR . '/database/Connect.php');

use Dotenv\Dotenv;

// Load .env
$dotenv = Dotenv::createImmutable(ROOT_DIR);
$dotenv->load();

$host = $_ENV['DB_HOST'] ?? '';
$database = $_ENV['DB_DATABASE'] ?? '';
$username = $_ENV['DB_USERNAME'] ?? '';
$password = $_ENV['DB_PASSWORD'] ?? '';

$pdo = Connect($host, $database, $username, $password);

// handle Rating page
require_once(ROOT_DIR . '/view/Rating.php');
?>

<!DOCTYPE html>
<html>

<head>
    <title>Timedoor Test</title>
    <link rel="stylesheet" href="src/style.css" />
</head>

<body>
    <header>
        <h2>Timedoor Backend Programming Exam 2024</h2>
        <nav>
            <div>
                <button data-target="1" class="active">List Book</button>
                <button data-target="2">Top Book</button>
                <button data-target="3">Insert Ratings</button>
            </div>
        </nav>
    </header>

    <section id="1" class="active">
        <h2>List of Book</h2>
        <form method="post">
            <div>
                <label for="list-shown">List Shown : </label>
                <select name="shown" id="list-shown">
                    <option value="10" selected>10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="40">40</option>
                    <option value="50">50</option>
                    <option value="60">60</option>
                    <option value="70">70</option>
                    <option value="80">80</option>
                    <option value="90">90</option>
                    <option value="100">100</option>
                </select>
            </div>

            <div>
                <label for="search">Search : </label>
                <input type="text" id="search" name="search" />
            </div>
            <button type="submit" name="submit-list">Submit</button>
        </form>
        <table class="table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Book Name</th>
                    <th>Category Name</th>
                    <th>Author Name</th>
                    <th>Average Rating</th>
                    <th>Voter</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include "./view/ListBook.php"
                ?>
            </tbody>
        </table>
    </section>

    <section id="2">
        <h2>TOP 10 Most Famous Author</h2>
        <table class="table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Author Name</th>
                    <th>Voter</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include "./view/ListFamousAuthor.php"
                ?>
            </tbody>
        </table>
    </section>

    <section id="3">
        <h2>Insert Rating</h2>
        <?php
        // get data author
        $sqlAuthors = "SELECT id, name FROM authors";
        $stmtAuthors = $pdo->prepare($sqlAuthors);
        $stmtAuthors->execute();

        ?>
        <form method="post" id="rating-form">
            <?php
            if ($stmtAuthors->rowCount() > 0) {
            ?>
                <div>
                    <label for="author-name">Author Name : </label>
                    <select name="author_id" id="author-name">
                        <option value="" disabled selected>Choice Author</option>
                        <?php
                        while ($row = $stmtAuthors->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="book-name">Book Name : </label>
                    <select name="book_id" id="book-name">
                        <option value="" disabled selected>Choice Author First!</option>
                    </select>
                </div>
                <div>
                    <label for="rating">Rating : </label>
                    <select name="rat" id="rating">
                        <option value="10" selected>10</option>
                        <option value="9">9</option>
                        <option value="8">8</option>
                        <option value="7">7</option>
                        <option value="6">6</option>
                        <option value="5">5</option>
                        <option value="4">4</option>
                        <option value="3">3</option>
                        <option value="2">2</option>
                        <option value="1">1</option>
                    </select>
                </div>
                <button type="submit" name="submit-rating">Submit</button>
            <?php } ?>
        </form>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="src/index.js"></script>

</body>

</html>