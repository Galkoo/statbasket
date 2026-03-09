<?php
require_once "auth_sodnik.php";
require_once "povezava.php";

if(isset($_POST["dodaj"])){

$ime=$_POST["ime"];

$query="INSERT INTO Ekipe(Ime_ekipe) VALUES('$ime')";
mysqli_query($conn,$query);

echo "Ekipa dodana";

}
?>

<form method="POST">

Ime ekipe<br>
<input type="text" name="ime"><br>

<button name="dodaj">Dodaj</button>

</form>
