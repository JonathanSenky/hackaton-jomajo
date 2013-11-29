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
                $req=$bdd->prepare('SELECT s.idSalle, idEtape, nomSalle, destination, dateDebut, e.dateFin FROM salles s, etapes e WHERE lienSalle=? AND s.idSalle = e.idSalle');
                $req->execute(array($lienSalle));
                if($req->rowCount()==0)
                {
                    $erreur='salle_inexistante';
                }
                else
                {
                    $row=$req->fetch();
                    $idSalle = $row[0];
                    $idEtape = $row[1];
                    $nomSalle = $row[2];
                    $destination = $row[3];
                    $dateDebut = $row[4];
                    $dateFin = $row[5];
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
                                <li id="liLgt" class="active"><a href="#" onclick="remiseZero('lgt')">Logements</a></li>
                                <li id="liExp"><a href="#" onclick="remiseZero('exp')">Expériences</a></li>
                                <li id="liResto"><a href="#">Restaurants</a></li>
                            </ul>
                        </div>
                        <div><!-- Liste des propositions -->
                            <br>
                            <h3>Liste des <span id="spanType">logements</span></h3>
                            <form class="">
                                <input id="ordrePrix" type="text" class="form-control" placeholder="Saisissez un prix maximum">
                                <button type="button" class="btn" onclick="remiseZero(mode);">Rechercher</button>
                            </form>
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
            var results=0;
            var idEtape=<?php echo $idEtape;?>;
            var mode='lgt';
            
            function vote(pid, idTypeProposition)
            {
                $('#myModal').modal('show');
                console.log('On envoie');
                console.log('pid : '+pid);
                $('#vote'+pid).html('Merci de votre vote !').attr('disabled', 'true');
                var nbVotes = parseInt($('#spanVote'+pid).html()) +1;
                $('#spanVote'+pid).html(nbVotes);
                localStorage[pid] = true;
                $.get('bdd_vote.php?idProposition='+pid+'&idEtape=1&idTypeProposition='+idTypeProposition, function success(data)
                       {
                           $('#myModal').modal('hide');
                           console.log('Vote pris en compte');
                       });
            }
            
            function genererLogements(json)
            {
                if(json.length==0)
                {
                    results=0;
                }
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
                    var prix = proposition.price;
                    
                    var htmlImage = '<img class="vignette" src="'+urlPhoto+'">';
                    var htmlBoutonCarousel;
                    var htmlBoutonDetails = '<a href="'+lien+'" target="_blank" class="btn btn-info">Plus de détails</a>';
                    var htmlBoutonVote;
                    if(localStorage[pid])
                    {
                        htmlBoutonVote = '<button id="vote'+pid+'" type="button" class="btn btn-success" disabled>Merci de votre vote !</button>';
                    }
                    else
                    {
                        htmlBoutonVote = '<button id="vote'+pid+'" type="button" class="btn btn-success" onclick="vote(\''+pid+'\', 1);">Votez</button>';
                    }
                    
                    
                    $('#tbody').html($('#tbody').html() + '<tr><td>'+htmlImage+'<br><br><center><span style="color:#d2322d;"><strong>Prix : '+prix+'€</strong></span><br><br>'+htmlBoutonVote+'<br><br><strong>Nombre de votes : <span id="spanVote'+pid+'">'+nbVotes+'</span></strong></center></td><td><h3>'+heading+'</h3><br><pre>'+description+'</pre><br>'+htmlBoutonDetails+'</td></tr>');
                    $('#myModal').modal('hide');
                    //console.log(proposition);
                }
            }
            
            function genererExperiences(json)
            {
                if(json.length==0)
                {
                    results=0;
                }
                for(var i=0; i<json.length; i++)
                {
                    var proposition = json[i];
                    console.log(proposition);
                    var photos = proposition.photos;
                    var urlPhoto = photos[0].photo;
                    var heading = proposition.heading;
                    var description = proposition.description;
                    var lien = proposition.link;
                    var nbVotes = proposition.nb_votes;
                    var mid = proposition.mid;
                    var provider = proposition.provider;
                    
                    var htmlImage = '<img class="vignette" src="'+urlPhoto+'">';
                    var htmlBoutonCarousel;
                    var htmlBoutonDetails = '<a href="'+lien+'" target="_blank" class="btn btn-info">Plus de détails</a>';
                    var htmlBoutonVote;
                    if(localStorage[mid])
                    {
                        htmlBoutonVote = '<button id="vote'+mid+'" type="button" class="btn btn-success" disabled>Merci de votre vote !</button>';
                    }
                    else
                    {
                        htmlBoutonVote = '<button id="vote'+mid+'" type="button" class="btn btn-success" onclick="vote(\''+mid+'\', 2);">Votez</button>';
                    }
                    
                    
                    $('#tbody').html($('#tbody').html() + '<tr><td>'+htmlImage+'<br><br><center>'+htmlBoutonVote+'<br><br><strong>Nombre de votes : <span id="spanVote'+mid+'">'+nbVotes+'</span></strong></center></td><td><h3>'+heading+'</h3><br><pre>'+description+'</pre><br>'+htmlBoutonDetails+'</td></tr>');
                    $('#myModal').modal('hide');
                    //console.log(proposition);
                }
            }
            
            function genererResto(json)
            {
                
            }
            
            function remiseZero(type)
            {
                page = 1;
                mode = type;
                genererListe();
                $('#tbody').html('');
                $('#ordrePrix').val('');
                var type;
                switch(mode)
                {
                        case 'lgt':
                            type='logements';
                            break;
                        case 'exp':
                            type='expériences';
                }
                $('#spanType').html(type)
            }
            
            function genererListe()
            {
                $('#myModal').modal('show');
                $('#liLgt').removeClass('active');
                $('#liExp').removeClass('active');
                $('#liResto').removeClass('active');
                
                var ordrePrix = $('#ordrePrix').val();
                if(!ordrePrix || ordrePrix==0)
                {
                    ordrePrix=9999999999999;
                }

                switch(mode)
                {
                        case 'lgt':
                            $('#liLgt').addClass('active');
                            $.getJSON('services/s_appel_recup.php?mode=lgt&idEtape='+idEtape+'&page='+page+'&ordrePrix='+ordrePrix, genererLogements);
                            break;
                        case 'exp':
                            $('#liExp').addClass('active');
                            $.getJSON('services/s_appel_recup.php?mode=exp&idEtape='+idEtape+'&page='+page, genererExperiences);
                            break;
                        case 'resto':
                            $('#liResto').addClass('active');
                            break;
                }
            }
                
             $(function () {
                setTimeout(function(){results=1;},5000);
                genererListe('lgt');
                //$('#myModal').modal('show');
                var $window = $(window);
                $window.scroll(function () {
                 if ($window.height() + $window.scrollTop()== $(document).height() && results==1 && timer=1) {
                     page++;
                     console.log(page);
                     timer=0;
                     setTimeout(function(){timer=1;},5000);
                     console.log('Scroll en bas de page');
                     genererListe();
                 }
             });
         });
        </script>
        
        <div style='position: absolute; left: 50%; top: 50%;' class="fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div>
            <div>
              <div>
                <img src="http://www.mediaforma.com/sdz/jquery/ajax-loader.gif">
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        
        <script>
            
        </script>
        
    </body>
</html>