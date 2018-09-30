<?php
	// Configuration de la base de données
	define('BDD_USERNAME', 'ETU2_40');    //nom d'utilisateur
	define('BDD_PASSWORD', 'ETU2_40');    //mot de passe
	define('BDD_HOSTNAME', 'spartacus');  //nom d'hôte du serveur 
	define('BDD_DATABASE', 'info');       //nom de la base de données

	// Affiche chaque requête SQL sur la page.
	define('DEBUG_PDO', false);

	// Active l'affichage des erreurs/warnings PHP.
	define('DEBUG_PHP', true);

	//Durée minimale d'une session en minutes.
	define('SESSION_TIMEOUT', 2 * 60 * 60);
?>