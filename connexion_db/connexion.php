<?php

		try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=teamkog_hackaton_2013', 'root', '');
			
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}
	
?>