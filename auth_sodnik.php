
<?php
session_start();

if(!isset($_SESSION["prijavljen"])){
    header("Location: prijava.php");
    exit();
}

$vloga=$_SESSION["uporabnik"]["Vloga"];

if($vloga!="sodnik" && $vloga!="admin"){
    header("Location: index.php");
    exit();
}
?>
