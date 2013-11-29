<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html class="no-js" lang="en">
<head>
<meta charset="utf-8">
<title> Hackathon </title>
<LINK REL="SHORTCUT ICON" href="favicon.png">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/copycss.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

<?php
	include_once("include_scripts.php");
?>
<script src="js/jquery-2.0.3.min.js" ></script>
<link rel="stylesheet" href="css/jquery-ui.css" />
<script src="js/jquery-ui.js"></script>
<script>
  //mettre le calendrier en français
  $(function() {
    $( "#dateDeb" ).datepicker( $.datepicker.regional[ "fr" ] );
  });
  
  $(function() {
    $( "#dateFin" ).datepicker( $.datepicker.regional[ "fr" ] );
  });
  
  jQuery(function($){
	$.datepicker.regional['fr'] = {
		closeText: 'Fermer',
		prevText: 'Précédent',
		nextText: 'Suivant',
		currentText: 'Aujourd\'hui',
		monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin',
		'Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
		monthNamesShort: ['Janv.','Févr.','Mars','Avril','Mai','Juin',
		'Juil.','Août','Sept.','Oct.','Nov.','Déc.'],
		dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
		dayNamesShort: ['Dim.','Lun.','Mar.','Mer.','Jeu.','Ven.','Sam.'],
		dayNamesMin: ['D','L','M','M','J','V','S'],
		weekHeader: 'Sem.',
		dateFormat: 'yy-mm-dd',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
		$.datepicker.setDefaults($.datepicker.regional['fr']);
	});
</script>


<link rel="alternate" type="application/rss+xml" title="Roots Feed" href="/feed/">
</head>
<body class="home page">

<header class="banner" role="banner">
	<div class="container">
		<div itemscope itemtype="http://schema.org/Organization">

		<!-- Logo -->
		<img src="images/logo_ginger_corp.png" style="display:inline;"/>
		<b><h1 style="display:inline;margin-left:20px;color:white;font-weight:bold;">Ginger Corp</h1></b><br />
		
		</div>
	</div>
</header>

<div class="wrap " role="document">
<div class="content ">
<main class="main col-lg-12" role="main">
<section class="intro" style="padding-top:50px;background: #27ae60 url(images/logo_ginger_corp_opa.png) no-repeat 50% 0 !important;">
<div class="container">
<h2 style="font-weight:bold;color: white; text-shadow: black 0.1em 0.1em 0.3em;font-size: 2.8em !important;" >Le site pour voyager entre amis !<br /><br /></h2>
<ul class="list-inline list-btns">

&nbsp;<button class="btn btn-primary btn-lg" style="background-color:orange !important;color:white;font-size: 3.5em !important;"  data-toggle="modal" data-target="#modalCreerSalle">Créer une salle</button>

<li></li>
</ul>
</div>

</section>
<section class="share">
<div class="container">
<ul class="list-share">
<li><a class="btn" target="_blank" href="https://github.com/JonathanSenky/hackaton-jomajo"><img src="images/github.png" style="display:inline;width:16px;" /> GitHub</a></li>
<li><a class="btn" target="_blank" href="http://docs.outpost.travel/en/latest/"><img src="images/outpost.png" style="display:inline;width:16px;" /> Outpost.Travel</a></li>
</ul>
</div>
</section>



<section class="testimonials">
	<div class="container">
		<h2>Hackathon 2013</h2>
		<div class="row">
			<div class="col-sm-6">
				<blockquote class="t-1">
				<p>"Si ça fait mal, faites le...en 36 heures."</p>
				<small>Jonathan SENKY</small>
				</blockquote>
			</div>
			
			<div class="col-sm-6">
				<blockquote class="t-1">
				<p>"Pas d'bras, pas d'chocolats. Pas d'roux, pas d'hackathon."</p>
				<small>Jonathan DELAMARE</small>
				</blockquote>
			</div>
			
			<div class="col-sm-6">
				<blockquote class="t-2">
				<p>"Commit du soir, espoir. Build du matin, chagrin T_T"</p>
				<small>Matthieu NICOLAS</small>
				</blockquote>
			</div>
			
			<div class="col-sm-6">
				<blockquote class="t-2">
				<p>"Il y a 10 types de personnes dans le monde : celles qui comprennent le binaire, et celles qui ne le comprennent pas."</p>
				<small>Charles BESSONNET</small>
				</blockquote>
			</div>
		</div>
	</div>
</section>

<footer class="content-info" role="contentinfo">
	<div class="container">

		<p style="font-size:16px;" >&copy; 2013 Ginger Corp &middot;</p>

	</div>
</footer>

<script src="/assets/js/1f7070be.scripts.min.js"></script>



<!-- Modal -->
<div class="modal fade" id="modalCreerSalle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Création d'une salle</h4>
      </div>
      <div class="modal-body">
        <form action="bdd_creation_salle.php" method="POST" >
			<label for="nomSalle">Nom de la salle</label>
			<input type="text" class="form-control" id="nomSalle" name="nomSalle" placeholder="Entrez un nom de salle">
			
			<br />
			
			<label for="dest">Destination</label>
			<input type="text" class="form-control" id="dest" name="dest" placeholder="Entrez une destination">
			
			<br />
			
			<label for="mail">Votre e-mail</label>
			<input type="email" class="form-control" id="mailCreateur" name="mailCreateur" placeholder="Entrez votre adresse e-mail">
			
			<br />
			
			<label for="dateDeb">Date de début</label>
			<input type="text" class="form-control" style="width:110px;display:inline;margin:10px;" name="dateDeb" id="dateDeb" /> 
			
			<label for="dateDeb">Date de fin</label>
			<input type="text" class="form-control" style="width:110px;display:inline;margin:10px;" name="dateFin" id="dateFin" /> 
			
			<br />
			<br />
			
			<label for="mail">Partager avec</label> <button class="btn btn-info" type="button" onclick="javascript:ajouterChampMail();" ><span class="glyphicon glyphicon-plus"></span> Ajouter un champ</button>
			<br /><br />
			<div id="adresses_mail" name="adresses_mail">
				<div class='input-group'>
					<input type='email' class='form-control' id='mail[]' name='mail[]' placeholder='Entrez une adresse e-mail' style='margin-top:5px;'>
					<span class='input-group-btn'>
						<button class='btn btn-default' onclick='javascript:removeParent(this);' type='button' style='margin-top:5px;'>&times;</button>
					</span>
				</div>
			</div>
			
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
		<input type="submit" class="btn btn-primary" value="Créer !"/>
		</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/JavaScript">

	function ajouterChampMail(){
		
		var champ = document.getElementById('adresses_mail');
		
		var div = document.createElement("div");
		div.setAttribute('class','input-group');
		
		div.innerHTML = "<input type='email' class='form-control' id='mail[]' name='mail[]' placeholder='Entrez une adresse e-mail' style='margin-top:5px;'><span class='input-group-btn'><button class='btn btn-default' onclick='javascript:removeParent(this);' type='button' style='margin-top:5px;'>&times;</button></span>";
		
		champ.appendChild(div);
		
	}
	
	function removeParent(elt){
		
		//l'élément à supprimer
		var parent = elt.parentNode.parentNode;
		
		//le parent de l'élément à supprimer
		var parentParent = parent.parentNode;
		
		parentParent.removeChild(parent);
	
	}
	
</script>
</body>
</html>