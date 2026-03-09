<?php
session_start();
require_once "povezava.php";
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>StatBasket</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>🏀 StatBasket</h1>
    <p class="subtitle">Statistika košarkarskih tekem in igralcev</p>

    <?php if (isset($_SESSION["prijavljen"])): ?>
        <p class="notice">
            Prijavljen kot:
            <strong><?= htmlspecialchars($_SESSION["uporabnik"]["Ime"]) ?></strong>
            (<?= htmlspecialchars($_SESSION["uporabnik"]["Vloga"]) ?>)
        </p>
    <?php endif; ?>

    <div class="menu">
        <?php if (!isset($_SESSION["prijavljen"])): ?>
            <a href="prijava.php">Prijava</a>
            <a href="registracija.php">Registracija</a>
        <?php else: ?>

            <?php if ($_SESSION["uporabnik"]["Vloga"] === "admin" || $_SESSION["uporabnik"]["Vloga"] === "sodnik"): ?>
                <a href="dodaj_ekipo.php">Dodaj ekipo</a>
                <a href="dodaj_igralca.php">Dodaj igralca</a>
                <a href="dodaj_tekmo.php">Dodaj tekmo</a>
                <a href="vnos_statistike.php">Dodaj statistiko</a>
                <a href="urejanje_statistik.php">Urejanje statistik</a>
            <?php endif; ?>

            <?php if ($_SESSION["uporabnik"]["Vloga"] === "admin"): ?>
                <a href="admin.php">Admin panel</a>
            <?php endif; ?>

            <a href="logout.php">Odjava</a>
        <?php endif; ?>
    </div>

    <hr>

    <h2>Zadnje tekme</h2>

    <?php
    $query = "
        SELECT
            t.Datum,
            ed.Ime_ekipe AS Domaca,
            eg.Ime_ekipe AS Gostujoca,
            t.Rezultat_Dom,
            t.Rezultat_Gos
        FROM Tekme t
        INNER JOIN Ekipe ed ON t.Ekipa_Dom = ed.e_id
        INNER JOIN Ekipe eg ON t.Ekipa_Gos = eg.e_id
        ORDER BY t.Datum DESC
    ";

    $rez = mysqli_query($conn, $query);

    if ($rez && mysqli_num_rows($rez) > 0) {
        echo "<ul>";
        while ($row = mysqli_fetch_assoc($rez)) {
            echo "<li>" .
                htmlspecialchars($row["Datum"]) . " | " .
                htmlspecialchars($row["Domaca"]) . " " .
                (int)$row["Rezultat_Dom"] . " : " .
                (int)$row["Rezultat_Gos"] . " " .
                htmlspecialchars($row["Gostujoca"]) .
                "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Ni vnešenih tekem.</p>";
    }
    ?>

    <hr>

    <h2>Skupna statistika</h2>

    <?php
    $up = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS skupaj FROM Uporabnik"));
    $ek = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS skupaj FROM Ekipe"));
    $ig = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS skupaj FROM Igralci"));
    $te = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS skupaj FROM Tekme"));
    $st = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS skupaj FROM Statistika"));
    ?>

    <ul>
        <li>Uporabniki: <strong><?= (int)$up["skupaj"] ?></strong></li>
        <li>Ekipe: <strong><?= (int)$ek["skupaj"] ?></strong></li>
        <li>Igralci: <strong><?= (int)$ig["skupaj"] ?></strong></li>
        <li>Tekme: <strong><?= (int)$te["skupaj"] ?></strong></li>
        <li>Statistike: <strong><?= (int)$st["skupaj"] ?></strong></li>
    </ul>
</div>

</body>
</html>

