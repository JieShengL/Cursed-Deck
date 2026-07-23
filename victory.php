<?php
/*Programmer name: Mr Khow Yong Jing
Program name: victory.php
Description: victory screen display
First written on: Wed, 3-June-2026
Edited on: Wed, 3-June-2026*/   
include "dbConn.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$currentUser = (int)$_SESSION['user_id'];
$map = isset($_GET['map']) ? trim($_GET['map']) : '';

$user_query = "SELECT account_level, account_rank FROM account WHERE user_id = $currentUser";
$user_result = mysqli_query($conn, $user_query);
$user_data = mysqli_fetch_assoc($user_result);

$old_level = $user_data ? (int)$user_data['account_level'] : 1;
$current_rank = $user_data ? $user_data['account_rank'] : 'Bronze';

$xp_gained = 150;
$rank_points_gained = 25;

$new_level = $old_level + 1; 

$update_query = "UPDATE account SET account_level = $new_level WHERE user_id = $currentUser";
mysqli_query($conn, $update_query);
$card_query = "SELECT card_name, card_image FROM card WHERE lvl_req = $new_level";
$card_result = mysqli_query($conn, $card_query);

$unlocked_cards = [];
while ($row = mysqli_fetch_assoc($card_result)) {
    $unlocked_cards[] = [
        'name'  => $row['card_name'],
        'image' => trim($row['card_image'])
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Victory - Rewards</title>
    <style>
        body {
            background: url("images/victory.jpeg");
            background-size: 90%;
            background-attachment: fixed; 
            background-position: 50% 30%;
            background-repeat: no-repeat;
            background-color: rgb(26, 26, 26);
            color: white;
            margin: 0;
            padding: 0;
        }
        h1{
            margin-bottom: 0;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            margin-top: 10px;
            padding-bottom: 0;
        }

        .progression-panel {
            background: rgba(0, 0, 0, 0.85);
            border: 2px solid #ffcc00;
            border-radius: 12px;
            padding: 25px;
            width: 90%;
            max-width: 550px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.8);
        }

        .stat-row {
            margin-bottom: 25px;
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }

        .xp-text { color: #00ffcc; }
        .rank-text { color: #ff9900; }
        .gain-badge {
            background: rgba(255,255,255,0.1);
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 1rem;
            animation: pulse 1.5s infinite alternate;
        }

        .progress-bar-container {
            background: #222;
            border: 1px solid #444;
            height: 18px;
            border-radius: 9px;
            overflow: hidden;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            width: 0%;
            transition: width 2s cubic-bezier(0.1, 0.8, 0.3, 1);
        }

        .xp-fill {
            background: linear-gradient(90deg, #00aa88, #00ffcc);
            box-shadow: 0 0 10px #00ffcc;
        }

        .rank-fill {
            background: linear-gradient(90deg, #cc6600, #ff9900);
            box-shadow: 0 0 10px #ff9900;
        }
        .level-up-alert {
            text-align: center;
            color: #ffcc00;
            font-size: 1.5rem;
            font-weight: bold;
            margin-top: 15px;
            border-top: 1px dashed #444;
            padding-top: 15px;
        }

        /* Cards Layout */
        .unlocked-cards-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 15px;
        }

        .reward-card {
            width: 130px;
            height: 180px;
            background-size: cover;
            background-position: center;
            border-radius: 8px;
            border: 2px solid #ffcc00;
            display: flex;
            align-items: flex-end;
            box-shadow: 0 4px 10px rgba(0,0,0,0.5);
        }

        .reward-card-name {
            background: rgba(0, 0, 0, 0.8);
            width: 100%;
            color: #fff;
            text-align: center;
            font-size: 0.8rem;
            padding: 5px 2px;
            font-weight: bold;
        }

        button.back-btn {
            padding: 12px 40px;
            font-size: 1.2rem;
            background-color: #ffcc00;
            color: black;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(0,0,0,0.5);
        }

        button.back-btn:hover {
            background-color: #fff;
        }

        @keyframes pulse {
            from { transform: scale(1); opacity: 0.8; }
            to { transform: scale(1.05); opacity: 1; }
        }
    </style>
</head>
<body>

    <h1>Victory</h1>

    <div class="container">
        
        <div class="progression-panel">
            
            <div class="stat-row">
                <div class="stat-header xp-text">
                    <span>EXPERIENCE POINTS (XP)</span>
                    <span class="gain-badge">+<?php echo $xp_gained; ?> XP</span>
                </div>
                <div class="progress-bar-container">
                    <div id="xpBar" class="progress-fill xp-fill" style="width: 35%;"></div>
                </div>
            </div>

            <div class="stat-row">
                <div class="stat-header rank-text">
                    <span>RANK SCORE (Tier: <?php echo htmlspecialchars($current_rank); ?>)</span>
                    <span class="gain-badge">+<?php echo $rank_points_gained; ?> RP</span>
                </div>
                <div class="progress-bar-container">
                    <div id="rankBar" class="progress-fill rank-fill" style="width: 60%;"></div>
                </div>
            </div>

            <div class="level-up-alert">
                🎉 LEVEL UP! Level <?php echo $old_level; ?> ➔ Level <?php echo $new_level; ?> 🎉
            </div>

            <?php if (!empty($unlocked_cards)): ?>
                <div style="text-align:center; margin-top:15px; color:#aaa; font-size:0.95rem;">
                    Milestone Card Dispatched:
                </div>
                <div class="unlocked-cards-container">
                    <?php foreach ($unlocked_cards as $card): ?>
                        <div class="reward-card" style="background-image: url('images/cardImage/<?php echo htmlspecialchars($card['image']); ?>');">
                            <div class="reward-card-name">
                                <?php echo htmlspecialchars($card['name']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
        
        <a href="map.php"><button class="back-btn">Continue</button></a>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            setTimeout(() => {
                document.getElementById("xpBar").style.width = "100%";
                document.getElementById("rankBar").style.width = "85%";
            }, 300);
        });
    </script>

</body>
</html>