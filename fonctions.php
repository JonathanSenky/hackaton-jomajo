<?php

//fonction qui génère un lien avec une approche probabiliste (on génère des chaines aléatoires jusqu'a ce qu'elle passe => non existant dans la BdD)
function generate_link()
{
	$size=32;
	$list =
	'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	
	mt_srand((double)microtime()*1000000);
	
	$res = '';
	while(strlen($res)<$size)
	{
		$res .= $list[mt_rand(0,strlen($list)-1)];
	}
	
	return $res;
}

//fonction permettant d'envoyer un mail avec comme sujet $sujet, comme adresse de destinataire $mail et avec comme message $mess_text pour une première version texte et $mess_html pour une deuxième version en html
function envoi_mail($sujet,$mess_html,$mess_text,$mail)
{
	
	//generation de la frontière entre html et text

	$frontiere = md5(uniqid(mt_rand()));
	
	//on converti le message en iso-8859-1
	$mess_html = base64_encode($mess_html);
	$mess_text = base64_encode($mess_text);
	
	//on compose le header :
	$email= 'no-reply@GingerCorp';
	
	$headers = 'From: "Ginger Corp"<'.$email.'>'."\n";
	$headers .= 'Return-Path: <'.$email.'>'."\n";
	$headers .= 'MIME-Version: 1.0'."\n";
	$headers .= 'Content-Type: multipart/alternative;boundary='.$frontiere."\n";
	$headers .= 'Content-Transfer-Encoding: base64'."\n\n";
	
	//message text :
	
	$mess = '--'.$frontiere."\r\n";
	$mess .= 'Content-Type: text/plain; charset="UTF-8"'."\n";
	$mess .= 'Content-Transfer-Encoding: base64'."\n\n";
	$mess .= $mess_text."\n\n"; 
	
	//message html
	
	$mess .= '--'.$frontiere."\r\n";
	$mess .= 'Content-Type: text/html; charset="UTF-8"'."\n";
	$mess .= 'Content-Transfer-Encoding: base64'."\n\n";
	$mess .= $mess_html."\n\n";
	
	$mess .= '--'.$frontiere.'--'."\n";
	
	return mail($mail, $sujet, $mess, $headers);
}

//retourne l'url de base par rapport à l'endroit où l'on est, par exemple si on est sur
//touch.net/site/test/my_script.php
//retournera
//touch.net/site/test/
function declarer_lien_serveur(){
	
	//on récupère le http_host :
	$http_host = $_SERVER['HTTP_HOST'];
	
	//on récupère le REQUEST_URI :
	$request_uri = $_SERVER['REQUEST_URI'];
	
	//on lui enlève ce qu'il y a après le dernier '/' s'il y a quelque chose
	$tab = explode('/',$request_uri);
	
	//on ignore le premier qui est forcément un vide car la chaine commence par '/'
	//on ignore le dernier car il contient le nom du fichier actuel que l'on ne veut pas récupèrer justement
	
	$taille_tab = count($tab);
	$url_de_base = "/";
	
	for($i=1;$i<$taille_tab-1;$i++){
		$url_de_base .= $tab[$i] . '/';
	}
	
	$url_a_retourner = $http_host . $url_de_base;
	
	return $url_a_retourner;
}

?>