<?php
	include_once('fonctions.php');
	$test = declarer_lien_serveur();
	
	echo $test;
	/*
	//sécurisation
	if(!isset($_POST['nomSalle']) || empty($_POST['nomSalle']) || !isset($_POST['mailCreateur']) || empty($_POST['mailCreateur']) || !isset($_POST['dateDeb']) || empty($_POST['dateDeb']) || !isset($_POST['dateFin']) || empty($_POST['dateFin']) || !isset($_POST['dest']) || empty($_POST['dest'])){
		header('location:erreur.php?erreur=vide_sauf_partage');
		exit;
	}
	
	//récupération des variables
	$nomSalle = $_POST['nomSalle'];
	$mailCreateur = $_POST['mailCreateur'];
	$dest = $_POST['dest'];
	
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
			exit;
		}
	}
	else{
		//date fausse
		header('location:erreur.php?erreur=format_date');
		exit;
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
	
	//ajout des lignes dans la BdD
	
	//ajout de la salle
	$req_ajout_salle = $bdd->prepare("INSERT INTO salles VALUES ('',?,?,?,?)");
	$req_ajout_salle->execute(array($nomSalle,$lienSalle,$dateDeb,$dateFin));
	$idSalle = $bdd->lastinsertid();
	$req_ajout_salle->closeCursor();
	
	echo $idSalle;
	
	//ajout de l'étape
	$req_ajout_etape = $bdd->prepare("INSERT INTO etapes VALUES ('',?,?,?,?)");
	$req_ajout_etape->execute(array($idSalle,$dest,$dateDeb,$dateFin));
	$req_ajout_etape->closeCursor();
	
	//envoi des mails
		//envoi du mail pour le créateur
		$sujet = "Création de la salle réussie !";
		
		$mess_text_createur = "Bonjour,\n\nVotre salle a bien été créée, un mail a aussi été envoyé aux personnes avec qui vous vouliez la partager.
		\n\n
		Pour rejoindre la salle veuillez suivre le lien suivant : <a href='$lienSalle'>$lienSalle</a> 
		\n\n
		(Si vous ne pouvez pas cliquer sur le lien copier-coller le dans la barre d'adresse de votre navigateur)";
		
		$mess_html_createur = "<html><body>Bonjour,<br /><br />Votre salle a bien été créée, un mail a aussi été envoyé aux personnes avec qui vous vouliez les partager.
		<br /><br />
		Pour rejoindre la salle veuillez suivre le lien suivant : <a href='$lienSalle'>$lienSalle</a> 
		<br /><br />
		(Si vous ne pouvez pas cliquer sur le lien copier-coller le dans la barre d'adresse de votre navigateur)
		
		</body></html>";
		
		envoi_mail($sujet,$mess_text_createur,$mess_html_createur,$mailCreateur);
		
		//envoi des mails pour le partage (si indiqué)
		/*
		$tab = array();
		$tab = $_POST['mail'];
		echo "taille = ".count($tab)."<br />";
		print_r($tab);
		*/
	
	
?>