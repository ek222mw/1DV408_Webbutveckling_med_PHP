<?php

	require_once("./src/model/LoginModel.php");
	require_once("./src/view/LoginView.php");
	require_once("./src/model/AddBandEventModel.php");
	require_once("./src/view/AddBandEventView.php");
	require_once("./src/view/AddRatingView.php");
	require_once("./src/model/AddRatingModel.php");
	require_once("./src/model/DBDetails.php");

	class ShowEventController{

		private $loginview;
		private $loginmodel;
		private $addeventmodel;
		private $addeventview;
		private $addratingview;
		private $addratingmodel;
		private $db;

		public function __construct(){

			// Sparar ner användarens användaragent och ip. Används vid verifiering av användaren.
			$userAgent = $_SERVER['HTTP_USER_AGENT'];
						
			// Skapar nya instanser av modell- & vy-klasser.
			$this->loginmodel = new LoginModel($userAgent);
			$this->loginview = new LoginView($this->loginmodel);
			$this->addeventmodel = new AddBandEventModel();
			$this->addeventview = new AddBandEventView($this->loginmodel);
			$this->addratingview = new AddRatingView($this->loginmodel);
			$this->addratingmodel = new AddRatingModel();
			$this->db = new DBDetails();


			$this->doHTMLBody();
		}


		public function doHTMLBody()
		{
			$showEvents = $this->db->fetchShowAllEvents();

			$this->addratingview->ShowAllEventsWithBandGrades($showEvents);

		}


	}