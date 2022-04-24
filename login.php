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
    <title>Document</title>
</head>
<body>
    <form action="bejelentkezes.php" method="POST">
        <label>Felhasználónév: </label>
        <input required type="text" name="felhasznalo" ><br>
        <input type="submit" value="Elküld"><br>
        <a href="register.php">Regisztrálás</a>
        <a href="index.php">Log in as guest</a>
    </form>
</body>
</html>
