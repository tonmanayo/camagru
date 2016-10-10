<?php
include_once "config/database.php";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $surname = test_input($_POST['surname']);
    $email = test_input($_POST['email']);
    $name = test_input($_POST['name']);
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
        $error = $error . "incorrect name\n";
?>
    <script>alert("incorrect name",defaultStatus)</script>
<?php
        return ;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = $error . "incorrect email\n";
        return ;
    }

    $password = test_input($_POST['password']);
    $submit = test_input($_POST['submit']);
}

    if ($name != "") {
        try {
            $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $val = $conn->prepare("INSERT INTO users (name, surname, email, password ) VALUES (:name, :surname, :email, :password)");
            $val->bindParam(':name', $name);
            $val->bindParam(':surname', $surname);
            $val->bindParam(':password', $password);
            $val->bindParam(':email', $email);
            $val->execute();
            echo "New record created successfully";
        } catch
        (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
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
                <a href="signup.html"><li>Create Account</li></a>
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
            <form action="Create_account.php" method="post" name="Create_account.php">
                <input id="first-name" type="text" name="name" placeholder="First Name">
                <input id="surname" type="text" name="surname" placeholder="Surname">
                <input id="password" type="password" name="password" placeholder="Password">
                <input id="email" type="text" name="email" placeholder="Email Address">
                <input id="btn-login" type="submit" name="submit" value="Submit">
            </form>
        </div>
    </div>

</div>
<div id="footer"><p>Tony Mack © 2016 </p> </div>
</body>
</html>

