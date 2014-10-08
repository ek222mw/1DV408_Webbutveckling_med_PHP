<?php

	require_once("src/LoginModel.php");
	require_once("src/LoginView.php");
	require_once("src/AddBandEventModel.php");
	require_once("src/AddBandEventView.php");

	class AddBandEventController{

		private $loginview;
		private $loginmodel;
		private $addeventmodel;
		private $addeventview;

		public function __construct(){

			// Sparar ner användarens användaragent och ip. Används vid verifiering av användaren.
			$userAgent = $_SERVER['HTTP_USER_AGENT'];
						
			// Skapar nya instanser av modell- & vy-klassen.
			$this->loginmodel = new LoginModel($userAgent);
			$this->loginview = new LoginView($this->loginmodel);
			$this->addeventmodel = new AddBandEventModel($userAgent);
			$this->addeventview = new AddBandEventView($this->loginmodel);
		}

		public function doHTMLBody()
		{
			
				
				$this->addeventview->ShowAddEventPage();
			
			
		}


	}