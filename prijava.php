<?php
session_start();
require_once "povezava.php";

$error = "";

if (isset($_POST["prijava"])) {
    $mail = trim($_POST["mail"] ?? "");
    $geslo = $_POST["geslo"] ?? "";

    $query = "SELECT * FROM Uporabnik WHERE Mail = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $mail);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($geslo, $user["Geslo"])) {
                $_SESSION["prijavljen"] = true;
                $_SESSION["uporabnik"] = $user;

                header("Location: index.php");
                exit();
            } else {
                $error = "Napačno geslo.";
            }
        } else {
            $error = "Uporabnik ne obstaja.";
        }
    } else {
        $error = "Napaka pri prijavi.";
    }
}
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>Prijava</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Prijava</h1>
    <p class="subtitle">Prijavi se v StatBasket račun</p>

    <?php if ($error): ?>
        <p class="notice"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="mail">Email</label>
        <input type="email" id="mail" name="mail" required>

        <label for="geslo">Geslo</label>
        <input type="password" id="geslo" name="geslo" required>

        <button type="submit" name="prijava">Prijava</button>
    </form>

    <div class="menu">
        <a href="registracija.php">Registracija</a>
        <a href="index.php">Domov</a>
    </div>
</div>
</body>
</html>
