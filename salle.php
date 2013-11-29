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

            if($erreur!=0)
            {
                //On redirige sur la page
                header('location:erreur.php?erreur='.$erreur);
                exit();
            }
        ?>
        
        
        <title>Salle</title>
        
        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
        
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
                                <li id="liLgt" class="active"><a href="#" onclick="genererListe('lgt')">Logements</a></li>
                                <li id="liExp"><a href="#" onclick="genererListe('exp')">Expériences</a></li>
                                <li id="liResto"><a href="#" onclick="genererListe('resto')">Restaurants</a></li>
                            </ul>
                        </div>
                        <div><!-- Liste des propositions -->
                            <br>
                            <h3>Liste des <span id="spanType">logements</span></h3>
                            <input id="ordrePrix" type="text" class="form-control" placeholder="Saisissez un prix maximum">
                            <table class="table table-stripped table-condensed">
                                <thead>
                                    <th>Image</th>
                                    <th>Description</th>
                                </thead>
                                <tbody id="tbody">
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- Fin liste des propositions -->
                </div> <!-- Fin colonne de gauche -->
                <div class="col-md-3">
                    <h3>ICI CHAT</h3>
                </div>
            </div>
        </div>
        
    
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        
        <script>
            var page=1;
        
            function vote(pid, idTypeProposition)
            {
                console.log('On envoie');
                console.log('pid : '+pid);
                $.get('bdd_vote.php?idProposition='+pid+'&idEtape=1&idTypeProposition='+idTypeProposition, function success(data)
                       {
                           console.log('Vote pris en compte');
                       });
            }
            
            function genererLogements(json)
            {
                for(var i=0; i<json.length; i++)
                {
                    var proposition = json[i];
                    console.log(proposition);
                    var photos = proposition.photos;
                    var urlPhoto = photos[0].url;
                    var heading = proposition.heading;
                    var description = proposition.description;
                    var lien = proposition.link;
                    var nbVotes = proposition.nb_votes;
                    var pid = proposition.pid;
                    var provider = proposition.provider;
                    
                    var htmlImage = '<img class="vignette" src="'+urlPhoto+'">';
                    var htmlBoutonVote = '<button type="button" class="btn btn-success" onclick="vote(\''+pid+'\', 1);">Votez</button>';
                    
                    
                    $('#tbody').html($('#tbody').html() + '<tr><td>'+htmlImage+'</td><td><h3>'+heading+'</h3><br><pre>'+description+'</pre><br>'+htmlBoutonVote+'</td></tr>');
                    
                    //console.log(proposition);
                }
            }
            
            function genererExperiences(json)
            {
                for(var i=0; i<json.length; i++)
                {
                    var proposition = json[i];
                    console.log(proposition);
                }
            }
            
            function genererResto(json)
            {
            }
            
            function genererListe(mode)
            {
                $('#liLgt').removeClass('active');
                $('#liExp').removeClass('active');
                $('#liResto').removeClass('active');
                
                $('#tbody').html('');
                var ordrePrix = $('#ordrePrix').val();
                if(!ordrePrix || ordrePrix==0)
                {
                    ordrePrix=9999999999999;
                }

                switch(mode)
                {
                        case 'lgt':
                            $('#liLgt').addClass('active');
                            $.getJSON('services/s_appel_recup.php?mode=lgt&idEtape=1&page='+page+'&ordrePrix='+ordrePrix, genererLogements);
                            break;
                        case 'exp':
                            $('#liExp').addClass('active');
                            $.getJSON('services/s_appel_recup.php?mode=exp&idEtape=1&page='+page, genererExperiences);
                            break;
                        case 'resto':
                            $('#liResto').addClass('active');
                            break;
                }
            }
            
            genererListe('lgt');
        </script>
        
    </body>
</html>