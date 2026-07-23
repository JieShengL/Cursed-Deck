<?php
/*Programmer name: Mr Mervin Chan
Program name: forgotpass.php
Description: allows players to use temporary password
First written on: Sun, 31-May-2026
Edited on: Sun, 31-May-2026*/
    include "dbConn.php";
    session_start();

    if (isset($_POST['btnForgot'])){
        $email = trim($_POST['email']);

        $query = "SELECT username FROM user WHERE email_address = ?";
        
        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) == 1) {
                // 1. Generate the plain text password for the user to read
                $temporaryPassword = substr(bin2hex(random_bytes(4)), 0, 8);

                // 2. Encrypt it into an MD5 hash for the database
                $hashedPassword = md5($temporaryPassword);

                $updateQuery = "UPDATE user SET password = ? WHERE email_address = ?";
                
                if ($updateStmt = mysqli_prepare($conn, $updateQuery)) {
                    // 3. Bind the hashed password ($hashedPassword) instead of the plain text one
                    mysqli_stmt_bind_param($updateStmt, "ss", $hashedPassword, $email);
                    mysqli_stmt_execute($updateStmt);
                    
                    // 4. Show the readable plain text ($temporaryPassword) so they know what to type on login
                    echo "<script>
                        alert('Account Verified! Your temporary password is: " . $temporaryPassword . "\\nPlease use this to login and change your password inside the dashboard.');
                        window.location.href='login.php';
                    </script>";
                    exit();
                }
            } else {
                echo "<script>alert('No account associated with that email address found!');window.location.href='forgotpass.php';</script>";
                exit();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="loginContainer">
        <a href="login.php" id="exit">Back</a>
        <h1 class="Title">Forgot Password</h1>
        <p class="description">Please enter your account email</p>
        
        <form action="" method="POST">
            <div class="inputBox">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <input class="confirm" type="submit" name="btnForgot" value="Send" style="margin-top: 30px;">
        </form>
    </div>
</body>
</html>