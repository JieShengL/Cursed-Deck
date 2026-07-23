<?php
/*Programmer name: Mr Lohendraa
Program name: set_sidebar.php
Description: apply setting sidebars
First written on: Wed, 17-June-2026
Edited on: Wed, 17-June-2026*/
session_start();
?>
<head>
    <link rel="stylesheet" href="css/style.css">
</head>
<div class="sidebar">
    <a href="general.php">General</a><br>
    <a href="audio.php">Audio</a><br>
    <a href="graphic.php">Graphics</a>
    <?php if (!isset($_SESSION['email'])){ ?>
        <a href="guestmain.php">Back</a> <?php
    } else { ?>
        <a href="main.php">Back</a> <?php
    } ?>
</div>
