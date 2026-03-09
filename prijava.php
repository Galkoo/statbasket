<?php
session_start();
require_once __DIR__ . '/povezava.php';

$error = "";

if(isset($_POST["prijava"])){

$mail = $_POST["mail"];
$geslo = $_POST["geslo"];

$query = "SELECT * FROM Uporabnik WHERE Mail=?";
$stmt = mysqli_prepare($conn,$query);

mysqli_stmt_bind_param($stmt,"s",$mail);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($result)==1){

$user = mysqli_fetch_assoc($result);

if(password_verify($geslo,$user["Geslo"])){

$_SESSION["prijavljen"] = true;
$_SESSION["uporabnik"] = $user;

header("Location: index.php");
exit();

}else{

$error = "Napačno geslo.";

}

}else{

$error = "Uporabnik ne obstaja.";

}

}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Prijava</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h1>Prijava</h1>

<form method="POST">

<label>Email</label>
<input type="email" name="mail" required>

<label>Geslo</label>
<input type="password" name="geslo" required>

<button type="submit" name="prijava">Prijava</button>

</form>

<p><?= htmlspecialchars($error) ?></p>

</div>

</body>
</html>