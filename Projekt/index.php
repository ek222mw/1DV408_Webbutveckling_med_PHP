<?php
	session_start();
	
	// Adderar ytterliggare s�kerhet g�llande sessionen.
	session_regenerate_id();
	ini_set('session.cookie_httponly', true);
	
	// St�ller in sidans format s� att m�nad, �r, tid etc. visas p� svenska.
	setlocale(LC_ALL , "swedish");
	
	require_once("src/controller/NavigationController.php");

	$c = new NavigationController();
			
	
	
?>