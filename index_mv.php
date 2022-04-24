<?php 
 require_once('db.php');
 session_start();

    $user = $_SESSION['username'];
    $tiszta_felhasznalonev = htmlspecialchars($user);
    $tomb = mv_adatokat_listaz($tiszta_felhasznalonev);

    $date = strtotime ( $tomb['SZUL_DATUM'] );
    $changeDate = date("Y-m-d", $date);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MUNKAVALLALO_MAIN</title>
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
                <form action="mv_dataChange.php" method="POST" class="dataForm">

                    <label for="nem">Nem</label>
                    <br>
                    <input required type="text" id="nem" name="nem" value="<?php echo $tomb['NEM'] ?>">

                    <br>
                    <label for="nev">Név</label>
                    <br>
                    <input required type="text" name="nev" id="nev" value="<?php echo $tomb['NEV'] ?>">

                    <br>
                    <label for="lakcim">Lakcim</label>
                    <br>
                    <input required type="text" name="lakcim" id="lakcim" value="<?php echo $tomb['LAKCIM'] ?>">

                    <br>
                    <label for="szuldate">Szül. Date</label>
                    <br>
                    <input required type="date" name="szuldate" id="szuldate" value="<?php echo $changeDate ?>">

                    <br>
                    <input type="submit" id="changeSubmit" value="Szerkesztés" name="logout">
                </form>
            </div>
        </div>
    </div>
    <script src="./script.js"></script>
</body>
</html>