<?php
    // recuperation par get de la cle ( 3 champ)
    $idProposition = $_GET['idProposition'];
    $idEtape = $_GET['idEtape'];
    $idTypeProposition = $_GET['idTypeProposition'];
    
    //verifie si la ligne existe dans la BD
    
    //include
    include_once('connexion_db/connexion.php');
    
    $req = $bdd->prepare('SELECT votePlus FROM propositions WHERE idProposition=? and idEtape=? and idTypeProposition=?');
    $req->execute(array($idProposition, $idEtape, $idTypeProposition));
    echo $req->rowCount();
    if($req->rowCount()>0)
    {
        //set la valeur de plus a set +1
        $row=$req->fetch();
        echo $row[0];
        $votePlus = $row[0]+1;
        $req_update = $bdd->prepare('UPDATE propositions SET votePlus=? WHERE idProposition=? and idEtape=? and idTypeProposition=?');
        $req_update->execute(array($votePlus, $idProposition, $idEtape, $idTypeProposition));
        $req_update->closeCursor();
    }
    else
    {
        //insert la nouvelle ligne
        $req_insert = $bdd->prepare('INSERT INTO propositions VALUES (?, ?, ?, ?)');
        $req_insert->execute(array($idProposition, $idEtape, $idTypeProposition, 1));
        $req_insert->closeCursor();
    }
    $req->closeCursor();	
?>
