<?php 
 require_once('db.php');
 session_start();

    $user = $_SESSION['username'];
    $tiszta_felhasznalonev = htmlspecialchars($user);
    $kv_adatok = kv_dataList($tiszta_felhasznalonev);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style.css">
    
</head>
<body>
    <nav class="nav">
        <ul class="list">
            <li id="li1">User: <?php print $user; ?> <button id="dataChange">Adatok szerkesztése</button></li>
            <li id="li2">
            <form action="logout.php">
            <input type="submit" id="logout" value="Kijelentkezés" name="logout">
            </form>
            </li>
        </ul>
    </nav>

    <div id="myModal" class="modal">
        <div class="modal-content">
        <span class="close">&times;</span>
            <div class="formContainer">
                <form action="kv_dataChange.php" method="POST" class="dataForm">

                    <label for="helyszin">Helyszin</label>
                    <br>
                    <input required type="text" id="helyszin" name="helyszin" value="<?php echo $kv_adatok['HELYSZIN'] ?>">

                    <br>
                    <label for="nev">Név</label>
                    <br>
                    <input required type="text" name="nev" id="nev" value="<?php echo $kv_adatok['NEV'] ?>">

                    <br>
                    <label for="adoszam">Adószám</label>
                    <br>
                    <input required type="text" name="adoszam" id="adoszam" value="<?php echo $kv_adatok['KV_ADOSZAM'] ?>">
                    <br>
                    <input type="submit" id="changeSubmit" value="Szerkesztés" name="logout">
                </form>
            </div>
        </div>
    </div>
    <script src="./script.js"></script>
</body>
</html>