<?php
session_start();
require_once __DIR__.'/povezava.php';

if(!isset($_SESSION["prijavljen"])){

header("Location:prijava.php");
exit();

}

$msg="";

if(isset($_POST["dodaj"])){

$ime=$_POST["ime"];

$query="INSERT INTO Ekipe(Ime_ekipe) VALUES(?)";

$stmt=mysqli_prepare($conn,$query);

mysqli_stmt_bind_param($stmt,"s",$ime);

if(mysqli_stmt_execute($stmt)){

$msg="Ekipa dodana.";

}

}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Dodaj ekipo</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h1>Dodaj ekipo</h1>

<form method="POST">

<input type="text" name="ime" placeholder="Ime ekipe" required>

<button type="submit" name="dodaj">Dodaj</button>

</form>

<p><?= htmlspecialchars($msg) ?></p>

</div>

</body>
</html>