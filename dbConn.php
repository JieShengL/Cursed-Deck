<?php
/*Programmer name: Mr Khow Yong Jing
Program name: dbConn.php
Description: database connection
First written on: Fri, 30-May-2026
Edited on: Fri, 30-May-2026*/
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cp";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if(!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }
?>
