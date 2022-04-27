<?php 
 require_once('db.php');
 session_start();

    $user = $_SESSION['username'];
    $tiszta_felhasznalonev = htmlspecialchars($user);
    $tombMC = mc_adatokat_listaz($tiszta_felhasznalonev);

    //$date = strtotime ( $tomb['SZUL_DATUM'] );
    //$changeDate = date("Y-m-d", $date);

    $kategoriak = mv_kategoriat_listaz($tiszta_felhasznalonev);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MUNKÁLTATÓ CÉG</title>
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
                <form action="mc_dataChange.php" method="POST" class="dataForm">

                    <label for="nev">Cég neve</label>
                    <br>
                    <input required type="text" id="nev" name="nev" maxlength="50" value="<?php echo $tombMC['NEV'] ?>">

                    <br>
                    <label for="adoszam">Adószám</label>
                    <br>
                    <input required type="text" name="adoszam" id="adoszam" maxlength="13" value="<?php echo $tombMC['MC_ADOSZAM'] ?>">

                    <br>
                    <label for="telephely">Telephely</label>
                    <br>
                    <input required type="text" name="telephely" id="telephely" maxlength="50" value="<?php echo $tombMC['TELEPHELY'] ?>">
                    <br>

                    <label for="MCcategory">Cég besorolás</label>

                    <select name="MCcategory" id="MCcategory">
                        <?php print $kategoriak; ?>
                    </select>

                    <br>
                    <br>
                    <input type="submit" id="changeSubmit" value="Szerkesztés" name="logout">
                </form>
            </div>
        </div>
    </div>
    
    <div class="MC_FORM">
        <form action="allas_dataChange.php" method="POST" class="dataForm">

                    <label for="allasMegnevezes">Állás megnevezése</label>
                    <input required type="text" id="allasMegnevezes" name="allasMegnevezes" maxlength="50">

                    <br>
                    <br>
                    <label for="helyszin">Helyszín</label>

                    <input required type="text" name="helyszin" id="helyszin" maxlength="50">

                    <br>
                    <br>
                    <label for="muszak">Műszak</label>
                    <input required type="text" name="muszak" id="muszak" maxlength="50" placeholder="8:00 - 16:00">

                    <br>
                    <br>
                    <label for="tipus">Típus</label>
                    <select name="tipusok" id="tipusok">
                        <option value="fizikai">Fizikai</option>
                        <option value="konnyu_fizikai">Könnyű fizikai</option>
                        <option value="irodai">Irodai</option>
                    </select>

                    <br>
                    <br>
                    <label for="ALLAScategory">Munka besorolás</label>
                    <select name="ALLAScategory" id="ALLAScategory">
                        <?php print $kategoriak; ?>
                    </select>

                    <br>
                    <br>
                    <label for="leiras">Leírás</label>
                    <textarea name="leiras" id="leiras" cols="30" rows="7.5" maxlength="200" required></textarea>

                    <br>
                    <br>
                    <input type="hidden" id="mc_id" name="mc_id" value=<?php echo $tombMC['ADOSZAM'] ?>>
                    <input type="submit" id="changeSubmit" value="Felvétel" name="felvetel">
        </form>
        <div class="jobsContainer2">
            <?php 
                $munkak = mc_munkat_listaz($tiszta_felhasznalonev);
                print $munkak;
            ?>
        </div>
    </div>
    <script src="./script.js"></script>
    <script src="./script2.js"></script>
</body>
</html>