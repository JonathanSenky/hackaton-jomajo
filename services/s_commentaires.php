<?php
    include_once('../connexion_db/connexion.php');

error_reporting(e_all);
	
    if(isset($_GET['mode']) && !empty($_GET['mode']))
    {
        if(isset($_GET['idSalle']) && is_numeric($_GET['idSalle']))
        {
            $mode = $_GET['mode'];
            $idSalle = $_GET['idSalle'];
            
            if($mode=='get')
            {
                recup_commentaires($idSalle);
            }
            else if($mode=='post')
            {
                if(isset($_GET['auteur']) && !empty($_GET['auteur']))
                {
                    if(isset($_GET['contenu']) && !empty($_GET['contenu']))
                    {
                        $auteur = $_GET['auteur'];
                        $contenu = $_GET['contenu'];
                        post_commentaire($idSalle, $auteur, $contenu);
                    }
                }
            }
        }
    }
    
    function recup_commentaires($idSalle)
    {
        global $bdd;
        $req = $bdd->prepare('SELECT idCommentaire, auteur, contenu, dateCommentaire FROM commentaires WHERE idSalle=? ORDER BY dateCommentaire DESC');
        $req->execute(array($idSalle));
        $commentaires = array();
        while($row=$req->fetch())
        {
            array_push($commentaires, array('auteur'=>nl2br(wordwrap($row[1], 30, '<br>', true)), 'contenu'=>nl2br(wordwrap($row[2], 30, '<br>', true)), 'dateCommentaire'=>$row[3]));
        }
        $req->closeCursor();

        echo json_encode($commentaires);
    }
    
    function post_commentaire($idSalle, $auteur, $contenu)
    {
        global $bdd;
        $req = $bdd->prepare('INSERT INTO commentaires VALUES (NULL, ?, ?, ?, ?);');
        $req->execute(array($idSalle, $auteur, $contenu, date('Y-m-d H:i:s')));
        $req->closeCursor();
    }
    
?>