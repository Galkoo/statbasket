<?php
session_start();
require_once __DIR__ . '/povezava.php';

if(!isset($_SESSION["prijavljen"])) {
header("Location: prijava.php");
exit();
}

$msg="";

if(isset($_POST["shrani"])){

$i_id=$_POST["igralec"];
$t_id=$_POST["tekma"];
$tocke=$_POST["tocke"];
$skoki=$_POST["skoki"];
$podaje=$_POST["podaje"];

$query="INSERT INTO Statistika
(i_id,t_id,Tocke,Skoki,Podaje)
VALUES(?,?,?,?,?)";

$stmt=mysqli_prepare($conn,$query);

mysqli_stmt_bind_param($stmt,"iiiii",
$i_id,$t_id,$tocke,$skoki,$podaje);

if(mysqli_stmt_execute($stmt)){
$msg="Statistika dodana.";
}

}

$igralci=mysqli_query($conn,"SELECT * FROM Igralci");
$tekme=mysqli_query($conn,"SELECT * FROM Tekme");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Vnos statistike</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h1>Vnos statistike</h1>

<form method="POST">

<label>Igralec</label>

<select name="igralec">

<?php
while($i=mysqli_fetch_assoc($igralci)){
echo "<option value='".$i['i_id']."'>".
htmlspecialchars($i['Ime']." ".$i['Priimek']).
"</option>";
}
?>

</select>

<label>Tekma</label>

<select name="tekma">

<?php
while($t=mysqli_fetch_assoc($tekme)){
echo "<option value='".$t['t_id']."'>".
htmlspecialchars($t['Datum']).
"</option>";
}
?>

</select>

<input type="number" name="tocke" placeholder="Točke">
<input type="number" name="skoki" placeholder="Skoki">
<input type="number" name="podaje" placeholder="Podaje">

<button name="shrani">Shrani</button>

</form>

<p><?= htmlspecialchars($msg) ?></p>

</div>

</body>
</html>