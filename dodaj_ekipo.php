<?php
session_start();
require_once "povezava.php";

if (!isset($_SESSION["prijavljen"])) {
    header("Location: prijava.php");
    exit();
}

$msg = "";

if (isset($_POST["dodaj"])) {
    $ime = trim($_POST["ime"] ?? "");

    if ($ime !== "") {
        $query = "INSERT INTO Ekipe (Ime_ekipe) VALUES (?)";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $ime);

            if (mysqli_stmt_execute($stmt)) {
                $msg = "Ekipa uspešno dodana.";
            } else {
                $msg = "Ekipa že obstaja ali je prišlo do napake.";
            }
        } else {
            $msg = "Napaka pri dodajanju ekipe.";
        }
    } else {
        $msg = "Vnesi ime ekipe.";
    }
}
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj ekipo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Dodaj ekipo</h1>
    <p class="subtitle">Ustvari novo ekipo v sistemu</p>

    <?php if ($msg): ?>
        <p class="notice"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="ime">Ime ekipe</label>
        <input type="text" id="ime" name="ime" required>

        <button type="submit" name="dodaj">Dodaj ekipo</button>
    </form>

    <div class="menu">
        <a href="admin.php">Admin panel</a>
        <a href="index.php">Domov</a>
    </div>
</div>
</body>
</html>
