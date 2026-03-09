<?php
session_start();
require_once __DIR__ . '/povezava.php';

if(!isset($_SESSION["prijavljen"])) {
    header("Location: prijava.php");
    exit();
}

$msg="";

if(isset($_POST["dodaj"])){

$ime=$_POST["ime"];
$priimek=$_POST["priimek"];
$stevilka=$_POST["stevilka"];
$ekipa=$_POST["ekipa"];

$query="INSERT INTO Igralci(Ime,Priimek,Stevilka,e_id)
VALUES(?,?,?,?)";

$stmt=mysqli_prepare($conn,$query);
mysqli_stmt_bind_param($stmt,"ssii",$ime,$priimek,$stevilka,$ekipa);

if(mysqli_stmt_execute($stmt)){
$msg="Igralec dodan.";
}

}

$ekipe=mysqli_query($conn,"SELECT * FROM Ekipe");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Dodaj igralca</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h1>Dodaj igralca</h1>

<form method="POST">

<input type="text" name="ime" placeholder="Ime" required>
<input type="text" name="priimek" placeholder="Priimek" required>
<input type="number" name="stevilka" placeholder="Številka" required>

<select name="ekipa">

<?php
while($e=mysqli_fetch_assoc($ekipe)){
echo "<option value='".$e['e_id']."'>".htmlspecialchars($e['Ime_ekipe'])."</option>";
}
?>

</select>

<button name="dodaj">Dodaj igralca</button>

</form>

<p><?= htmlspecialchars($msg) ?></p>

</div>

</body>
</html>