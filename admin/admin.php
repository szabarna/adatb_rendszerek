<?php 
 require_once('../db.php');
 session_start();

    $user = $_SESSION['username'];

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
               <h1>FIRST</h1> 
            </div>
        </div>
    </div>
    
    <div id="modal2" class="modal">
        <div class="modal-content">
        <span class="close">&times;</span>
        2
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
        </div>
    </div>

    <div id="modal11" class="modal">
        <div class="modal-content">
        <span class="close">&times;</span>
        
        </div>
    </div>

    <div id="modal12" class="modal">
        <div class="modal-content">
        <span class="close">&times;</span>
        
        </div>
    </div>

    </div> 

    <script src="./script.js"></script>
</body>
</html>