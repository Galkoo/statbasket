<?php
session_start();

if(!isset($_SESSION["prijavljen"]) ||
$_SESSION["uporabnik"]["Vloga"]!="admin"){

header("Location:index.php");
exit();

}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin panel</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h1>Admin Panel</h1>

<a href="dodaj_ekipo.php">Dodaj ekipo</a>
<a href="dodaj_igralca.php">Dodaj igralca</a>
<a href="dodaj_tekmo.php">Dodaj tekmo</a>
<a href="vnos_statistike.php">Dodaj statistiko</a>
<a href="urejanje_statistik.php">Urejanje statistik</a>

</div>

</body>
</html>