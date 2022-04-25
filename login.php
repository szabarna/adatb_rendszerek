<?php
require_once('db.php');
session_start();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="login-wrapper">
    <form action="bejelentkezes.php" id="login-form" method="POST">
        <label>Felhasználónév: </label>
        <input required type="text" maxlength="60" name="felhasznalo" ><br>
        <input type="submit" value="Elküld"><br>
        <a href="register.php" id="loginA1">Regisztrálás</a>
        <a href="index.php" id="loginA2">Log in as guest</a>
    </form>
    </div>
</body>
</html>
