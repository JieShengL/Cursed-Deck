<?php
/*Programmer name: Mr Lin Xu Zhi
Program name: levelReward.php
Description: display card rewards based on levels
First written on: Fri, 12-June-2026
Edited on: Mon, 15-June-2026*/
include 'dbConn.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Access Denied: Please log in to view rewards.");
}

$currentUser = (int)$_SESSION['user_id']; 

$user_query = "SELECT account_level FROM account WHERE user_id = $currentUser";
$user_result = mysqli_query($conn, $user_query);
$user_data = $user_result->fetch_assoc();

$user_level = $user_data ? (int)$user_data['account_level'] : 1;

$card_query = "SELECT card_name, card_image, lvl_req FROM card ORDER BY lvl_req ASC, card_name ASC";
$card_result = mysqli_query($conn, $card_query);

$reward_road = [];
while ($row = mysqli_fetch_assoc($card_result)) {
    $reward_road[] = [
        'name'    => $row['card_name'],
        'image'   => trim($row['card_image']),
        'req_lvl' => (int)$row['lvl_req']
    ];
}

$txt_file_path = "cardsInventory/user_" . $currentUser . "_cards.txt";

$owned_cards = [];
if (file_exists($txt_file_path)) {
    $owned_cards = array_map('trim', file($txt_file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['claim_card'])) {
    $card_to_claim = $_POST['claim_card'];
    $level_req = (int)$_POST['level_req'];

    if ($user_level >= $level_req && !in_array($card_to_claim, $owned_cards)) {
        if (!is_dir('cardsInventory')) {
            mkdir('cardsInventory', 0777, true);
        }
        file_put_contents($txt_file_path, $card_to_claim . PHP_EOL, FILE_APPEND);
        
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level Reward</title>
    <link rel="stylesheet" href="css/LR.css">
    <style>
        .exit{
            font-size: 30px;
            color: Yellow;
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.2s ease;
            position: absolute;
            margin-top: 2%;
            margin-right: 70%;
        }

        .exit:hover {
            color: rgba(235, 211, 78, 0.75);
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    
    <div class="rewards-page-wrapper">
        <a href="inventory.php" class="exit">Back</a> 

        <h1 class="title">Level Rewards</h1>

        <div class="user-status-bar">Your Current Level: <?php echo $user_level; ?></div>
        <div class="reward-road-container">
            <?php foreach ($reward_road as $card): ?>
                <?php 
                    $actual_level = $card['req_lvl']; 
                ?>
                <div class="reward-card">
                    <div class="card-info">
                        <img src="images/cardImage/<?php echo $card['image']; ?>" 
                            alt="<?php echo htmlspecialchars($card['name']); ?>" 
                            class="viewable-card-img"
                            style="cursor: pointer;"
                            data-name="<?php echo htmlspecialchars($card['name']); ?>"
                            data-img="images/cardImage/<?php echo $card['image']; ?>"
                            data-desc="Unlocked at Level <?php echo $actual_level; ?>. ">
                        
                        <div class="card-text-details">
                            <div class="level-badge">LVL <?php echo $actual_level; ?> REWARD</div>
                            <div class="card-name"><?php echo htmlspecialchars($card['name']); ?></div>
                        </div>
                    </div>

                    <div class="action-zone">
                        <?php if (in_array($card['name'], $owned_cards)): ?>
                            <span class="status-txt">Claimed</span>
                        <?php elseif ($user_level >= $actual_level): ?>
                            <form action="" method="POST">
                                <input type="hidden" name="claim_card" value="<?php echo htmlspecialchars($card['name']); ?>">
                                <input type="hidden" name="level_req" value="<?php echo $actual_level; ?>">
                                <button type="submit" class="claim-btn">Claim</button>
                            </form>
                        <?php else: ?>
                            <button class="claim-btn" disabled>Locked</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div id="cardDetailModal" class="modal-overlay">
        <div class="modal-content">
            <span class="modal-close-btn">&times;</span>
            <img id="modalCardImg" src="" alt="Card View Usage Detail">
            <h2 id="modalCardName"></h2>
            <p id="modalCardDesc"></p>
        </div>
    </div>

    <script src="js/LR.js"></script>
    
</body>
</html>