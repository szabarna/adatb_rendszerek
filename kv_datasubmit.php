<?php
session_start();
require_once('./db.php');
$user = $_SESSION['username'];

$piszkos_al_id = $_POST['al_id'];

if(isset($_POST['mv_id']) && isset($_POST['mc_id']) && isset($_POST['al_id'])) {

    $piszkos_mv = $_POST['mv_id'];
    $piszkos_mc = $_POST['mc_id'];
    $piszkos_al = $_POST['al_id'];

}


 if (!empty($user)) {

    $tiszta_mv = htmlspecialchars($piszkos_mv);
    $tiszta_mc = htmlspecialchars($piszkos_mc);
    $tiszta_al = htmlspecialchars($piszkos_al);
    $tiszta_felhasznalonev = htmlspecialchars($user);
    
    if(isset($_POST['elfogad'])) {
        $sikeres = kv_elfogad($tiszta_mv, $tiszta_mc, $tiszta_al, $user);

        if($sikeres == true) {
            header('Location: index_kv.php');
        }
        else {
            print "Something went wrong!";
            print '<br>';
		    print '<a href="index_kv.php">Vissza az kv panelre</a>';
        }
    }
    
    else if (isset($_POST['elutasit'])) {
        $sikeres = kv_elutasit($tiszta_mv, $tiszta_mc, $tiszta_al, $user);

        if($sikeres == true) {
            header('Location: index_kv.php');
        }
        else {
            print "Something went wrong!";
            print '<br>';
		    print '<a href="index_kv.php">Vissza az kv panelre</a>';
        }
    }



} 

?>
