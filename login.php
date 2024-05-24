<?php
session_start();
include "connect.php";

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);

    // Check if the user is an admin
    $admin_sql = "SELECT password FROM logindetails WHERE email=? AND user_type='admin'";
    $admin_stmt = mysqli_prepare($mysqli, $admin_sql);
    mysqli_stmt_bind_param($admin_stmt, "s", $email);
    mysqli_stmt_execute($admin_stmt);
    $admin_result = mysqli_stmt_get_result($admin_stmt);

    if ($admin_result && mysqli_num_rows($admin_result) > 0) {
        $admin_row = mysqli_fetch_assoc($admin_result);
        if ($password === $admin_row['password']) {
            $_SESSION['admin'] = true;
            header("Location: admin_dashboard.php");
            exit;
        }
    }

    // Check if the user is a normal user
    $user_sql = "SELECT password FROM logindetails WHERE email=? AND user_type='user'";
    $user_stmt = mysqli_prepare($mysqli, $user_sql);
    mysqli_stmt_bind_param($user_stmt, "s", $email);
    mysqli_stmt_execute($user_stmt);
    $user_result = mysqli_stmt_get_result($user_stmt);

    if ($user_result && mysqli_num_rows($user_result) > 0) {
        $user_row = mysqli_fetch_assoc($user_result);
        if ($password === $user_row['password']) {
            $_SESSION['valid'] = true;
            header("Location: dashboard.php");
            exit;
        }
    }

    echo "<div class='message'><p>Wrong Email or Password!</p></div><br>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header align="center"><b>Login</b></header>
            <form action="login.php" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login">
                </div>

                <div class="links">
                    Don't have an account? <a href="register.php">Sign Up Now</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
