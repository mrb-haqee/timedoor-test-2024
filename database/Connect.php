<?php



function Connect($host, $database, $username, $password, $mess = false)
{
    try {
        $pdo = new PDO("mysql:host=$host;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$database'");
        $databaseExists = $stmt->fetchColumn();

        if (!$databaseExists) {
            $pdo->exec("CREATE DATABASE $database");
            if ($mess === true) {
                echo "$database Database created successfully!\n";
            }

            $pdo->exec("USE $database");
            if ($mess === true) {
                echo "$database Database connection successful!\n";
            }
        } else {
            $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if ($mess === true) {
                echo "$database database connection successful!\n";
            }
        }
        return $pdo; // Return the PDO object for further usage
    } catch (PDOException $e) {
        die("Database connection failed: \n" . $e->getMessage());
    }
}
