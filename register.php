<?php
require_once('db.php');


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="login-wrapper">
    <form action="regisztralas.php" id="login-form" method="POST">

        <label>Felhasználónév: </label>
        <input required type="text" maxlength="60" name="felhasznalo">
        <br>

        <input type="radio" id="MV" name="radio" value="MV" checked>
        <label for="MV">Munkavállaló</label>
        <br>

        <input type="radio" id="MC" name="radio" value="MC">
        <label for="MC">Munkáltató</label>
        <br>

        <input type="radio" id="KC" name="radio" value="KV">
        <label for="KC">Közvetitő</label>

        <input type="submit" value="Elküld">
        <br>
        <a href="login.php" id="loginA2">Bejelentkezés</a>
    </form>
    </div>
</body>
</html>
