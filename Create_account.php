<?php
include_once "config/database.php";
include_once "signup.html";

$name = $_POST['first name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$password = $_POST['password'];

try {
    $conn =  new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO users (name, surname, email, password)
    VALUES ('John', 'Doe', 'john@example.com', 'toto')";
    $conn->exec($sql);
    echo "New record created successfully";
}
catch(PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>