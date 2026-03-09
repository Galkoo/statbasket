<?php
session_start();
require_once "povezava.php";
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>StatBasket</title>
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="container">

<h1>🏀 StatBasket</h1>
<p class="subtitle">Statistika košarkarskih tekem in igralcev</p>

<div class="menu">

<?php if(!isset($_SESSION["prijavljen"])): ?>

<a href="prijava.php">Prijava</a>
<a href="registracija.php">Registracija</a>

<?php else: ?>

<a href="dodaj_ekipo.php">Dodaj ekipo</a>
<a href="dodaj_igralca.php">Dodaj igralca</a>
<a href="dodaj_tekmo.php">Dodaj tekmo</a>
<a href="vnos_statistike.php">Dodaj statistiko</a>
<a href="urejanje_statistik.php">Urejanje statistik</a>
<a href="logout.php">Odjava</a>

<?php endif; ?>

</div>

<hr>

<h2>Zadnje tekme</h2>

<?php

$sql = "SELECT t.Datum, ed.Ime_ekipe AS Domaca, eg.Ime_ekipe AS Gostujoca,
t.Rezultat_Dom, t.Rezultat_Gos
FROM Tekme t
INNER JOIN Ekipe ed ON t.Ekipa_Dom = ed.e_id
INNER JOIN Ekipe eg ON t.Ekipa_Gos = eg.e_id
ORDER BY t.Datum DESC";

$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result)>0){

echo "<ul>";

while($row=mysqli_fetch_assoc($result)){

echo "<li>{$row['Datum']} | {$row['Domaca']} {$row['Rezultat_Dom']} : {$row['Rezultat_Gos']} {$row['Gostujoca']}</li>";

}

echo "</ul>";

}else{

echo "Ni tekem.";

}

?>

</div>

</body>
</html>
