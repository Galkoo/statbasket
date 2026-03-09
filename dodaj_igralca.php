<?php
require_once "auth_sodnik.php";
require_once "povezava.php";

$msg = "";
$ekipe = mysqli_query($conn, "SELECT * FROM Ekipe ORDER BY Ime_ekipe ASC");

if (isset($_POST["dodaj"])) {
    $ime = trim($_POST["ime"] ?? "");
    $priimek = trim($_POST["priimek"] ?? "");
    $stevilka = (int)($_POST["stevilka"] ?? 0);
    $ekipa = (int)($_POST["ekipa"] ?? 0);

    if ($ime !== "" && $priimek !== "" && $stevilka > 0 && $ekipa > 0) {
        $stmt = mysqli_prepare($conn, "INSERT INTO Igralci (Ime, Priimek, Stevilka, e_id) VALUES (?, ?, ?, ?)");

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssii", $ime, $priimek, $stevilka, $ekipa);

            if (mysqli_stmt_execute($stmt)) {
                $msg = "Igralec uspešno dodan.";
            } else {
                $msg = "Napaka pri dodajanju igralca.";
            }
        }
    } else {
        $msg = "Izpolni vsa polja pravilno.";
    }
}
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj igralca</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <h1>Dodaj igralca</h1>
    <p class="subtitle">Vnesi novega igralca</p>

    <?php if ($msg): ?>
        <p class="notice"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="ime">Ime</label>
        <input type="text" id="ime" name="ime" required>

        <label for="priimek">Priimek</label>
        <input type="text" id="priimek" name="priimek" required>

        <label for="stevilka">Številka</label>
        <input type="number" id="stevilka" name="stevilka" required>

        <label for="ekipa">Ekipa</label>
        <select id="ekipa" name="ekipa" required>
            <option value="">Izberi ekipo</option>
            <?php if ($ekipe): ?>
                <?php while ($e = mysqli_fetch_assoc($ekipe)): ?>
                    <option value="<?= (int)$e["e_id"] ?>">
                        <?= htmlspecialchars($e["Ime_ekipe"]) ?>
                    </option>
                <?php endwhile; ?>
            <?php endif; ?>
        </select>

        <button type="submit" name="dodaj">Dodaj igralca</button>
    </form>

    <div class="menu">
        <a href="admin.php">Nazaj</a>
        <a href="index.php">Domov</a>
    </div>
</div>

</body>
</html>
