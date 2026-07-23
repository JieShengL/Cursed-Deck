<?php
/*
Programmer name: Mr Jason Lim
Program name: getCards.php
Description: load users card deck
First written on: Tue, 2-June-2026
Edited on: Tue, 2-June-2026
*/
/*======================================================
    GETCARDS.PHP (LOAD FROM USER'S BATTLE DECK)
======================================================*/

require_once "db.php";
session_start(); // Start session to access logged-in user_id

/*======================================================
    RETURN JSON
======================================================*/

header("Content-Type: application/json");

// Verify user authentication
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode([
        "success" => false,
        "message" => "User not logged in."
    ]);
    exit();
}

$user_id = (int)$_SESSION['user_id'];

/*======================================================
    GET USER DECK LINKED TO CARD DETAILS
======================================================*/

try {
    // Connect battle_deck table columns with the card table metadata
    $sql = "
        SELECT
            c.card_id,
            c.card_name,
            c.ability,
            c.description
        FROM battle_deck bd
        INNER JOIN card c ON bd.card_id = c.card_id
        WHERE bd.user_id = :user_id
        ORDER BY bd.slot_no ASC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch as associative array to keep payload neat
    $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($cards);

}
catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Unable to retrieve cards.",
        "error" => $e->getMessage()
    ]);
}
?>