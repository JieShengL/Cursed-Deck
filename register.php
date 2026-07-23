<?php
/*Programmer name: Mr Mervin Chan
Program name: register.php
Description: register account
First written on: Wed, 10-June-2026
Edited on: Wed, 10-June-2026*/
include 'dbConn.php';

$message = "";

if (isset($_POST['btnRegister'])) {

    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = md5($_POST['password']);
    $confirm_password = md5($_POST['confirm_password']);

    // Check passwords
    if ($password != $confirm_password) {
        $message = "Passwords do not match!";
    } else {

        // Check email already exists
        $check = mysqli_query($conn, "SELECT * FROM user WHERE email_address='$email'");

        if (mysqli_num_rows($check) > 0) {

            $message = "Email already exists.";

        } else {
            // Insert user
            $insertUser = mysqli_query($conn,
                "INSERT INTO user (email_address, username, password)
                 VALUES ('$email','$username','$password')");

            if ($insertUser) {

                // Get new user id
                $user_id = mysqli_insert_id($conn);

                // Create default account
                mysqli_query($conn,
                    "INSERT INTO account (user_id, account_level, account_rank)
                     VALUES ($user_id,1,'Clubs')");

                echo "<script>
                        alert('Account created successfully!');
                        window.location='login.php';
                      </script>";
                exit();

            } else {
                $message = "Registration failed.";
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
    <title>Register Page</title>
    <link rel="stylesheet" href="css/login.css">
    <!--<img src="images/topleft.png" class="topleft">
    <img src="images/topright.png" class="topright">
    <img src="images/bottomleft.png" class="bottomleft">
    <img src="images/bottomright.png" class="bottomright">  -->  
</head>
<body>
    <div class="loginContainer">
        <a href="login.php" id="exit">Back</a>
        <h1 class="Title">Create Account</h1>
        <?php
        if ($message != "") {
            echo "<p style='color:red;text-align:center;'>$message</p>";
        }
        ?>
        <form action="" method="POST">
            <div class="inputBox">
                <label>Email</label>
                <input type="email" name="email" required> 
            </div>

            <div class="inputBox">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>

            <div class="inputBox">
                <label>Password</label>
                <input type="password" name="password" required> 
            </div>

            <div class="inputBox">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" required> 
            </div>
            <input class="confirm" type="submit" name="btnRegister" value="Confirm">
        </form>
    </div>
</body>
</html>