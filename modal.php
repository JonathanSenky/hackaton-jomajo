<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

<title>Hackaton</title>
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
			<input type="text" />
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
		<input type="submit" class="btn btn-primary" value="Créer !"/>
		</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Ajout des scripts JS à la fin pour un chargement plus rapide -->
<?php
	include_once("include_scripts.php");
?>
</html>


