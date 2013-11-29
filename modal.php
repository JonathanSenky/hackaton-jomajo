<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

<title>Hackaton</title>
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

</head>

<body>
	<!-- Button trigger modal -->
	<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modalCreerSalle">
	  Créer une salle
	</button>

</body>


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
			
			<label for="mail">Votre e-mail</label>
			<input type="email" class="form-control" id="mailCreateur" name="mailCreateur" placeholder="Entrez votre adresse e-mail">
			
			<br />
			
			<label for="dateDeb">Date de début</label>
			<!--<input type="text" class="form-control" id="dateDeb" name="dateDeb" placeholder="Entrez une date de début">-->
			<input type="text" class="form-control" style="width:110px;display:inline;margin:10px;" name="dateDeb" id="dateDeb" /> 
			
			<label for="dateDeb">Date de fin</label>
			<!--<input type="text" class="form-control" id="dateFin" name="dateFin" placeholder="Entrez une date de fin">-->
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
</html>


