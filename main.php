<?php
/*Programmer name: Mr Lohendraa
Program name: main.php
Description: redirected to main menu screen
First written on: Thurs, 11-June-2026
Edited on: Thurs, 11-June-2026*/
session_start();
if (!$_SESSION['email']) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Main Page</title>
</head>
<body class="start">
    <div class="container">
        <div class="card">
        <br>
        <h1>Cursed Deck</h1>
        <br>
        <h2></h2>
            <a href="intro.php"><button>START GAME</button></a>
            <br><br>
            <a href="general.php"><button>SETTINGS</button></a>    
            <br><br>
            <a href="leaderboard.php"><button>LEADERBOARD</button></a>    
            <br><br>
            <a href="inventory.php"><button>INVENTORY</button></a>
            <br><br>
            <a href="profile.php"><button>PROFILE</button></a>
            <br><br>
            <a href="logout.php"><button>LOG OUT</button></a>

    </div>
    </div>
    
</body>
</html>