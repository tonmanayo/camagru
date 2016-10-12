<?php
include_once "config/database.php";

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="page_style.css">
    <link rel="stylesheet" href="signup.css">
    <title>Sign up</title>
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
                <a href=""><li>Logout</li></a>
            </ul>
        </div>
    </div>
</div>

<div id="body">
    <div class="container page">
        <h1 style="text-align: center">ACCOUNT VERIFIED</h1>
        <div class="login_container" style="border: solid silver 3px ; padding: 1%">
            <br /><br />
            <h2 style="padding-top: 20%" ><a href="../old/login.html"> click here to verify account and return to login
                    <?php
                    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $email = $_GET['email'];
                    $ver = $conn->prepare("SELECT email FROM users where email = :email ");
                    $ver->bindValue(':email', $email);
                    $ver->execute();
                    if ($ver->rowCount() > 0){
                        $up = $conn->prepare("UPDATE users SET Verify='1' where email = :email");
                        $up->bindValue(':email', $email);
                        $up->execute();
                    }
                    ?>

                </a> </h2>
        </div>

    </div>
</div>
<div id="footer"><p>Tony Mack © 2016 </p> </div>
</body>
</html>
