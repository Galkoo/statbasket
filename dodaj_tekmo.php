<?php
require_once "auth_sodnik.php";
require_once "povezava.php";

$msg = "";
$ekipe1 = mysqli_query($conn, "SELECT * FROM Ekipe ORDER BY Ime_ekipe ASC");
$ekipe2 = mysqli_query($conn, "SELECT * FROM Ekipe ORDER BY Ime_ekipe ASC");

if (isset($_POST["dodaj"])) {
    $dom = (int)($_POST["dom"] ?? 0);
    $gos = (int)($_POST["gos"] ?? 0);
    $datum = $_POST["datum"] ?? "";
    $rezDom = (int)($_POST["rez_dom"] ?? 0);
    $rezGos = (int)($_POST["rez_gos"] ?? 0);

    if ($dom > 0 && $gos > 0 && $dom !== $gos && $datum !== "") {
        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO Tekme (Ekipa_Dom, Ekipa_Gos, Datum, Rezultat_Dom, Rezultat_Gos) VALUES (?, ?, ?, ?, ?)"
        );

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "iisii", $dom, $gos, $datum, $rezDom, $rezGos);

            if (mysqli_stmt_execute($stmt)) {
                $msg = "Tekma uspešno dodana.";
            } else {
                $msg = "Napaka pri dodajanju tekme.";
            }
        }
    } else {
        $msg = "Preveri ekipe in datum.";
    }
}
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj tekmo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Dodaj tekmo</h1>
    <p class="subtitle">Vnesi novo tekmo</p>

    <?php if ($msg): ?>
        <p class="notice"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="dom">Domača ekipa</label>
        <select id="dom" name="dom" required>
            <option value="">Izberi domačo ekipo</option>
            <?php while ($e = mysqli_fetch_assoc($ekipe1)): ?>
                <option value="<?= (int)$e["e_id"] ?>"><?= htmlspecialchars($e["Ime_ekipe"]) ?></option>
            <?php endwhile; ?>
        </select>

        <label for="gos">Gostujoča ekipa</label>
        <select id="gos" name="gos" required>
            <option value="">Izberi gostujočo ekipo</option>
            <?php while ($e = mysqli_fetch_assoc($ekipe2)): ?>
                <option value="<?= (int)$e["e_id"] ?>"><?= htmlspecialchars($e["Ime_ekipe"]) ?></option>
            <?php endwhile; ?>
        </select>

        <label for="datum">Datum</label>
        <input type="date" id="datum" name="datum" required>

        <label for="rez_dom">Rezultat domači</label>
        <input type="number" id="rez_dom" name="rez_dom" value="0" required>

        <label for="rez_gos">Rezultat gostje</label>
        <input type="number" id="rez_gos" name="rez_gos" value="0" required>

        <button type="submit" name="dodaj">Dodaj tekmo</button>
    </form>

    <div class="menu">
        <a href="admin.php">Nazaj</a>
        <a href="index.php">Domov</a>
    </div>
</div>

</body>
</html>

