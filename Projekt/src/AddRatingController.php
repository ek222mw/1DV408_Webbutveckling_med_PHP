<?php


	require_once("LoginModel.php");
	require_once("LoginView.php");
	require_once("AddBandEventModel.php");
	require_once("AddBandEventView.php");
	require_once("AddRatingView.php");
	require_once("AddRatingModel.php");

	class AddRatingController{


		private $loginview;
		private $loginmodel;
		private $addeventmodel;
		private $addeventview;
		private $addratingview;
		private $addratingmodel;


		public function __construct(){

			// Sparar ner användarens användaragent och ip. Används vid verifiering av användaren.
			$userAgent = $_SERVER['HTTP_USER_AGENT'];
						
			// Skapar nya instanser av modell- & vy-klasser.
			$this->loginmodel = new LoginModel($userAgent);
			$this->loginview = new LoginView($this->loginmodel);
			$this->addeventmodel = new AddBandEventModel($userAgent);
			$this->addeventview = new AddBandEventView($this->loginmodel);
			$this->addratingview = new AddRatingView($this->loginmodel);
			$this->addratingmodel = new AddRatingModel();

			$this->doControll();
		}

		public function doControll(){

			if($this->loginview->didUserPressAddRating() && $this->loginmodel->checkLoginStatus())
			{
				$this->addratingmodel->getDropdownlistEvent();

				$this->doHTMLBody();
			}


		}



		public function doHTMLBody()
		{
			
				$this->addratingview->ShowAddRatingPage();
		
		}



	}