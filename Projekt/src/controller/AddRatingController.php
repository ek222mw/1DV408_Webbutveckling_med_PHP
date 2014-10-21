<?php


	require_once("./src/model/LoginModel.php");
	require_once("./src/view/LoginView.php");
	require_once("./src/model/AddBandEventModel.php");
	require_once("./src/view/AddBandEventView.php");
	require_once("./src/view/AddRatingView.php");
	require_once("./src/model/AddRatingModel.php");
	require_once("./src/model/DBDetails.php");

	class AddRatingController{


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
			$this->addeventview = new AddBandEventView();
			$this->addratingview = new AddRatingView();
			$this->addratingmodel = new AddRatingModel();
			$this->db = new DBDetails();


			$this->doControll();
		}

		public function doControll(){

			if($this->loginview->didUserPressAddRating() && $this->loginmodel->checkLoginStatus())
			{
				
				$eventdropdownvalue = $this->addeventview->pickedEventDropdownValue();
				$banddropdownvalue = $this->addeventview->pickedBandDropdownValue();
				$gradedropdownvalue = $this->addratingview->pickedGradeDropdownValue();
				$loggedinUser = $this->loginmodel->getLoggedInUser();


				try{

					
					if($this->addratingview->didUserPressAddGradeButton())
					{
						if($this->db->checkIfGradeExistOnEventBandUser($eventdropdownvalue,$banddropdownvalue,$loggedinUser))
						{
							if($this->db->checkIfBandAndEventManipulated($eventdropdownvalue,$banddropdownvalue))
							{
								if($this->db->checkIfPickRatingManipulated($gradedropdownvalue))
								{
									$this->db->addGradeToEventBandWithUser($eventdropdownvalue,$banddropdownvalue,$gradedropdownvalue,$loggedinUser);
									$this->addratingview->successfulAddGradeToEventWithBand();
								}
							}
						}

					}
				

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
				
				$events = $this->db->fetchAllEventWithBands();
				$bands = $this->db->fetchAllBandsWithEvent();
				$grades = $this->db->fetchAllGrades();
				$eventdropdownvalue = $this->addeventview->pickedEventDropdownValue();
				$chosenband = $this->db->fetchChosenBandsInEventDropdown($eventdropdownvalue);
				$chosenevent = $this->db->fetchChosenEventInEventDropDown($eventdropdownvalue);
				

				try
				{
					if(!$this->addratingview->didUserPressChooseGradeEvent() && !$this->addratingview->didUserPressChooseOtherGradeEvent()) 
					{
						
							$this->addratingview->ShowAddRatingPage($events);
						
					}

					if($this->addratingview->didUserPressChooseGradeEvent() && !$this->addratingview->didUserPressChooseOtherGradeEvent() && $this->db->checkIfPickEventManipulated($eventdropdownvalue))
					{
						
						$this->addratingview->ShowChosenEventRatingPage($chosenevent,$chosenband,$grades);
					}
					if($this->addratingview->didUserPressChooseOtherGradeEvent())
					{
						$this->addratingview->ShowAddRatingPage($events);
					}
				}
				catch(Exception $e)
				{
					$this->addratingview->showMessage($e->getMessage());
					$this->addratingview->ShowAddRatingPage($events);
				}


		
			}



	}