<?php
/*Programmer name: Mr Lin Xu Zhi
Program name: leaderboard.php
Description: display leaderboard
First written on: Mon, 8-June-2026
Edited on: Wed, 10-June-2026*/
include 'dbconn.php';
session_start();

$currentUser = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;

$selected_tier = isset($_GET['tier']) ? mysqli_real_escape_string($conn, $_GET['tier']) : 'all';

// Build dynamic query depending on what option is selected
$sql = "SELECT u.user_id, u.username, a.account_level, a.account_rank, a.rank_points
        FROM account a
        JOIN user u ON a.user_id = u.user_id";

if ($selected_tier !== 'all') {
    $sql .= " WHERE LOWER(a.account_rank) = '" . strtolower($selected_tier) . "'";
}

$sql .= " ORDER BY 
            CASE LOWER(a.account_rank)
                WHEN 'spades'   THEN 1
                WHEN 'hearts'   THEN 2
                WHEN 'diamonds' THEN 3
                WHEN 'clubs'    THEN 4
                ELSE 5
            END ASC, 
            a.rank_points DESC,
            a.account_level DESC";
$result = mysqli_query($conn, $sql);

// Default values for the current user's info
$myNo = "N/A";
$myName = "N/A";
$myLevel = "N/A";
$myRank = "N/A";
$myPoints = "N/A";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="css/LB.css?v=<?php echo time(); ?>">
    <style>
    #exit{
        position: absolute;
        top: 10%;
        left: 13%;
        font-size: 30px;
        color: Yellow;
        text-decoration: none;
        font-weight: bold;
    }

    #exit:hover{
        color: rgba(235, 211, 78, 0.75)
    }

    </style>
</head>
<body>
    <div class="leaderboard-page-grid">
        <?php if (!isset($_SESSION['email'])) { ?>
            <a href="guestmain.php" id="exit">Back</a> <?php
        } else {?>
            <a href="main.php" id="exit">Back</a> <?php
        } ?>
        
        <aside class="filter-sidebar">
            <h2>Filter Tiers</h2>
            <form action="" method="GET" id="filterForm">
                <label class="option">
                    <input type="radio" name="tier" value="all" <?php echo $selected_tier == 'all' ? 'checked' : ''; ?> onchange="document.getElementById('filterForm').submit();">
                    <span>Show All</span>
                </label>
                <label class="option">
                    <input type="radio" name="tier" value="clubs" <?php echo $selected_tier == 'clubs' ? 'checked' : ''; ?> onchange="document.getElementById('filterForm').submit();">
                    <span>Clubs</span>
                </label>
                <label class="option">
                    <input type="radio" name="tier" value="diamonds" <?php echo $selected_tier == 'diamonds' ? 'checked' : ''; ?> onchange="document.getElementById('filterForm').submit();">
                    <span>Diamonds</span>
                </label>
                <label class="option">
                    <input type="radio" name="tier" value="hearts" <?php echo $selected_tier == 'hearts' ? 'checked' : ''; ?> onchange="document.getElementById('filterForm').submit();">
                    <span>Hearts</span>
                </label>
                <label class="option">
                    <input type="radio" name="tier" value="spades" <?php echo $selected_tier == 'spades' ? 'checked' : ''; ?> onchange="document.getElementById('filterForm').submit();">
                    <span>Spades</span>
                </label>
            </form>
        </aside>

        <div class="leaderboard-container">    
            <h1 class="title">Leaderboard</h1>
            <div class="table-title">
                <span>No.</span>
                <span>Player</span>
                <span>Level</span>
                <span>Rank</span>
                <span>Points</span>
        </div>

        <div class="leaderboard-scroll-box">  
            <table class="player-list-table">
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0):
                        $rank = 1;
                    ?>
                        <?php while($row = $result->fetch_assoc()): 
                            $is_currentUser = (isset($row['user_id']) && (int)$row['user_id'] == $currentUser);
                            if ($is_currentUser) {
                                $myNo = $rank;
                                $myName = htmlspecialchars($row['username']);
                                $myLevel = htmlspecialchars($row['account_level']);
                                $myRank = htmlspecialchars($row['account_rank']);
                                $myPoints = htmlspecialchars($row['rank_points']);
                            }
                        ?>
                            <tr class="<?php echo $is_currentUser ? 'highlight-current-row' : ''; ?>">
                                    <td><?php echo $rank; ?></td>
                                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                                    <td><?php echo htmlspecialchars($row['account_level']); ?></td>
                                    <td><?php echo htmlspecialchars($row['account_rank']); ?></td>
                                    <td><?php echo htmlspecialchars($row['rank_points']); ?></td>
                                </tr>
                        <?php 
                            $rank++; 
                            endwhile; 
                        ?>
                        <?php else: ?>
                            <tr><td colspan='5' style="text-align: center; padding: 30px; font-size: 1.2rem;">No results found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div> 

            <?php if ($selected_tier == 'all'): ?>
                <div class="fixed-user-footer">
                    <span>You: <?php echo $myNo; ?></span>
                    <span><?php echo $myName; ?></span>
                    <span><?php echo $myLevel; ?></span>
                    <span><?php echo $myRank; ?></span>
                    <span><?php echo $myPoints; ?></span>
                </div>
            <?php endif; ?> 
        </div> 
    </div> 
</body>
</html>