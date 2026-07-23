<?php
/*Programmer name: Mr Khow Yong Jing
Program name: saveDeck.php
Description: save user deck into database
First written on: Wed, 17-June-2026
Edited on: Thurs, 18-June-2026*/
include "dbConn.php";
session_start();

header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "User not logged in."
    ]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['deck'])) {
    echo json_encode([
        "success" => false,
        "message" => "No deck data received."
    ]);
    exit();
}

$user = (int)$_SESSION['user_id'];
$deck = $data['deck'];

if (!mysqli_query($conn, "DELETE FROM battle_deck WHERE user_id = $user")) {
    echo json_encode([
        "success" => false,
        "message" => "Failed to clear old deck data: " . mysqli_error($conn)
    ]);
    exit();
}

$slot = 1;

foreach ($deck as $card) {

    $card = (int)$card;

    $sql = "INSERT INTO battle_deck(user_id, slot_no, card_id)
            VALUES($user, $slot, $card)";

    if (!mysqli_query($conn, $sql)) {
        echo json_encode([
            "success" => false,
            "message" => mysqli_error($conn)
        ]);
        exit();
    }

    $slot++;
}

echo json_encode([
    "success" => true
]);
exit();
?>