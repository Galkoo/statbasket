<?php
session_start();
require_once __DIR__ . '/povezava.php';
?>

<!DOCTYPE html>
<html lang="sl">
<head>
<meta charset="UTF-8">
<title>StatBasket</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h1>StatBasket</h1>

<p class="podnaslov">
Statistika košarkarskih tekem in igralcev
</p>

<?php if(isset($_SESSION["prijavljen"])): ?>

<p>
Prijavljen kot:
<strong><?= htmlspecialchars($_SESSION["uporabnik"]["Ime"]) ?></strong>
(<?= htmlspecialchars($_SESSION["uporabnik"]["Vloga"]) ?>)
</p>

<a href="logout.php">Odjava</a>

<?php else: ?>

<a href="prijava.php">Prijava</a>
<a href="registracija.php">Registracija</a>

<?php endif; ?>

<hr>

<h2>Zadnje tekme</h2>

<?php

$query = "
SELECT
t.Datum,
ed.Ime_ekipe AS Domaca,
eg.Ime_ekipe AS Gostujoca,
t.Rezultat_Dom,
t.Rezultat_Gos
FROM Tekme t
INNER JOIN Ekipe ed ON t.Ekipa_Dom = ed.e_id
INNER JOIN Ekipe eg ON t.Ekipa_Gos = eg.e_id
ORDER BY t.Datum DESC
";

$rezultat = mysqli_query($conn,$query);

if(mysqli_num_rows($rezultat) > 0){

echo "<ul>";

while($t = mysqli_fetch_assoc($rezultat)){

echo "<li>";

echo htmlspecialchars($t['Datum'])." | ";
echo htmlspecialchars($t['Domaca'])." ";
echo htmlspecialchars($t['Rezultat_Dom'])." : ";
echo htmlspecialchars($t['Rezultat_Gos'])." ";
echo htmlspecialchars($t['Gostujoca']);

echo "</li>";

}

echo "</ul>";

}else{

echo "Ni vnešenih tekem.";

}

?>

</div>

</body>
</html>