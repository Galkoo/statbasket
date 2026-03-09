<?php
session_start();
require_once "povezava.php";

if (!isset($_SESSION["prijavljen"]) || ($_SESSION["uporabnik"]["Vloga"] ?? "") !== "admin") {
    header("Location: index.php");
    exit();
}

$msg = "";

/* Dodeli sodnika */
if (isset($_POST["dodeli_sodnika"])) {
    $u_id = (int)($_POST["u_id"] ?? 0);

    $stmt = mysqli_prepare($conn, "UPDATE Uporabnik SET Vloga = 'sodnik' WHERE u_id = ? AND Vloga != 'admin'");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $u_id);
        if (mysqli_stmt_execute($stmt)) {
            $msg = "Vloga sodnika je bila dodeljena.";
        } else {
            $msg = "Napaka pri dodeljevanju vloge.";
        }
    }
}

/* Odvzemi sodnika */
if (isset($_POST["odvzemi_sodnika"])) {
    $u_id = (int)($_POST["u_id"] ?? 0);

    $stmt = mysqli_prepare($conn, "UPDATE Uporabnik SET Vloga = 'uporabnik' WHERE u_id = ? AND Vloga = 'sodnik'");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $u_id);
        if (mysqli_stmt_execute($stmt)) {
            $msg = "Vloga sodnika je bila odvzeta.";
        } else {
            $msg = "Napaka pri odvzemu vloge.";
        }
    }
}

/* Statistika */
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

/* Vsi uporabniki razen adminov */
$users = mysqli_query($conn, "
    SELECT u_id, Ime, Priimek, Mail, Vloga
    FROM Uporabnik
    ORDER BY Priimek ASC, Ime ASC
");
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>Admin panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Admin panel</h1>
    <p class="subtitle">Upravljanje uporabnikov in sistema</p>

    <?php if ($msg): ?>
        <p class="notice"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <h2>Pregled sistema</h2>
    <ul>
        <li>Uporabniki: <strong><?= $stats["uporabniki"] ?></strong></li>
        <li>Ekipe: <strong><?= $stats["ekipe"] ?></strong></li>
        <li>Igralci: <strong><?= $stats["igralci"] ?></strong></li>
        <li>Tekme: <strong><?= $stats["tekme"] ?></strong></li>
        <li>Statistike: <strong><?= $stats["statistike"] ?></strong></li>
    </ul>

    <h2>Upravljanje uporabnikov</h2>

    <table>
        <tr>
            <th>Ime</th>
            <th>Priimek</th>
            <th>Email</th>
            <th>Vloga</th>
            <th>Akcija</th>
        </tr>

        <?php if ($users): ?>
            <?php while ($u = mysqli_fetch_assoc($users)): ?>
                <tr>
                    <td><?= htmlspecialchars($u["Ime"]) ?></td>
                    <td><?= htmlspecialchars($u["Priimek"]) ?></td>
                    <td><?= htmlspecialchars($u["Mail"]) ?></td>
                    <td><?= htmlspecialchars($u["Vloga"]) ?></td>
                    <td>
                        <?php if ($u["Vloga"] === "uporabnik"): ?>
                            <form method="POST">
                                <input type="hidden" name="u_id" value="<?= (int)$u["u_id"] ?>">
                                <button type="submit" name="dodeli_sodnika">Dodeli sodnika</button>
                            </form>
                        <?php elseif ($u["Vloga"] === "sodnik"): ?>
                            <form method="POST">
                                <input type="hidden" name="u_id" value="<?= (int)$u["u_id"] ?>">
                                <button type="submit" name="odvzemi_sodnika">Odvzemi sodnika</button>
                            </form>
                        <?php else: ?>
                            <em>Brez spremembe</em>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php endif; ?>
    </table>

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
