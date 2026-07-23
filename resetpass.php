<?php
/*Programmer name: Mr Mervin Chan
Program name: resetpass.php
Description: reset user password
First written on: Fri, 12-June-2026
Edited on: Fri, 12-June-2026*/

    include "dbConn.php";
    session_start();

    if (!isset($_SESSION['email'])) {
        echo "<script>alert('Session expired or unauthorized access! Please login first.');window.location.href='login.php';</script>";
        exit();
    }

    $email = $_SESSION['email'];

    if (isset($_POST['btnReset'])) {
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);

        if ($new_password !== $confirm_password) {
            echo "<script>alert('Passwords do not match! Please try again.');</script>";
        } else {
            $query = "UPDATE user SET password = ? WHERE email_address = ?";
            
            if ($stmt = mysqli_prepare($conn, $query)) {
                mysqli_stmt_bind_param($stmt, "ss", $new_password, $email);
                
                if (mysqli_stmt_execute($stmt)) {
                    session_unset();
                    session_destroy();
                    echo "<script>alert('Password updated successfully! Please login with your new password.');window.location.href='profile.php';</script>";
                    exit();
                } else {
                    echo "<script>alert('Database update failure. Please try again later.');</script>";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="loginContainer">
        <a href="main.php" id="exit">Back</a> 
        
        <h1 class="Title">Reset Password</h1>
        <p class="description">Please enter your new security password</p>
        
        <form action="" method="POST">
            <div class="inputBox">
                <label>New Password</label>
                <input type="password" name="new_password" required>
            </div>

            <div class="inputBox" style="margin-top: 20px;">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" required>
            </div>

            <input class="confirm" type="submit" name="btnReset" value="Confirm" style="margin-top: 30px;">
        </form>
    </div>
</body>
</html>