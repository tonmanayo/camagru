<?php
include_once "config/database.php";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
$password = "";
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $surname = test_input($_POST['surname']);
    $email = test_input($_POST['email']);
    $name = test_input($_POST['name']);
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
        $err_name = 1;
        $err_str = $err_str . " * Name invalid";
    }
    if (!preg_match("/^[a-zA-Z ]*$/",$surname)) {
        $err_surname = 1;
        $err_str = $err_str . " * Surame invalid";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $err_email = 1;
        $err_str = $err_str . " * Email invalid";
    }
    $re_password =  $_POST['re-password'];
    $password =  $_POST['password'];
    if ($re_password != $password) {
        $err_str = $err_str . " * Passwords don't match invalid";
        $err_passwd = 1;
    }
    $password_h =  password_hash(test_input($_POST['password']), PASSWORD_DEFAULT);
    $submit = test_input($_POST['submit']);
}
    if ($err_name != 1 && $err_email != 1 && $err_surname != 1 && $err_passwd != 1) {
        try {
            $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $val = $conn->prepare("INSERT INTO users (Name, Surname, Email, Password ) VALUES (:Name, :Surname, :Email, :Password)");
            $result = $conn->prepare('SELECT * FROM users WHERE Email = :Email');
            $result->bindParam(':Email', $email);
            $result->execute();
            if ($result->rowCount() > 0) {
                $err_str = $err_str . " * Email Address Already Exists!";
                $err_email = 1;
            }
            if (!$err_email){
                $val->bindParam(':Name', $name);
                $val->bindParam(':Surname', $surname);
                $val->bindParam(':Password', $password_h);
                $val->bindParam(':Email', $email);
                $val->execute();

                $to      = $email;
                $subject = 'Signup | Verification';
                $message = '
 
Thanks for signing up!
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
 
------------------------
Username: '.$name.'
Password: '.$password.'
------------------------
 
Please click this link to activate your account:
http://e5r10p4:8080/camagru/verify.php?email='.$email.'&hash='.$password_h.'
 
';

                $headers = 'From:noreply@e5r10p4.com' . "\r\n";
                if (mail($to, $subject, $message, $headers))
                    header('Location: index.php');
                else
                    echo "bad";

            }
        }
        catch (PDOException $e) {
    //        echo $sql . "<br>" . $e->getMessage();
        }
    }
    $conn = null;
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
        <h1 style="text-align: center">Please Enter Details To Sign Up</h1>
        <div class="login_container" style="border: solid silver 3px ; padding: 1%">
            <img src="https://thenecromongersblog.files.wordpress.com/2014/01/linux-matrix-binary-extreme-edition-punisher-hd-wallpaper-101034.jpg" >
            <form action="Create_account.php" method="post" name="Create_account.php ">
                <input <?php if ($err_name) {echo "class='error_input'";} ?> id="first-name" type="text" name="name" placeholder="First Name"<?php if(!$err_name) {echo "value='$name'";} ?> required >
                <input <?php if ($err_surname) {echo "class='error_input'";} ?> id="surname" type="text" name="surname" placeholder="Surname" <?php if(!$err_surname) {echo "value='$surname'";} ?> required>
                <input <?php if ($err_passwd) {echo "class='error_input'";} ?>  id="password" type="password" name="password" placeholder="Password" required>
                <input <?php if ($err_passwd) {echo "class='error_input'";} ?>  id="password" type="password" name="re-password" placeholder="Re-type Password" required>
                <input <?php if ($err_email) {echo "class='error_input'";} ?> id="email" type="text" name="email" placeholder="Email Address" <?php if(!$err_email) {echo "value='$email'";} ?> required>
                <input id="btn-login" type="submit" name="submit" value="Submit">
            </form>
        </div>
        <div>
            <p style="color: red; text-align: center"><?php if ($err_str != NULL) {echo "$err_str";} ?> </p>
        </div>
    </div>
</div>
<div id="footer"><p>Tony Mack © 2016 </p> </div>
</body>
</html>

