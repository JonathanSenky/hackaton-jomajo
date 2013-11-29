<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        
        
        <?php
            include_once('connexion_db/connexion.php');
            $erreur=0;
            if(isset($_GET['lienSalle']) && !empty($_GET['lienSalle']))
            {
                $lienSalle = $_GET['lienSalle'];
                $req=$bdd->prepare('SELECT s.idSalle, nomSalle, destination, dateDebut, e.dateFin FROM salles s, etapes e WHERE lienSalle=? AND s.idSalle = e.idSalle');
                $req->execute(array($lienSalle));
                if($req->rowCount()==0)
                {
                    $erreur='salle_inexistante';
                }
                else
                {
                    $row=$req->fetch();
                    $idSalle = $row[0];
                    $nomSalle = $row[1];
                    $destination = $row[2];
                    $dateDebut = $row[3];
                    $dateFin = $row[4];
                }
                $req->closeCursor();
            }
            else
            {
                //Erreur
                $erreur='lien_vide';
            }

            if($erreur!=1)
            {
                //On redirige sur la page
                header('location:erreur.php?erreur='.$erreur);
                exit();
            }
        ?>
        
        
        <title>Salle</title>
        
        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.css" rel="stylesheet">

        
        <!-- Just for debugging purposes. Don't actually copy this line! -->
        <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    
    <body>
        <div class="col-md-10 col-md-offset-1">
            <div class="page-header">
                  <h1><?php echo $nomSalle;?> <!--<small>Subtext for header</small>--></h1>
            </div>
            <div class="row">
                <div class="col-md-9"> <!-- Colonne de gauche -->
                    <div> <!--- Partie description de la page -->
                        <h3>Description du voyage :</h3>
                        <br>
                        <table class="table table-striped table-condensed">
                            <tbody>
                                <tr>
                                    <td><strong>Destination : </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $destination;?></td>
                                </tr>
                                <tr>
                                    <td><strong>Date de début : </strong>&nbsp;<?php echo $dateDebut;?></td>
                                </tr>
                                <tr>
                                    <td><strong>Date de fin : </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $dateFin;?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>  <!--- Fin partie description de la page -->
                    <div> <!-- Liste des propositions -->
                        <div> <!-- Onglets -->
                            <ul class="nav nav-tabs nav-justified">
                                <li class="active"><a href="#">Logements</a></li>
                                <li><a href="#">Expériences</a></li>
                                <li><a href="#">Restaurants</a></li>
                            </ul>
                        </div>
                    </div> <!-- Fin liste des propositions -->
                </div> <!-- Fin colonne de gauche -->
                <div class="col-md-3">
                    <h3>ICI CHAT</h3>
                </div>
            </div>
        </div>
        
            <!--
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <th>Image</th>
                            <th>Intitulé Promotion</th>
                            <th>Etablissement</th>
                            <th>Date début</th>
                            <th>Date fin</th>
                            <th>Lien vers promotion</th>
                            <th>Consulter la note</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img class="vignette" src="img/sales.png"></td>
                                <td>Promo en attente 1</td>
                                <td>Cafe 2</td>
                                <td>13/03/2014</td>
                                <td>17/03/2014</td>
                                <td><a href="#">Description</a></td>
                                <td><img class="vignette note" src="img/note.png" data-toggle="modal" data-target="#modalValidation"></td>
                            <tr>
                                <td><img class="vignette" src="img/sales.png"></td>
                                <td>Promo en attente 2</td>
                                <td>Cafe 3</td>
                                <td>13/03/2014</td>
                                <td>17/03/2014</td>
                                <td><a href="#">Description</a></td>
                                <td><img class="vignette" src="img/note.png"></td>
                            </tr>
                            <tr>
                                <td><img class="vignette" src="img/sales.png"></td>
                                <td>Promo en attente 3</td>
                                <td>Hôtel 1</td>
                                <td>13/03/2014</td>
                                <td>17/03/2014</td>
                                <td><a href="#">Description</a></td>
                                <td><img class="vignette" src="img/note.png"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                -->
                <?php
                    //include_once('footer.php');
                ?>
        <div>
        
        </div>
    
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>