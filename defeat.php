<?php
/*Programmer name: Mr Khow Yong Jing
Program name: defeat.php
Description: defeat screen
First written on: Wed, 3-June-2026
Edited on: Wed, 3-June-2026*/
include "dbConn.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = (int)$_SESSION['user_id'];
$ranks_order = ['Clubs', 'Diamond', 'Hearts', 'Spades'];

// Fetch current statistics
$query = "SELECT account_level, xp, account_rank, rank_points FROM account WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$account = mysqli_fetch_assoc($result);

if (!$account) {
    $account = ['account_level' => 1, 'xp' => 0, 'account_rank' => 'Clubs', 'rank_points' => 0];
}

$lvl = $account['account_level'];
$xp = $account['xp'];
$rank = $account['account_rank'];
$rp = $account['rank_points'];

// Calculate Loss Penalties
$rp_lost = 20; 
$rp -= $rp_lost;

// Handle Rank Demotion
if ($rp < 0) {
    $current_index = array_search($rank, $ranks_order);
    if ($current_index > 0) { // Clubs is the absolute floor
        $rank = $ranks_order[$current_index - 1];
        $rp = 100 - abs($rp); // Deduct deficit overflow from lower tier cap
    } else {
        $rp = 0; // Cap at 0 points for Clubs
    }
}

// Update values inside database
$update = "UPDATE account SET account_level = ?, xp = ?, account_rank = ?, rank_points = ? WHERE user_id = ?";
$upStmt = mysqli_prepare($conn, $update);
mysqli_stmt_bind_param($upStmt, "iisii", $lvl, $xp, $rank, $rp, $user_id);
mysqli_stmt_execute($upStmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Defeat</title>
    <style>
        body {
            background: url("images/defeat.jpeg") no-repeat fixed 50% 30% / 90%, rgb(26, 26, 26);
            color: #fff;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .container { 
            gap:20px; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            justify-content: center; 
            margin-top: 20px;
        }
        .progress-box { 
            background: rgba(0,0,0,0.7); 
            padding: 15px; 
            border-radius: 8px; 
            width: 320px; 
            margin: 10px auto; 
            border: 1px solid #444; 
        }
        .bar-container { 
            background: #333; 
            width: 100%; 
            height: 20px; 
            border-radius: 10px; 
            overflow: hidden; 
            margin-top: 5px; 
            box-shadow: inset 0 2px 5px rgba(0,0,0,0.5); 
        }
        .bar-fill-xp { 
            background: linear-gradient(90deg, #555, #777); 
            height: 100%; 
        }
        .bar-fill-rank { 
            background: linear-gradient(90deg, #f44336, #ff5722); 
            height: 100%; 
        }
        button { 
            background: #f44336; 
            color: white; 
            padding: 10px 20px; 
            border: none; 
            border-radius: 5px; 
            font-size: 1.1em; 
            cursor: pointer; 
            transition: 0.2s; 
        }
        button:hover { 
            background: #d32f2f; 
        }
    </style>
</head>
<body>
    <h1 style="background: linear-gradient(to bottom, #5c0a0a 0%, #e76d6d 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-size: 3em; margin-top: 50px;">DEFEATED</h1>
    
    <div class="container">
        <div class="progress-box">
            <strong>Level <?php echo $lvl; ?></strong> (XP: <?php echo $xp; ?>/100)
            <div style="font-size: 0.85em; color: #aaa;">0 XP Gained on Defeat</div>
            <div class="bar-container">
                <div class="bar-fill-xp" style="width: <?php echo $xp; ?>%;"></div>
            </div>
        </div>

        <div class="progress-box">
            <strong>Rank: <?php echo $rank; ?></strong> (Points: <?php echo $rp; ?>/100)
            <div style="font-size: 0.85em; color: #ff5722;">-<?php echo $rp_lost; ?> Rank Points Lost</div>
            <div class="bar-container">
                <div class="bar-fill-rank" style="width: <?php echo $rp; ?>%;"></div>
            </div>
        </div>
        
        <a href="map.php"><button>Try Again</button></a>
    </div>
</body>
</html>