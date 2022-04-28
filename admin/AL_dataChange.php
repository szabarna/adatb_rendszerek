<?php
session_start();
require_once('./db.php');
$user = $_SESSION['username'];

$piszkos_al_id = $_POST['al_id'];

if(isset($_POST['AL_ALLAS_NEV']) && isset($_POST['AL_HELYSZIN']) && isset($_POST['AL_KAT_ID'])
 && isset($_POST['AL_MUSZAK']) && isset($_POST['AL_LEIRAS']) && isset($_POST['AL_MC_ID'])) {

    $piszkos_AL_ALLAS_NEV = $_POST['AL_ALLAS_NEV'];
    $piszkos_AL_HELYSZIN = $_POST['AL_HELYSZIN'];
    $piszkos_AL_KAT_ID = $_POST['AL_KAT_ID'];
    $piszkos_AL_MUSZAK = $_POST['AL_MUSZAK'];
    $piszkos_AL_LEIRAS = $_POST['AL_LEIRAS'];
    $piszkos_AL_MC_ID = $_POST['AL_MC_ID'];

}


if(isset($_POST['insert'])) {
    $tiszta_AL_ALLAS_NEV = htmlspecialchars($piszkos_AL_ALLAS_NEV);
    $tiszta_AL_HELYSZIN = htmlspecialchars($piszkos_AL_HELYSZIN);
    $tiszta_AL_KAT_ID = htmlspecialchars($piszkos_AL_KAT_ID);
    $tiszta_AL_MUSZAK = htmlspecialchars($piszkos_AL_MUSZAK);
    $tiszta_AL_LEIRAS = htmlspecialchars($piszkos_AL_LEIRAS);
    $tiszta_AL_MC_ID = htmlspecialchars($piszkos_AL_MC_ID);

    $sikeres = admin_AL_INSERT( $tiszta_AL_MC_ID, $tiszta_AL_ALLAS_NEV, $tiszta_AL_HELYSZIN, $tiszta_AL_KAT_ID, $tiszta_AL_MUSZAK, $tiszta_AL_LEIRAS);

    if($sikeres == true) {
        header('Location: admin.php');
    }
    else {
        print "Something went wrong!";
        print '<br>';
        print '<a href="admin.php">Vissza az admin panelre</a>';
    }
}

else if (!empty($piszkos_al_id)) {

    $tiszta_al_id = htmlspecialchars($piszkos_al_id);
    $tiszta_AL_ALLAS_NEV = htmlspecialchars($piszkos_AL_ALLAS_NEV);
    $tiszta_AL_HELYSZIN = htmlspecialchars($piszkos_AL_HELYSZIN);
    $tiszta_AL_KAT_ID = htmlspecialchars($piszkos_AL_KAT_ID);
    $tiszta_AL_MUSZAK = htmlspecialchars($piszkos_AL_MUSZAK);
    $tiszta_AL_LEIRAS = htmlspecialchars($piszkos_AL_LEIRAS);
    
    if(isset($_POST['update'])) {
        $sikeres = admin_AL_Update($tiszta_al_id, $tiszta_AL_ALLAS_NEV, $tiszta_AL_HELYSZIN, $tiszta_AL_KAT_ID, $tiszta_AL_MUSZAK, $tiszta_AL_LEIRAS);

        if($sikeres == true) {
            header('Location: admin.php');
        }
        else {
            print "Something went wrong!";
            print '<br>';
		    print '<a href="admin.php">Vissza az admin panelre</a>';
        }
    }
    
    else if (isset($_POST['delete'])) {
        $sikeres = admin_AL_delete($tiszta_al_id);

        if($sikeres == true) {
            header('Location: admin.php');
        }
        else {
            print "Something went wrong!";
            print '<br>';
		    print '<a href="admin.php">Vissza az admin panelre</a>';
        }
    }



} 

?>
