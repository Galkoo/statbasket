<?php
require_once __DIR__ . '/povezava.php';

$msg="";

if(isset($_POST["registracija"])){

$ime=$_POST["ime"];
$priimek=$_POST["priimek"];
$mail=$_POST["mail"];
$geslo=password_hash($_POST["geslo"],PASSWORD_DEFAULT);

$query="INSERT INTO Uporabnik(Ime,Priimek,Mail,Geslo)
VALUES(?,?,?,?)";

$stmt=mysqli_prepare($conn,$query);

mysqli_stmt_bind_param($stmt,"ssss",$ime,$priimek,$mail,$geslo);

if(mysqli_stmt_execute($stmt)){

$msg="Registracija uspešna.";

}else{

$msg="Napaka pri registraciji.";

}

}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Registracija</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h1>Registracija</h1>

<form method="POST">

<input type="text" name="ime" placeholder="Ime" required>
<input type="text" name="priimek" placeholder="Priimek" required>
<input type="email" name="mail" placeholder="Email" required>
<input type="password" name="geslo" placeholder="Geslo" required>

<button type="submit" name="registracija">Registracija</button>

</form>

<p><?= htmlspecialchars($msg) ?></p>

</div>

</body>
</html>