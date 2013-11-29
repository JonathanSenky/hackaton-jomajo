<?php
	session_start();

	$erreur=$_GET['erreur'];
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css" /><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Erreur</title>
</head>
<body>

<?php


	//on gère les erreurs
	
	switch ($erreur)
	{
		case "vide_sauf_partage":
			$texte="Tous les champs, excepté ceux qui concernent le partage de la salle, ne doivent pas être vides.";
			$retour="javascript:history.back();";
			break;
		case "format_date":
			$texte="Une date doit être de la forme aaaa-mm-jj et doit être correcte.";
			$retour="javascript:history.back();";
			break;
		default:
			$texte="Erreur inconnue.";
			$retour="javascript:history.back();";
			break;
	}
?>
        <div class="alert alert-error" style="text-align:center;width:80%;margin:auto;">
			<?php
                echo $texte;
                echo "<br />";
                echo "<br />";
            ?>
           <a href="<?php echo $retour; ?>" class="btn btn-danger">Retour</a>
        </div>

</body>
</html>