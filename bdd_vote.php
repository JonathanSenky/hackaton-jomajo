<?php

// recuperation par get de la cle ( 3 champ)
    $idProposition      = $_GET['idProposition']
    $idEtape            = $_GET['idEtape']
    $idTypeProposition  = $_GET['idTypeProposition']
//verifie si la ligne exisst dna la BD
    
    //includes
	include_once("fonctions.php");
	include_once("connexion_db/connexion.php");
    
    $req_verif = $bdd->prepare("SELECT COUNT (*) FROM propositons WHERE 'idProposition'=$idProposition and 'idEtape'=$idEtape" and'idTypeProposition'= $idTypeProposition);
    $req_verif->execute();
    $row=$req_verif->fetch();

    
    if($row[0]!=0){
        //set la valeur de plus a set +1
        
    }else{
        //insert la nouvelle ligne
    }
    

	
?>
