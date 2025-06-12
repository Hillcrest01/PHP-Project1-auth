<?php
//set the connection with the database
// $pdo = new PDO('mysql:host=localhost;dbname=login_db', 'root', 'Kulundeng.Jamach.1');

// //catch any error that may arise during the connection and throw it.
// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// //check if the form has been submitted using the submit button

$hostname = "Localhost";
$dbuser = "root";
$dbname = "login_db";
$dbpassword = "Kulundeng.Jamach.1";

$conn = mysqli_connect($hostname, $dbuser, $dbpassword, $dbname);

if(!$conn){
    die("Something went wrong");
}

?>

