<?php
session_start();
require_once __DIR__ . '/povezava.php';

if(!isset($_SESSION["prijavljen"])) {
header("Location: prijava.php");
exit();
}

$query="
SELECT
s.s_id,
i.Ime,
i.Priimek,
s.Tocke,
s.Skoki,
s.Podaje
FROM Statistika s
INNER JOIN Igralci i
ON s.i_id=i.i_id
";

$rez=mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Urejanje statistik</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h1>Urejanje statistik</h1>

<table>

<tr>
<th>Igralec</th>
<th>Točke</th>
<th>Skoki</th>
<th>Podaje</th>
</tr>

<?php

while($r=mysqli_fetch_assoc($rez)){

echo "<tr>";

echo "<td>".htmlspecialchars($r['Ime']." ".$r['Priimek'])."</td>";
echo "<td>".htmlspecialchars($r['Tocke'])."</td>";
echo "<td>".htmlspecialchars($r['Skoki'])."</td>";
echo "<td>".htmlspecialchars($r['Podaje'])."</td>";

echo "</tr>";

}

?>

</table>

</div>

</body>
</html>