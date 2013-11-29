<?php
	
	//sécurisation
	if(!isset($_POST['nomSalle']) || empty($_POST['nomSalle']) || !isset($_POST['mailCreateur']) || empty($_POST['mailCreateur']) || !isset($_POST['dateDeb']) || empty($_POST['dateDeb']) || !isset($_POST['dateFin']) || empty($_POST['dateFin'])){
		header('location:erreur.php?erreur=vide_sauf_partage');
	}
	
	//récupération des variables
	$nomSalle = $_POST['nomSalle'];
	$mailCreateur = $_POST['mailCreateur'];
	
	//format des dates : yyyy-mm-dd
	$dateDeb = $_POST['dateDeb'];
	$dateFin = $_POST['dateFin'];
	
	//vérification de la validité des dates
	$tabDateDeb = explode('-',$dateDeb);
	$tabDateFin = explode('-',$dateFin);
	
	if(count($tabDateDeb) == 3 || count($tabDateFin) == 3){
		//checkdate(mois,jour,année)
		if(!checkdate($tabDateDeb[1],$tabDateDeb[2],$tabDateDeb[0]) || !checkdate($tabDateFin[1],$tabDateFin[2],$tabDateFin[0])){
			//date fausse
			header('location:erreur.php?erreur=format_date');
		}
	}
	else{
		//date fausse
		header('location:erreur.php?erreur=format_date');
	}
	
	
	//includes
	include_once("fonctions.php");
	include_once("connexion_db/connexion.php");
	
	//on crée une url unique pour la salle (et on vérifie qu'il n'y a pas déjà une salle avec cet id)
	do
	{
		$lienSalle = generate_link();
		$array_verif=array();
		$req_verif = $bdd->prepare("SELECT COUNT (idSalle) FROM salles WHERE lienSalle=?");
		$req_verif->execute(array($lienSalle));
		$row=$req_verif->fetch();
	}
	while($row[0]!=0);
	$req_verif->closeCursor();
	
	//ajout de la ligne dans la BdD
	$req_ajout_salle = $bdd->prepare("INSERT INTO salles VALUES ('',?,?,?,?)");
	$req_ajout_salle->execute(array($nomSalle,$lienSalle,$dateDeb,$dateFin));
	$row=$req_ajout_salle->fetch();
	$req_ajout_salle->closeCursor();
	
	//envoi des mails
		//envoi du mail pour le créateur
		
		
		//envoi des mails pour le partage (si indiqué)
		/*
		$tab = array();
		$tab = $_POST['mail'];
		echo "taille = ".count($tab)."<br />";
		print_r($tab);
		*/
	
	
?>