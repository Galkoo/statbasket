<?php
session_start();
require_once "povezava.php";

if(!isset($_SESSION["prijavljen"]) ||
$_SESSION["uporabnik"]["Vloga"]!="admin"){

header("Location: index.php");
exit();

}
?>

<h1>Admin panel</h1>

<a href="dodaj_ekipo.php">Dodaj ekipo</a><br>
<a href="dodaj_igralca.php">Dodaj igralca</a><br>
<a href="dodaj_tekmo.php">Dodaj tekmo</a><br>
<a href="index.php">Nazaj</a>
