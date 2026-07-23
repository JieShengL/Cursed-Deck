<?php
/*Programmer name: Mr Lin Xu Zhi
Program name: inventory.php
Description: display player card inventory
First written on: Thurs, 18-June-2026
Edited on: Sat, 20-June-2026*/
include "dbConn.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$currentUser = (int)$_SESSION['user_id']; 
$txt_file_path = "cardsInventory/user_" . $currentUser . "_cards.txt";

$owned_cards = [];
$activeBannedCards = []; 

if (file_exists($txt_file_path)) {
    $owned_cards = array_map('trim', file($txt_file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
}

if (!empty($owned_cards)) {
    $escaped_cards = array_map(function($card_name) use ($conn) {
        return "'" . mysqli_real_escape_string($conn, $card_name) . "'";
    }, $owned_cards);
    
    $card_list_string = implode(",", $escaped_cards);
    $query_str = "SELECT * FROM card WHERE card_name IN ($card_list_string) ORDER BY card_id";
    $cardQuery = mysqli_query($conn, $query_str);
} else {
    $cardQuery = mysqli_query($conn, "SELECT * FROM card WHERE 1=0");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Inventory</title>
    <style>
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }
        .empty-message {
            text-align: center;
            color: #aaa;
            font-size: 1.5rem;
            margin-top: 50px;
            width: 100%;
        }
        .exit {
            display: inline-block;
            margin-left: 7.5%;
            margin-top: 3%;
        }
        .rewards-footer {
            text-align: center;
            width: 100%;
            margin-top: 40px;
            margin-bottom: 40px;
            clear: both;
        }
        .level {
            color: gold; 
            text-decoration: underline; 
            font-size: 1.1rem;
            display: inline-block;
        }
    </style>
</head>
<body>

    <a href="main.php" class="exit">Back to Main Menu</a>
    
    <div class="container">
        <div class="inventory-vault">

            <?php 
            if (mysqli_num_rows($cardQuery) > 0) {
                while($card = mysqli_fetch_assoc($cardQuery)) { 
                    $isBanned = in_array((int)$card['card_id'], $activeBannedCards);
                    
                    $clean_image_name = trim($card['card_image']);
                ?>

                <div class="battle-card <?php echo $isBanned ? 'banned-card' : ''; ?>"
                    draggable="<?php echo $isBanned ? 'false' : 'true'; ?>"
                    data-card-id="<?php echo $card['card_id']; ?>"
                    style="background-image:url('images/cardImage/<?php echo htmlspecialchars($clean_image_name); ?>');">

                    <!-- <div class="card-name">
                        <?php echo htmlspecialchars($card['card_name']); ?>
                    </div> -->

                </div>
                <?php 
                } 
            } else { 
            ?>
                <div class="empty-message">
                    <p>Your inventory vault is currently empty.</p>
                    <p style="font-size: 1rem; color: #777; margin-bottom: 20px;">Earn levels and claim card rewards on the maps to fill your deck!</p>
                </div>
            <?php } ?>
                
        </div>

        <div class="rewards-footer">
            <a href="levelReward.php" class="level">View Level Rewards</a>
        </div>
    </div>

</body>
</html>