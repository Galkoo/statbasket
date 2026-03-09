<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "statbasket";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Napaka pri povezavi: " . mysqli_connect_error());
}

?>