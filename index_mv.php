<?php 
 require_once('db.php');
 session_start();

    $user = $_SESSION['username'];
    $tiszta_felhasznalonev = htmlspecialchars($user);
    $tomb = mv_adatokat_listaz($tiszta_felhasznalonev);

    $date = strtotime ( $tomb['SZUL_DATUM'] );
    $changeDate = date("Y-m-d", $date);

     $kategoriak = mv_kategoriat_listaz($tiszta_felhasznalonev);
     $szakmai_tapasztalatok = mv_szTapasztalat_listaz($tiszta_felhasznalonev);
     $iskolai_vegzettsegek = mv_iskolazottsag_listaz($tiszta_felhasznalonev);
     $cvData = mv_cv_listaz($tiszta_felhasznalonev);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MUNKAVALLALO_MAIN</title>
    <link rel="stylesheet" href="./style.css?version=51">
    
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

    <div class="jobsContainer">
        
      
        <?php 
             $munkak = mv_munkat_listaz();
            print $munkak;
        ?>
    </div>

    <div class="myJobsContainer">
      
        <?php 
             $munkak = mv_felvettMunkat_listaz($tiszta_felhasznalonev);
            print $munkak;
        ?>
    </div>

    <div id="myModal" class="modal">
        <div class="modal-content">
        <span class="close">&times;</span>
            <div class="formContainer">
                <form action="mv_dataChange.php" method="POST" class="dataForm">

                    <label for="nem">Nem</label>
                    <br>
                    <input required type="text" id="nem" name="nem" maxlength="10" value="<?php echo $tomb['NEM'] ?>">

                    <br>
                    <label for="nev">Név</label>
                    <br>
                    <input required type="text" name="nev" id="nev" maxlength="18" value="<?php echo $tomb['NEV'] ?>">

                    <br>
                    <label for="lakcim">Lakcim</label>
                    <br>
                    <input required type="text" name="lakcim" id="lakcim" maxlength="50" value="<?php echo $tomb['LAKCIM'] ?>">
                    <br>

                    <label for="MVcategory">Job type:</label>

                    <select name="MVcategory" id="MVcategory">
                        <?php print $kategoriak; ?>
                    </select>
                    <br>
                    <label for="MViskolazottsag">Iskolázottság:</label>

                    <select name="MViskolazottsag" id="MViskolazottsag">
                        <?php print $iskolai_vegzettsegek; ?>
                    </select>

                    <br>
                    <label for="MVexperience">Szakmai tapasztalat:</label>

                    <select name="MVexperience" id="MVexperience">
                        <?php print $szakmai_tapasztalatok; ?>
                    </select>

                    <br>     
                    <label for="szuldate">Szül. Date</label>
                    <br>
                    <input required type="date" name="szuldate" id="szuldate" value="<?php echo $changeDate ?>">

                    <br>
                    <input type="submit" id="changeSubmit" value="Szerkesztés" name="logout">
                </form>
                <form action="onCVChange.php" method="POST" class="dataForm">
                    <label for="cv">Önéletrajz</label>
                    <textarea name="cv" id="cv" cols="30" rows="7.5" maxlength="250"><?php echo trim($cvData['REFERENCIA']) ?></textarea>
                    <input type="submit" id="changeSubmit" value="Szerkesztés" name="logout">
                </form>
            </div>
        </div>
    </div>
    <script src="./script.js"></script>
</body>
</html>