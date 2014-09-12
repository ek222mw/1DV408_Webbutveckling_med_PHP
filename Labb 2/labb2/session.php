<?php


session_start();

class session{


	public function getSessionAndCheckboxStatus(){

	$checkbox = $_POST['checkbox'];


	if(isset($_SESSION["SessionUsername"])){
		$saveUserSession = $_SESSION["SessionUsername"];
	}

	if(isset($checkbox)){

		$user = $_POST['username'];
		$saveUserSession = $user;
		var_dump($saveUserSession);
		return $saveUserSession;

	}


	}
}


?>