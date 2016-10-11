<?php

include_once "login.html";
require_once "database.php";

session_start();

try {
    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $val = $conn->prepare("SELECT email, password, Verified FROM users WHERE email = :email AND password = :password AND Verified = :Verified");
    $result = $conn->prepare('SELECT email, password');
    $result->bindParam(':email', $email);
    $result->execute();
} catch
(PDOException $e) {
    //        echo $sql . "<br>" . $e->getMessage();
}


if (auth($_POST['login'], $_POST['passwd']) == "TRUE") {
    $_SESSION['loggued_on_user'] = $_POST['login'];
    // echo "OK\n";
}
else {
    $_SESSION['loggued_on_user'] = "";
    echo "ERROR\n";
    return ;
}
if ($_SESSION['loggued_on_user'] != NULL)
{


}


?>