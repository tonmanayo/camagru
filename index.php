<?php

require_once "config/database.php";

session_start();
$password = $_POST['password'];
$email = $_POST['email'];
$Verify = 1;
$err_str = NULL;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $get_hash = $conn->prepare("SELECT Password FROM users WHERE Email= :Email");
        $get_hash->bindParam(':Email', $email);
        $get_hash->execute();
        $hash = $get_hash->fetchColumn();

        if (password_verify($password, $hash)) {
            $val = $conn->prepare("SELECT Email, Verify FROM users WHERE Email= :Email AND Verify= :Verify");
            $val->bindParam(':Email', $email);
            $val->bindParam(':Verify', $Verify);
            $val->execute();
            if ($val->rowCount() > 0) {
                $_SESSION['loggued_on_user'] = $email;
                header("Location: home.php");
            }
        } else {
            $err_str = "bad email, password combination or email not verified";
        }
    } catch
    (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="page_style.css">
    <title>Login</title>
</head>

<body>
<div id="header">
    <div class="container">
        <div id="logo"><img src="img/Camagru.png"> </div>
        <div id="navigation">
            <ul id="navtabs">
                <a href=""><li>Home</li></a>
                <a href=""><li>Profile</li></a>
                <a href=""><li>Gallery</li></a>
                <a href="Create_account.php"><li>Create Account</li></a>
                <a href=""><li>Logout</li></a>se
            </ul>
        </div>
    </div>
</div>

<div id="body">
    <div class="container page">
        <h1 style="text-align: center">Welcome to Camagru</h1>
        <h2 style="text-align: center">Please login or sign up</h2>
        <div class="login_container">
            <img src="https://thenecromongersblog.files.wordpress.com/2014/01/linux-matrix-binary-extreme-edition-punisher-hd-wallpaper-101034.jpg">
            <form method="post" action="index.php" name="index.php">
                <div class="form-input">
                    <input type="text" name="email" placeholder="Email Address">
                </div>
                <div class="form-input">
                    <input type="password" name="password" placeholder="Password">
                </div>
                <input id="btn-login" type="submit" name="login" value="Login">
                <div> <a href="">Forgot Password?</a></div>
                <div>
                    <p style="color: red; text-align: center"><?php if ($err_str != NULL) {echo "$err_str";} ?> </p>
                </div>
            </form>
        </div>
    </div>

</div>
<div id="footer"><p>Tony Mack © 2016 </p> </div>
</body>
</html>
