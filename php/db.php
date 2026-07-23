<?php
/*Programmer name: Mr Lin Xu Zhi
Program name: db.php
Description: connect PHP application to MySQL database
First written on: Sat, 30-May-2026
Edited on:Sat, 30-May-2026 */
/*======================================================
    DB.PHP
======================================================*/

/*======================================================
    DATABASE CONFIGURATION
======================================================*/

$DB_HOST = "localhost";
$DB_NAME = "cp";
$DB_USER = "root";
$DB_PASS = "";


/*======================================================
    DATABASE CONNECTION
======================================================*/

try {

    $conn = new PDO(

        "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4",

        $DB_USER,

        $DB_PASS

    );

    $conn->setAttribute(

        PDO::ATTR_ERRMODE,

        PDO::ERRMODE_EXCEPTION

    );

    $conn->setAttribute(

        PDO::ATTR_DEFAULT_FETCH_MODE,

        PDO::FETCH_ASSOC

    );

}

catch (PDOException $e) {

    http_response_code(500);

    die(

        json_encode([

            "success" => false,

            "message" => "Database connection failed.",

            "error" => $e->getMessage()

        ])

    );

}


/*======================================================
    HELPER FUNCTIONS
======================================================*/

function sendJSON($data) {

    header("Content-Type: application/json");

    echo json_encode($data);

    exit;

}

?>