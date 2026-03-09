<?php
session_start();
require_once "povezava.php";

$msg = "";

if (isset($_POST["registracija"])) {
    $ime = trim($_POST["ime"] ?? "");
    $priimek = trim($_POST["priimek"] ?? "");
    $mail = trim($_POST["mail"] ?? "");
    $gesloRaw = $_POST["geslo"] ?? "";

    if ($ime !== "" && $priimek !== "" && $mail !== "" && $gesloRaw !== "") {
        $check = mysqli_prepare($conn, "SELECT u_id FROM Uporabnik WHERE Mail = ?");
        mysqli_stmt_bind_param($check, "s", $mail);
        mysqli_stmt_execute($check);
        $existing = mysqli_stmt_get_result($check);

        if ($existing && mysqli_num_rows($existing) > 0) {
            $msg = "Uporabnik s tem emailom že obstaja.";
        } else {
            $geslo = password_hash($gesloRaw, PASSWORD_DEFAULT);

            $query = "INSERT INTO Uporabnik (Ime, Priimek, Mail, Geslo, Vloga) VALUES (?, ?, ?, ?, 'uporabnik')";
            $stmt = mysqli_prepare($conn, $query);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssss", $ime, $priimek, $mail, $geslo);

                if (mysqli_stmt_execute($stmt)) {
                    $msg = "Registracija uspešna. Zdaj se lahko prijaviš.";
                } else {
                    $msg = "Napaka pri registraciji.";
                }
            } else {
                $msg = "Napaka pri registraciji.";
            }
        }
    } else {
        $msg = "Izpolni vsa polja.";
    }
}
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>Registracija</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Registracija</h1>
    <p class="subtitle">Ustvari nov račun za uporabo aplikacije</p>

    <?php if ($msg): ?>
        <p class="notice"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="ime">Ime</label>
        <input type="text" id="ime" name="ime" required>

        <label for="priimek">Priimek</label>
        <input type="text" id="priimek" name="priimek" required>

        <label for="mail">Email</label>
        <input type="email" id="mail" name="mail" required>

        <label for="geslo">Geslo</label>
        <input type="password" id="geslo" name="geslo" required>

        <button type="submit" name="registracija">Registriraj se</button>
    </form>

    <div class="menu">
        <a href="prijava.php">Prijava</a>
        <a href="index.php">Domov</a>
    </div>
</div>
</body>
</html>
