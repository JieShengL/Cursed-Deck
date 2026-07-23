<?php
/*Programmer name: Mr Khow Yong Jing
Program name: map.php
Description: map screen
First written on: Wed, 10-June-2026
Edited on: Fri, 12-June-2026*/
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
    <title>Map</title>
</head>
<style>
    body{
        background-color:black;
    }
    .map{
        position: relative;
        width: 90%;
        margin: auto;
    }

    .map img{
        width: 100%;
        display: block;
    }

    .location{
        position: absolute;
        width: 6%;
        height: 6%;
        border-radius: 50%;
        transition: 0.3s;
    }

    .location:hover{
        background: rgba(255,215,0,0.35);
        box-shadow: 0 0 60px gold;
    }

    .exit{
        top: 3%;
        left: 3%;
    }


    #kings{
        top: 7%;
        left: 21.7%;
    }

    #monastery{
        top: 10.2%;
        left: 70.6%;
    }

    #sanctum{
        top: 25%;
        left: 46.8%;
    }

    #mire{
        top: 34.7%;
        left: 18.5%;
    }

    #woods{
        top: 37.5%;
        left: 75.6%;
    }

    #gate{
        top: 42.5%;
        left: 48.4%;
        width: 6%;
        height: 7%;
    }

    #ruins{
        top: 54.5%;
        left: 19%;
    }

    #abandon{
        top: 57.5%;
        left: 69.2%;
    }

    #mine{
        top: 75.7%;
        left: 28.2%;
    }

    #ridge{
        top: 78.5%;
        left: 62.5%;
    }
</style>
<body class="container">
    <div class="map">
        <img src="images/map.jpeg" alt="Game Map">
        <a href="main.php" class="exit">Back</a>
        
        <a href="preparation.php?map=kings_manse" class="location" id="kings"></a>
        <a href="preparation.php?map=monastery" class="location" id="monastery"></a>
        <a href="preparation.php?map=sanctum" class="location" id="sanctum"></a>
        <a href="preparation.php?map=miretown" class="location" id="mire"></a>
        <a href="preparation.php?map=whitewoods" class="location" id="woods"></a>
        <a href="preparation.php?map=barredgate" class="location" id="gate"></a>
        <a href="preparation.php?map=ancientruins" class="location" id="ruins"></a>
        <a href="preparation.php?map=abandonment" class="location" id="abandon"></a>
        <a href="preparation.php?map=oldmine" class="location" id="mine"></a>
        <a href="preparation.php?map=hoarfrostridge" class="location" id="ridge"></a>
    </div>
</body>
</html>