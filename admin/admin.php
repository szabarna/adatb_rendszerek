<?php 
 require_once('./db.php');
 session_start();

    $user = $_SESSION['username'];
  
    
    $allasJelentkezesList = admin_allasJelentkezes_listaz();
    $allasLehetosegList = admin_allasLehetoseg_listaz();

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control Panel</title>
    <link rel="stylesheet" href="./style.css?version=51">
    
</head>
<body>
    <nav class="nav">
        <ul class="list">
            <li id="li1">User: <?php print $user; ?></li>
            <li id="li2">
            <form action="../logout.php">
            <input type="submit" id="logout" value="Kijelentkezés" name="logout">
            </form>
            </li>
        </ul>
    </nav>

    <div class="adminContainer">
        <div class="table">ALLAS_JELENTKEZES</div>
        <div class="table">ALLAS_LEHETOSEG</div>
        <div class="table">ISKOLAI_VEGZETTSEGEK</div>  
        <div class="table">KOZVETITESEK</div>
        <div class="table">KOZVETITO</div>
        <div class="table">MUNKALTATO_CEG</div>  
        <div class="table">MUNKALTATO_CEG_KATEGORIAK</div>
        <div class="table">MUNKAVALLALO</div>
        <div class="table">MUNKAVALLALO_KATEGORIAK</div>
        <div class="table">ONELETRAJZ</div>
        <div class="table">REGISTER</div>
        <div class="table">SZAKMAI_TAPASZTALAT</div>
    

    <div id="modal1" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="dataContainer" id="d1">
               <div class="dList">
                    <!-- <div class="listElement" id="l1"></div>
                    <div class="listElement" id="l2"></div>
                    <div class="listElement" id="l3"></div> -->
                    <?php print $allasJelentkezesList; ?>
               </div>
               <div class="dForm">

               <form action="AJ_dataChange.php" method="POST" class="dataForm" id="mv_dataForm">

                    <label for="AL_MC_ADOSZAM">MC_ADOSZAM:</label>
                    <br>
                    <input required type="text" id="AL_MC_ADOSZAM" name="AL_MC_ADOSZAM" maxlength="10">

                    <br>
                    <label for="AL_MV_ADOSZAM">MV_ADOSZAM:</label>
                    <br>
                    <input required type="text" name="AL_MV_ADOSZAM" id="AL_MV_ADOSZAM">

                    <br>
                    <input type="submit" style="text-decoration: line-through;" id="changeSubmit" value="Insert" name="insert">
                </form>

               </div>
            </div>
        </div>
    </div>
    
    <div id="modal2" class="modal">
        <div class="modal-content">
        <span class="close">&times;</span>
        <div class="dataContainer" id="d2">
               <div class="dList">
                    <!-- <div class="listElement" id="l1"></div>
                    <div class="listElement" id="l2"></div>
                    <div class="listElement" id="l3"></div> -->
                    <?php print $allasLehetosegList; ?>
               </div>
               <div class="dForm">

               <form action="AL_dataChange.php" method="POST" class="dataForm AL_DATAFORM" id="mv_dataForm">

                    <label for="AL_MC_ID">MC_ID:</label>
                    <br>
                    <select required id="AL_MC_ID" name="AL_MC_ID">
                        <?php print AL_MC_ID_listaz() ?>
                    </select>
                
                    <label for="AL_ALLAS_NEV">ALLAS_NEV</label>
                    <br>
                    <input required type="text" name="AL_ALLAS_NEV">

                    <br>
                    <label for="AL_HELYSZIN">HELYSZIN</label>
                    <br>
                    <input required type="text" name="AL_HELYSZIN">

                    <br>
                    <label for="AL_KAT_ID">KATEGORIA:</label>
                    <br>
                    <select required id="AL_KAT_ID" name="AL_KAT_ID">
                        <?php print AL_kategoriat_listaz($row['KAT_ID']) ?>
                    </select>

                    <br>
                    <label for="AL_MUSZAK">MUSZAK</label>
                    <br>
                    <input required type="text" name="AL_MUSZAK">

                    <br>
                    <label for="AL_LEIRAS">LEIRAS</label>
                    <br>
                    <input required type="text" name="AL_LEIRAS">

                    <br>
                    <input type="submit" id="changeSubmit" value="Insert" name="insert">
                </form>

               </div>
            </div>
        </div>
    </div>

    <div id="modal3" class="modal">
        <div class="modal-content">
        <span class="close">&times;</span>
        3
        </div>
    </div>

    <div id="modal4" class="modal">
        <div class="modal-content">
        <span class="close">&times;</span>
        4
        </div>
    </div>

    <div id="modal5" class="modal">
        <div class="modal-content">
        <span class="close">&times;</span>
        5
        </div>
    </div>

    <div id="modal6" class="modal">
        <div class="modal-content">
        <span class="close">&times;</span>
        6
        </div>
    </div>

    <div id="modal7" class="modal">
        <div class="modal-content">
        <span class="close">&times;</span>
        7
        </div>
    </div>

    <div id="modal8" class="modal">
        <div class="modal-content">
        <span class="close">&times;</span>
        8
        </div>
    </div>

    <div id="modal9" class="modal">
        <div class="modal-content">
        <span class="close">&times;</span>
        9
        </div>
    </div>

    <div id="modal10" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
        10
        </div>
    </div>

    <div id="modal11" class="modal">
        <div class="modal-content">
        <span class="close">&times;</span>
        11
        </div>
    </div>

    <div id="modal12" class="modal">
        <div class="modal-content">
        <span class="close">&times;</span>
        12
        </div>
    </div>

    </div> 

    <script src="./script.js"></script>
</body>
</html>