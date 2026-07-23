<?php
/*Programmer name: Mr Jason Lim
Program name: saveGame.php
Description:  GET USER'S SAVED DECK CARDS FROM DATABASE
First written on: Thurs, 18-June-2026
Edited on:Thurs, 18-June-2026 */
/*======================================================
    GETCARDS.PHP (LOAD USER DECK)
======================================================*/

require_once "db.php";

// Start session to access the logged-in user's ID
session_start();

/*======================================================
    RETURN JSON
======================================================*/

header("Content-Type: application/json");

// 1. Check if the user session exists (same check as saveDeck.php)
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
    GET USER'S SAVED DECK CARDS FROM DATABASE
======================================================*/

try {
    // 2. JOIN battle_deck with the card details table using card_id
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
    
    // 3. Bind the user identity securely
    $stmt->execute([
        ':user_id' => $user_id
    ]);

    $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 4. Return the exact structure JavaScript is already expecting
    echo json_encode($cards);

}
catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([

        "success" => false,

        "message" => "Unable to retrieve deck cards.",

        "error" => $e->getMessage()

    ]);

}
?>