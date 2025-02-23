<?php
// config/database.php

function getDatabaseConnection() {
    static $pdo = null;

    if ($pdo === null) {
        $host = 'localhost';
        $dbname = 'film_review_db';
        $username = 'root';
        $password = '';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            // Jika dalam mode API, gunakan JSON response untuk error
            if (php_sapi_name() !== 'cli') {
                header('Content-Type: application/json');
                http_response_code(500);
                echo json_encode([
                    "error" => "Database connection failed",
                    "message" => $e->getMessage()
                ]);
                exit;
            } else {
                die("Database connection failed: " . $e->getMessage());
            }
        }
    }

    return $pdo;
}

// Inisialisasi koneksi saat file di-include
$pdo = getDatabaseConnection();
?>
