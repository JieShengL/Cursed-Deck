<?php
/*Programmer name: Mr Khow Yong Jing
Program name: preparation.php
Description: preparation screen to fight boss
First written on: Wed, 3-June-2026
Edited on: Fri, 12-June-2026*/
    session_start();
    if (!$_SESSION['email']) {
        header("Location: login.php");
        exit();
    }

    if (!isset($_GET['map']) || empty(trim($_GET['map']))) {
        header("Location: map.php");
        exit();
    }

    $map = trim($_GET['map']);

    if ($map == "barredgate" || $map == "ancientruins" || $map == "abandonment" || $map == "oldmine" || $map == "hoarfrostridge"){
        echo("<script>alert('Not yet unlocked');window.location.href='map.php';</script>");
        exit();
    }

    $mapConfigs = [
        'kings_manse'    => ['title' => "King's Manse",    'bg' => "images/preparation/Kings_Manse.png"],
        'monastery'      => ['title' => "Monastery",       'bg' => "images/preparation/Monastery.png"],
        'sanctum'        => ['title' => "Sanctum",         'bg' => "images/preparation/Sanctum.png"],
        'miretown'       => ['title' => "Miretown",        'bg' => "images/preparation/Mire_Town.png"],
        'whitewoods'     => ['title' => "Whitewoods",      'bg' => "images/preparation/The White Woods.png"],
        'barredgate'     => ['title' => "Barred Gate",     'bg' => "images/preparation/The Barred Gate.png"],
        'ancientruins'   => ['title' => "Ancient Ruins",   'bg' => "images/preparation/The Ancient Ruins.png"],
        'abandonment'    => ['title' => "Abandonment",     'bg' => "images/preparation/Abandonment.png"],
        'oldmine'        => ['title' => "Old Mine",        'bg' => "images/preparation/The Old Mine.png"],
        'hoarfrostridge' => ['title' => "Hoarfrost Ridge", 'bg' => "images/preparation/Hoarfrost Ridge.png"]
    ];

    if (!array_key_exists($map, $mapConfigs)) {
        header("Location: map.php");
        exit();
    }
    $activeConfig = $mapConfigs[$map];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Preparation - <?php echo htmlspecialchars($activeConfig['title']); ?></title>
    <style>
        /* Center everything cleanly inside the window display */
body {
    background-color: black;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    font-family: 'RingBearer', Arial, sans-serif;
    overflow: hidden;
}

.game-viewport {
    position: relative;
    display: inline-block; 
    width: 90vw;           
    max-width: 1200px;     
}

.game-bg-image {
    width: 100%;
    height: auto;
    display: block; 
}

.exit-btn {
    position: absolute;
    top: 4%;
    left: 3.5%;
    font-size: 1.5rem;
    color: yellow;
    text-decoration: none;
    font-weight: bold;
}

.edit-btn {
    position: absolute;
    top: 64.8%; 
    left: 71.7%;
    width: 22%;
    height: 7.6%;
    color: transparent;
    text-decoration: none;
    cursor: pointer; 
}
    </style>
</head>
<body>

    <div class="game-viewport">
        <img src="<?php echo htmlspecialchars($activeConfig['bg']); ?>" alt="Game Interface" class="game-bg-image">
        
        <a href="map.php" class="exit-btn">Back</a>
        <a href="edit.php?map=<?php echo urlencode($map); ?>" class="edit-btn">Edit Deck</a>
    </div>

</body>
</html>