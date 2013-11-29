<?php
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=teamkog_hackaton_2013', 'root', '');
        return $bdd;
    }
    catch(Exception $e)
    {z
        die('Erreur : '.$e->getMessage());
    }
?>