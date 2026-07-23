<?php
/*Programmer name: Mr Lin Xu Zhi
Program name: profile.php
Description: user profile screen
First written on: Tue, 16-June-2026
Edited on: Wed, 17-June-2026*/
include 'dbConn.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Access Denied: Please log in to view your profile.");
}

$currentUser = (int)$_SESSION['user_id'];

$profile_query = "SELECT u.username, a.account_level, a.account_rank, a.xp 
                  FROM account a 
                  JOIN user u ON a.user_id = u.user_id 
                  WHERE a.user_id = $currentUser";

$profile_result = mysqli_query($conn, $profile_query);
$user_data = $profile_result->fetch_assoc();

$username = $user_data['username'] ?? 'Username';
$level = isset($user_data['account_level']) ? (int)$user_data['account_level'] : 6;
$rank_tier = $user_data['account_rank'] ?? 'Unranked'; 
$xp = isset($user_data['xp']) ? (int)$user_data['xp'] : 0;

$max_xp = 100;
$xp_percentage = min(($xp / $max_xp) * 100, 100);

$txt_file_path = "cardsInventory/user_" . $currentUser . "_cards.txt";
$total_cards = 0;

if (file_exists($txt_file_path)) {
    $lines = file($txt_file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $total_cards = count(array_unique(array_map('trim', $lines)));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="css/profile.css?v=<?php echo time(); ?>">
    <style>
    #exit{
        position: absolute;
        top: 14%;
        left: 13%;
        font-size: 30px;
        color: Yellow;
        text-decoration: none;
        font-weight: bold;
    }

    #exit:hover{
        color: rgba(235, 211, 78, 0.75)
    }

    #reset{
        position: absolute;
        top: 14%;
        left: 83%;
        font-size: 30px;
        color: Yellow;
        text-decoration: none;
        font-weight: bold;
    }

    #reset:hover{
        color: rgba(235, 211, 78, 0.75)
    }
    </style>
</head>
<body>
    <a href="main.php" id="exit">Back</a>
    <div class="profile-card-wrapper">
        
        <h1 class="profile-title">Profile</h1>

        <div class="profile-header-section">
            <div class="level-badge-box">LVL <?php echo $level; ?></div>
            <div class="user-meta-details">
                <h2 class="display-username"><?php echo htmlspecialchars($username); ?></h2>
                
                <div class="xp-container">
                    <div class="xp-bar-track">
                        <div class="xp-bar-fill" style="width: <?php echo $xp_percentage; ?>%;"></div>
                    </div>
                    <div class="xp-numerical-legend"><?php echo $xp; ?> / <?php echo $max_xp; ?> XP</div>
                </div>

            </div>
        </div>

        <div class="profile-stats-list">
            <div class="stat-row">
                <span class="stat-label">Rank Tier</span>
                <span class="stat-value"><?php echo htmlspecialchars(ucfirst($rank_tier)); ?></span>
            </div>
            <div class="stat-row">
                <span class="stat-label">Total Card Collection</span>
                <span class="stat-value"><?php echo $total_cards; ?></span>
            </div>
        </div>
    </div>
    <a href="resetpass.php" id="reset">Reset Password</a>
</body>
</html>