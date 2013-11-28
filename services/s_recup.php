<?php
	$url_api = "http://api.outpost.travel/";
	$url_api_logements = $url_api . "placeRentals";
	$url_api_experiences = $url_api . "experiences";

	function recup($url, $options)
	{
		$url = $url . '?';
		
		foreach($options as $key => $value)
		{
			$url .= $key . '=' . $value . '&';
		}
		
		$url = substr($url, 0, -1);
		
		$content = file_get_contents($url);
		
		return $content;
	}

	function recup_logements($ville, $debut, $fin, $page = 1)
	{
		global $url_api_logements;
		
		$options = array(
					'city' => $ville,
					'page' => $page,
					//'max_results' => $max_results,
					//'sort' => $sort,
					//'sort_method' => $sort_method
					);
		
		$liste_logements = recup($url_api_logements, $options);
		
		return $liste_logements;
	}
	
	function recup_experiences($ville, $debut, $fin, $page = 1)
	{
		global $url_api_experiences;
		
		$options = array(
					'city' => $ville,
					'page' => $page,
					//'max_results' => $max_results,
					//'sort' => $sort,
					//'sort_method' => $sort_method
					);
		
		$liste_logements = recup($url_api_experiences, $options);
		
		return $liste_logements;
	}
	
	echo recup_experiences("Strasbourg", "", "");
?>