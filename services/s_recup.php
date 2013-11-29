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
		
		return json_encode($content);
	}
	
	// Récupère la liste des logements avec en tête de liste les logements les plus plussoyés
	function recup_logements($id_etape, $page = 1, $ordre_prix = 0)
	{
		global $bdd;
		
		$req = $bdd->prepare('SELECT destination, dateDebut, dateFin FROM etapes WHERE idEtape=?');
        $req->execute(array($id_etape));
		
        $etape = $req->fetchAll();
		
		$req->closeCursor();
		
		$logements_bdd = json_decode(recup_logements_bdd($id_etape, $page));
		$logements_api = json_decode(recup_logements_api($etape[0]['destination'], $etape[0]['dateDebut'], $etape[0]['dateFin'], $page));
		
		$res = array();
		
		if($page == 1)
		{
			foreach($logements_bdd as $num_logement => $logement)
			{
				array_push($res, $logement);
			}
		}
		
		foreach($logements_api as $num_logement => $logement)
		{
			if(!in_array($logement, $res) && $logement->price > $ordre_prix)
			{
				array_push($res, $logement);
			}
		}
		
		return json_encode($res);
	}
	
	// Récupère la liste des logements avec en tête de liste les logements les plus plussoyés
	function recup_experiences($id_etape, $page = 1)
	{
		global $bdd;
		
		$req = $bdd->prepare('SELECT destination, dateDebut, dateFin FROM etapes WHERE idEtape=?');
        $req->execute(array($id_etape));
		
        $etape = $req->fetchAll();
		
		$req->closeCursor();
		
		$experiences_bdd = json_decode(recup_experiences_bdd($id_etape, $page));
		$experiences_api = json_decode(recup_experiences_api($etape[0]['destination'], $etape[0]['dateDebut'], $etape[0]['dateFin'], $page));
		
		$res = array();
		
		if($page == 1)
		{
			foreach($experiences_bdd as $num_experience => $experience)
			{
				array_push($res, $experience);
			}
		}
		
		foreach($experiences_api as $num_experience => $experience)
		{
			if(!in_array($experience, $res))
			{
				array_push($res, $experience);
			}
		}
		
		return json_encode($res);
	}
	
	// Récupère un logement précis en fonction de son pid
	function recup_logement_api($id)
	{
		global $url_api_logements;
		
		$options = array(
					'pid' => $id
					);
		
		$logement = json_decode(recup_donnees_api($url_api_logements, $options));
		
		if($logement == null)
			return null;
		
		$logement->items[0]->nb_votes = 0;
		
		return json_encode($logement->items[0]);
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
		$logements = json_decode(recup_donnees_api($url_api_logements, $options));
		
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
		
		foreach($logements as $num_logement => $logement)
		{
			$logement->nb_votes = 0;
		}
		
		return json_encode($logements);
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
		
		$vote_plus = array();
		
		for($i = 0;$i < sizeof($logements);$i++)
		{
			array_push($vote_plus, $logements[$i]['votePlus']);
			$logements[$i] = json_decode(recup_logement_api($logements[$i]['idProposition']));
		}
		
		for($i = 0;$i < sizeof($vote_plus);$i++)
		{
			$logements[$i]->nb_votes = $vote_plus[$i];
		}
		
		return json_encode($logements);
	}
	
	// Récupère une experience précis en fonction de son mid
	function recup_experience_api($id)
	{
		global $url_api_experiences;
		
		$options = array(
					'mid' => $id
					);
		
		$experience = json_decode(recup_donnees_api($url_api_experiences, $options));
		
		if($experience == null)
			return null;
		
		$experience->items[0]->nb_votes = 0;
		
		return json_encode($experience->items[0]);
	}
	
	// Récupère la liste des experiences approuvées par les utilisateurs
	function recup_experiences_bdd($id_etape)
	{
		global $id_type_experience;
		global $bdd;
		
		$experiences = recup_propositions_bdd($id_etape, $id_type_experience);
		
		$vote_plus = array();
		
		for($i = 0;$i < sizeof($experiences);$i++)
		{
			array_push($vote_plus, $experiences[$i]['votePlus']);
			$experiences[$i] = json_decode(recup_experience_api($experiences[$i]['idProposition']));
		}
		
		for($i = 0;$i < sizeof($vote_plus);$i++)
		{
			$experiences[$i]->nb_votes = $vote_plus[$i];
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
		
		$experiences = json_decode(recup_donnees_api($url_api_experiences, $options));
		
		for($i = 0;$i < sizeof($experiences->items);$i++)
		{
			$experiences->items[$i]->nb_votes = 0;
		}
		
		return json_encode($experiences->items);
	}
	
	//var_dump(recup_logement_api('roo133543'));
	//var_dump(recup_logements_api("Strasbourg", '2013-11-27 16:37:58', '2013-12-03 16:37:58'));
	//var_dump(recup_logements_bdd(1));
	
	//var_dump(recup_experience_api('get34846'));
	//var_dump(recup_experiences_api("Strasbourg"));
	//var_dump(recup_experiences_bdd(1));
	
	
	//var_dump(recup_logements(1, 1, 100));
	//var_dump(recup_experiences(1));
?>