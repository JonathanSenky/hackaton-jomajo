<?php
    include_once('s_recup.php');

    $mode = $_GET['mode'];

    switch($mode) 
    {
        case 'lgt':
            appel_recup_logements();
            break;
        case 'exp':
            appel_recup_experiences();
            break;
        case 'resto':
            break;
    }

    function appel_recup_logements()
    {
        $id_etape = $_GET['idEtape'];
        $page = $_GET['page'];
        $ordre_prix = $_GET['ordrePrix'];
        
        echo recup_logements($id_etape, $page, $ordre_prix);    
    }

    function appel_recup_experiences()
    {
        $id_etape = $_GET['idEtape'];
        $page = $_GET['page'];
        
        echo recup_experiences($id_etape, $page);  
    }
?>