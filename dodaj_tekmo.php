<?php
session_start();
require_once __DIR__ . '/povezava.php';

if(!isset($_SESSION["prijavljen"])) {
header("Location: prijava.php");
exit();
}

$msg="";

if(isset($_POST["dodaj"])){

$dom=$_POST["dom"];
$gos=$_POST["gos"];
$datum=$_POST["datum"];

$query="INSERT INTO Tekme(Ekipa_Dom,Ekipa_Gos,Datum)
VALUES(?,?,?)";

$stmt=mysqli_prepare($conn,$query);
mysqli_stmt_bind_param($stmt,"iis",$dom,$gos,$datum);

if(mysqli_stmt_execute($stmt)){
$msg="Tekma dodana.";
}

}

$ekipe=mysqli_query($conn,"SELECT * FROM Ekipe");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Dodaj tekmo</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h1>Dodaj tekmo</h1>

<form method="POST">

<label>Domača ekipa</label>

<select name="dom">

<?php
while($e=mysqli_fetch_assoc($ekipe)){
echo "<option value='".$e['e_id']."'>".htmlspecialchars($e['Ime_ekipe'])."</option>";
}
?>

</select>

<label>Gostujoča ekipa</label>

<select name="gos">

<?php
$ekipe2=mysqli_query($conn,"SELECT * FROM Ekipe");
while($e=mysqli_fetch_assoc($ekipe2)){
echo "<option value='".$e['e_id']."'>".htmlspecialchars($e['Ime_ekipe'])."</option>";
}
?>

</select>

<input type="date" name="datum" required>

<button name="dodaj">Dodaj tekmo</button>

</form>

<p><?= htmlspecialchars($msg) ?></p>

</div>

</body>
</html>