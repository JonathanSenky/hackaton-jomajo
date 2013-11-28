<?php
	include_once('../connexion_db/connexion.php');

	$url_api = "http://api.outpost.travel/";
	$url_api_logements = $url_api . "placeRentals";
	$url_api_experiences = $url_api . "experiences";
	
	$id_type_logement = 1;
	$id_type_experience = 2;

	function recup_donnees_api($url, $options = array())
	{
		if(!empty($options))
			$url = $url . '?';
		
		foreach($options as $key => $value)
		{
			$url .= $key . '=' . $value . '&';
		}
		
		if(!empty($options))
			$url = substr($url, 0, -1);
		
		$content = json_decode(file_get_contents($url));
		
		return $content;
	}
	
	// Récupère la liste des logements avec en tête de liste les logements les plus plussoyés
	function recup_logements($id_etape, $page = 1)
	{
		global $bdd;
		
		$req = $bdd->prepare('SELECT destination, dateDebut, dateFin FROM etapes WHERE idEtape=? ORDER BY votePlus DESC');
        $req->execute(array($id_etape));
		
        $etape = $req->fetchAll();
		
		$req->closeCursor();
		
		$logements_plus = recup_logements_bdd($id_etape, $page);
		$logements_api = recup_logements_api($etape[0], $etape[1], $etape[2], $page);
		
		
	}
	
	// Récupère un logement précis en fonction de son pid
	function recup_logement_api($id)
	{
		global $url_api_logements;
		
		$options = array(
					'pid' => $id
					);
		
		$logement = recup_donnees_api($url_api_logements, $options);
		
		if($logement == null)
			return null;
		
		return $logement->items[0];
	}
	
	// Récupère la liste des logements disponibles dans une ville entre deux dates
	function recup_logements_api($ville, $debut, $fin, $page = 1)
	{
		global $url_api_logements;
		
		$options = array(
					'city' => $ville,
					'page' => $page
					);
		
		// On récupère la liste des logements à partir de l'api outpost
		$logements = recup_donnees_api($url_api_logements, $options);
		
		// On enlève de cette liste tous les logements dont les dates d'unavaibilité sont comprises
		// entre debut et fin
		$t_debut = strtotime($debut);
		$t_fin = strtotime($fin);
		
		$logements = $logements->items;
		
		$num_a_retirer = array();
		
		// On récupère la liste des numéros à enlever de la liste de base
		foreach($logements as $num_logement => $logement)
		{
			foreach($logement->unavailable as $num_unavailable => $t_unavailable)
			{
				if($t_unavailable >= $t_debut and $t_unavailable <= $t_fin)
				{
					array_push($num_a_retirer, $num_logement);
					break;
				}
			}
		}
		
		// On enlève tous les numéros à enlever
		for($i = 0;$i < sizeof($num_a_retirer);$i++)
		{
			unset($logements[$num_a_retirer[$i]]);
		}
		
		return $logements;
	}
	
	// Récupère la liste des logements/experiences concernant une étape à partir de la bdd
	function recup_propositions_bdd($id_etape, $id_type_proposition)
	{
		global $bdd;
		
		$req = $bdd->prepare('SELECT idProposition, votePlus FROM propositions WHERE idEtape=? AND idTypeProposition=? ORDER BY votePlus DESC');
        $req->execute(array($id_etape, $id_type_proposition));
		
        $propositions = $req->fetchAll();
		
		$req->closeCursor();
		
		return $propositions;
	}
	
	// Récupère la liste des logements approuvés par les utilisateurs
	function recup_logements_bdd($id_etape)
	{
		global $id_type_logement;
		global $bdd;
		
		$logements = recup_propositions_bdd($id_etape, $id_type_logement);
		
		for($i = 0;$i < sizeof($logements);$i++)
		{
			$logements[$i] = recup_logement_api($logements[$i]);
		}
		
		return json_encode($logements);
	}
	
	// Récupère la liste des experiences approuvées par les utilisateurs
	function recup_experiences_bdd($id_etape)
	{
		global $id_type_experience;
		global $bdd;
		
		$experiences = recup_propositions_bdd($id_etape, $id_type_experience);
		
		var_dump($experiences);
		
		for($i = 0;$i < sizeof($experiences);$i++)
		{
			$experiences[$i] = recup_experience_api($experiences[$i]);
		}
		
		return json_encode($experiences);
	}

	// Récupère la liste des évênements disponibles dans une ville
	function recup_experiences_api($ville, $page = 1)
	{
		global $url_api_experiences;
		
		$options = array(
					'city' => $ville,
					'page' => $page
					);
		
		$experiences = recup_donnees_api($url_api_experiences, $options);
		
		$nb_votes = array();
		
		for($i = 0;$i < sizeof($experiences->items);$i++)
		{
			array_push($nb_votes, 0);
		}
		
		return array('liste_experiences' => $experiences->items, 'nb_votes' => $nb_votes);
	}
	
	//var_dump(recup_logement_api('roo133543'));
	//var_dump(recup_logements_bdd(0));
	var_dump(recup_experiences_bdd(0));
	//var_dump(recup_logements_api("Strasbourg", '2013-11-27 16:37:58', '2013-12-03 16:37:58'));
	//var_dump(recup_experiences_api("Strasbourg"));
	//var_dump(recup_logements(1));
?>