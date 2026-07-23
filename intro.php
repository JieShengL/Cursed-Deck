<?php
/*Programmer name: Mr Cristhiphon
Program name: intro.php
Description: introduction screen display
First written on: Sat, 30-May-2026
Edited on: Sat, 30-May-2026*/
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
    <title>Intro</title>
</head>
<style>
    body{
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                    url(images/intro.jpeg) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: 70%;
        background-color: black;
        font-family: RingBearer;
    }
    .card{
        width: 50%;
    }
    .content{
        margin:0 ;
        width: 100%;
        padding:10px;
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5));
    }
    a{
        background: #9e179e;
        display: inline-block;
        color: white;
        font-size: 40px;
        text-decoration: none;
        width: 190px;
        padding:15px;
        margin-top: 10px;
        border-radius: 10px;
    }

    P{
        color: white;
        font-size: 40px;
    }
</style>
<body>
    <div class="container">
        <div class="card">
            <div class="content">
                <p>A DARK FORCE SPREADS ACROSS THE KINGDOM. HAN REN BEGINS HIS JOURNEY TOWARD FINAL GATE, FACING 
                DANGEROUS TRIALS AND POWERFUL ENEMIES ALONG THE WAY</p>   
            </div>
            <a href="map.php">Continue</a>
        </div>
    </div>
</body>
</html>