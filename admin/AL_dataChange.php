<?php
session_start();
require_once('./db.php');
$user = $_SESSION['username'];
$piszkos_mv_adoszam = $_POST['mv_id'];
$piszkos_mc_adoszam = $_POST['mc_id'];



if (!empty($piszkos_mv_adoszam) && !empty($piszkos_mc_adoszam)) {

    $tiszta_mv_adoszam = htmlspecialchars($piszkos_mv_adoszam);
    $tiszta_mc_adoszam = htmlspecialchars($piszkos_mc_adoszam);

    if(isset($_POST['update'])) {
        print "update";
    }
    
    else if (isset($_POST['delete'])) {
        $sikeres = admin_AL_delete($tiszta_mc_adoszam, $tiszta_mv_adoszam);

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
