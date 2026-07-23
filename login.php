<?php
/*Programmer name: Mr Mervin Chan
Program name: login.php
Description: login account
First written on: Wed, 3-June-2026
Edited on: Thurs, 4-June-2026*/
    include "dbConn.php";
    session_start();

    if (isset($_POST['btnLogin'])){
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        $query = "SELECT * FROM user
            WHERE username = '$username'";

        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {

            $row = mysqli_fetch_assoc($result);

            if ($password == $row['password']) {

                $_SESSION['email'] = $row['email_address'];
                $_SESSION['user_id'] = $row['user_id'];

                echo "<script>
                        alert('Login Successfully!');
                        window.location.href='main.php';
                    </script>";
                exit();
            } else {
                echo "<script>
                        alert('Wrong Username or Password!');
                        window.location.href='login.php';
                    </script>";
                exit();
            }
        } else {
            echo "<script>alert('No Username Found!');window.location='login.php';</script>";
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/login.css">
    <!--<img src="images/topleft.png" class="topleft">
    <img src="images/topright.png" class="topright">
    <img src="images/bottomleft.png" class="bottomleft">
    <img src="images/bottomright.png" class="bottomright"> -->
</head>
<body>
    
    <div class="loginContainer">
        <a href="guestmain.php" id="exit">Back</a>
        <h1 class="Title">Login</h1>

        <form action="#" method="POST">
            <div class="inputBox">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>

            <div class="inputBox">
                <label>Password</label>
                <input type="password" name="password" required> 
            </div>

            <input class="confirm" type="submit" name="btnLogin" value="Confirm" style="margin-top: 30px;">
            
            <a href="forgotpass.php" class="newpass">Forgot Password?</a>
            <a href="register.php" class="newpass">Sign In</a>

        </form>
    </div>
</body>
</html>