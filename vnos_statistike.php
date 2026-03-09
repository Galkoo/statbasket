<?php
session_start();
require_once "povezava.php";

if (!isset($_SESSION["prijavljen"])) {
    header("Location: prijava.php");
    exit();
}

$msg = "";
$igralci = mysqli_query($conn, "SELECT i.i_id, i.Ime, i.Priimek, e.Ime_ekipe 
                                FROM Igralci i 
                                INNER JOIN Ekipe e ON i.e_id = e.e_id
                                ORDER BY e.Ime_ekipe, i.Priimek");
$tekme = mysqli_query($conn, "SELECT t.t_id, t.Datum, e1.Ime_ekipe AS dom, e2.Ime_ekipe AS gos
                              FROM Tekme t
                              INNER JOIN Ekipe e1 ON t.Ekipa_Dom = e1.e_id
                              INNER JOIN Ekipe e2 ON t.Ekipa_Gos = e2.e_id
                              ORDER BY t.Datum DESC");

if (isset($_POST["shrani"])) {
    $i_id = (int)($_POST["igralec"] ?? 0);
    $t_id = (int)($_POST["tekma"] ?? 0);
    $tocke = (int)($_POST["tocke"] ?? 0);
    $skoki = (int)($_POST["skoki"] ?? 0);
    $podaje = (int)($_POST["podaje"] ?? 0);
    $tri = (int)($_POST["met_za_tri"] ?? 0);
    $prosti = (int)($_POST["prosti_met"] ?? 0);
    $blokade = (int)($_POST["blokade"] ?? 0);
    $osebne = (int)($_POST["osebne"] ?? 0);

    $query = "INSERT INTO Statistika (i_id, t_id, Tocke, Skoki, Podaje, Met_za_tri, Prosti_met, Blokade, Osebne_Napake)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iiiiiiiii", $i_id, $t_id, $tocke, $skoki, $podaje, $tri, $prosti, $blokade, $osebne);

        if (mysqli_stmt_execute($stmt)) {
            $msg = "Statistika uspešno dodana.";
        } else {
            $msg = "Napaka pri dodajanju statistike.";
        }
    } else {
        $msg = "Napaka pri dodajanju statistike.";
    }
}
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>Vnos statistike</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Dodaj statistiko</h1>
    <p class="subtitle">Vnesi statistiko igralca za določeno tekmo</p>

    <?php if ($msg): ?>
        <p class="notice"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="igralec">Igralec</label>
        <select id="igralec" name="igralec" required>
            <option value="">Izberi igralca</option>
            <?php while ($i = mysqli_fetch_assoc($igralci)): ?>
                <option value="<?= (int)$i["i_id"] ?>">
                    <?= htmlspecialchars($i["Ime_ekipe"] . " - " . $i["Priimek"] . " " . $i["Ime"]) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="tekma">Tekma</label>
        <select id="tekma" name="tekma" required>
            <option value="">Izberi tekmo</option>
            <?php while ($t = mysqli_fetch_assoc($tekme)): ?>
                <option value="<?= (int)$t["t_id"] ?>">
                    <?= htmlspecialchars($t["Datum"] . " | " . $t["dom"] . " vs " . $t["gos"]) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="tocke">Točke</label>
        <input type="number" id="tocke" name="tocke" value="0" required>

        <label for="skoki">Skoki</label>
        <input type="number" id="skoki" name="skoki" value="0" required>

        <label for="podaje">Podaje</label>
        <input type="number" id="podaje" name="podaje" value="0" required>

        <label for="met_za_tri">Met za tri</label>
        <input type="number" id="met_za_tri" name="met_za_tri" value="0" required>

        <label for="prosti_met">Prosti met</label>
        <input type="number" id="prosti_met" name="prosti_met" value="0" required>

        <label for="blokade">Blokade</label>
        <input type="number" id="blokade" name="blokade" value="0" required>

        <label for="osebne">Osebne napake</label>
        <input type="number" id="osebne" name="osebne" value="0" required>

        <button type="submit" name="shrani">Shrani statistiko</button>
    </form>

    <div class="menu">
        <a href="admin.php">Admin panel</a>
        <a href="index.php">Domov</a>
    </div>
</div>
</body>
</html>
