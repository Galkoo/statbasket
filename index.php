<?php
session_start();
require_once "povezava.php";
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>StatBasket</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h1>🏀 StatBasket</h1>

<?php if(isset($_SESSION["prijavljen"])): ?>

<p>Prijavljen kot:
<?= $_SESSION["uporabnik"]["Ime"] ?>
(<?= $_SESSION["uporabnik"]["Vloga"] ?>)</p>

<?php endif; ?>

<div class="menu">

<?php if(!isset($_SESSION["prijavljen"])): ?>

<a href="prijava.php">Prijava</a>
<a href="registracija.php">Registracija</a>

<?php else: ?>

<?php if($_SESSION["uporabnik"]["Vloga"]=="admin" || $_SESSION["uporabnik"]["Vloga"]=="sodnik"): ?>

<a href="dodaj_ekipo.php">Dodaj ekipo</a>
<a href="dodaj_igralca.php">Dodaj igralca</a>
<a href="dodaj_tekmo.php">Dodaj tekmo</a>
<a href="vnos_statistike.php">Dodaj statistiko</a>
<a href="urejanje_statistik.php">Urejanje statistik</a>

<?php endif; ?>

<?php if($_SESSION["uporabnik"]["Vloga"]=="admin"): ?>

<a href="admin.php">Admin panel</a>

<?php endif; ?>

<a href="logout.php">Odjava</a>

<?php endif; ?>

</div>

<hr>

<h2>Tekme</h2>

<?php

$query="SELECT t.Datum,ed.Ime_ekipe AS Domaca,eg.Ime_ekipe AS Gostujoca,
t.Rezultat_Dom,t.Rezultat_Gos
FROM Tekme t
INNER JOIN Ekipe ed ON t.Ekipa_Dom=ed.e_id
INNER JOIN Ekipe eg ON t.Ekipa_Gos=eg.e_id
ORDER BY t.Datum DESC";

$rez=mysqli_query($conn,$query);

while($row=mysqli_fetch_assoc($rez)){

echo $row["Datum"]." | ".$row["Domaca"]." ".
$row["Rezultat_Dom"]." : ".
$row["Rezultat_Gos"]." ".
$row["Gostujoca"]."<br>";

}

?>

</div>
</body>
</html>
