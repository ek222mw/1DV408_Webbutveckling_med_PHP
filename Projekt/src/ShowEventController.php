<?php

	require_once("LoginModel.php");
	require_once("LoginView.php");
	require_once("AddBandEventModel.php");
	require_once("AddBandEventView.php");
	require_once("AddRatingView.php");
	require_once("AddRatingModel.php");
	require_once("DBDetails.php");

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


			$this->doControll();
		}

		public function doControll()
		{
			if($this->loginview->didUserPressShowAllEvents() && $this->loginmodel->checkLoginStatus())
			{
				try
				{


				}
				catch(Exception $e)
				{
					$this->addratingview->showMessage($e->getMessage());
				}
			}
			$this->doHTMLBody();



		}

		public function doHTMLBody()
		{
			$showEvents = $this->db->fetchShowAllEvents();

			$this->addratingview->ShowAllEventsWithBandGrades($showEvents);

		}


	}