<?php
require_once "auth_sodnik.php";
require_once "povezava.php";

$msg = "";

if (isset($_POST["izbrisi"])) {
    $s_id = (int)($_POST["s_id"] ?? 0);

    $stmt = mysqli_prepare($conn, "DELETE FROM Statistika WHERE s_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $s_id);

    if (mysqli_stmt_execute($stmt)) {
        $msg = "Statistika izbrisana.";
    } else {
        $msg = "Napaka pri brisanju.";
    }
}

$rez = mysqli_query($conn, "
    SELECT
        s.s_id,
        s.Tocke,
        s.Skoki,
        s.Podaje,
        s.Met_za_tri,
        s.Prosti_met,
        s.Blokade,
        s.Osebne_Napake,
        i.Ime,
        i.Priimek,
        t.Datum
    FROM Statistika s
    INNER JOIN Igralci i ON s.i_id = i.i_id
    INNER JOIN Tekme t ON s.t_id = t.t_id
    ORDER BY t.Datum DESC, i.Priimek ASC
");
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>Urejanje statistik</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Urejanje statistik</h1>
    <p class="subtitle">Pregled in brisanje vnešenih statistik</p>

    <?php if ($msg): ?>
        <p class="notice"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <table>
        <tr>
            <th>Datum</th>
            <th>Igralec</th>
            <th>Točke</th>
            <th>Skoki</th>
            <th>Podaje</th>
            <th>3PT</th>
            <th>FT</th>
            <th>Blokade</th>
            <th>Napake</th>
            <th>Akcija</th>
        </tr>

        <?php while ($r = mysqli_fetch_assoc($rez)): ?>
            <tr>
                <td><?= htmlspecialchars($r["Datum"]) ?></td>
                <td><?= htmlspecialchars($r["Priimek"] . " " . $r["Ime"]) ?></td>
                <td><?= (int)$r["Tocke"] ?></td>
                <td><?= (int)$r["Skoki"] ?></td>
                <td><?= (int)$r["Podaje"] ?></td>
                <td><?= (int)$r["Met_za_tri"] ?></td>
                <td><?= (int)$r["Prosti_met"] ?></td>
                <td><?= (int)$r["Blokade"] ?></td>
                <td><?= (int)$r["Osebne_Napake"] ?></td>
                <td>
                    <form method="POST" onsubmit="return confirm('Res želiš izbrisati to statistiko?');">
                        <input type="hidden" name="s_id" value="<?= (int)$r["s_id"] ?>">
                        <button type="submit" name="izbrisi">Izbriši</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <div class="menu">
        <a href="admin.php">Nazaj</a>
        <a href="index.php">Domov</a>
    </div>
</div>

</body>
</html>
