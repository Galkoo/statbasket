<?php
session_start();
require_once "povezava.php";

if (!isset($_SESSION["prijavljen"]) || ($_SESSION["uporabnik"]["Vloga"] ?? "") !== "admin") {
    header("Location: index.php");
    exit();
}

$stats = [
    "uporabniki" => 0,
    "ekipe" => 0,
    "igralci" => 0,
    "tekme" => 0,
    "statistike" => 0
];

$queries = [
    "uporabniki" => "SELECT COUNT(*) AS skupaj FROM Uporabnik",
    "ekipe" => "SELECT COUNT(*) AS skupaj FROM Ekipe",
    "igralci" => "SELECT COUNT(*) AS skupaj FROM Igralci",
    "tekme" => "SELECT COUNT(*) AS skupaj FROM Tekme",
    "statistike" => "SELECT COUNT(*) AS skupaj FROM Statistika"
];

foreach ($queries as $key => $sql) {
    $res = mysqli_query($conn, $sql);
    if ($res) {
        $row = mysqli_fetch_assoc($res);
        $stats[$key] = (int)$row["skupaj"];
    }
}
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>Admin panel</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <h1>Admin panel</h1>
    <p class="subtitle">Pregled sistema in administracija</p>

    <ul>
        <li>Uporabniki: <strong><?= $stats["uporabniki"] ?></strong></li>
        <li>Ekipe: <strong><?= $stats["ekipe"] ?></strong></li>
        <li>Igralci: <strong><?= $stats["igralci"] ?></strong></li>
        <li>Tekme: <strong><?= $stats["tekme"] ?></strong></li>
        <li>Statistike: <strong><?= $stats["statistike"] ?></strong></li>
    </ul>

    <div class="menu">
        <a href="dodaj_ekipo.php">Dodaj ekipo</a>
        <a href="dodaj_igralca.php">Dodaj igralca</a>
        <a href="dodaj_tekmo.php">Dodaj tekmo</a>
        <a href="vnos_statistike.php">Dodaj statistiko</a>
        <a href="urejanje_statistik.php">Urejanje statistik</a>
        <a href="index.php">Domov</a>
    </div>
</div>

</body>
</html>
