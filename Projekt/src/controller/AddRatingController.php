<?php


	require_once("./src/model/LoginModel.php");
	require_once("./src/view/LoginView.php");
	require_once("./src/view/AddBandEventView.php");
	require_once("./src/view/AddRatingView.php");
	require_once("./src/model/AddRatingModel.php");
	require_once("./src/model/DBDetails.php");

	class AddRatingController{


		private $loginview;
		private $loginmodel;
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
			$this->addeventview = new AddBandEventView();
			$this->addratingview = new AddRatingView();
			$this->addratingmodel = new AddRatingModel();
			$this->db = new DBDetails();


			$this->doControll();
		}


		/*Kontrollerar indata, om alla valideringar är uppfyllda så skapas ett betyg, annars kastas ett felmeddelande.
		Anropar alltid doHTMLBody som har hand om kontroll av vilka vyer som ska visas. */
		public function doControll(){

			if($this->loginview->didUserPressAddRating() && $this->loginmodel->checkLoginStatus())
			{
				//Variabler som innehåller funktionsanrop istället för hela funktionsanrop i koden. Gör det lättare att läsa koden.
				$eventdropdownvalue = $this->addeventview->pickedEventDropdownValue();
				$banddropdownvalue = $this->addeventview->pickedBandDropdownValue();
				$gradedropdownvalue = $this->addratingview->pickedGradeDropdownValue();
				$loggedinUser = $this->loginmodel->getLoggedInUser();


				try{

					//Kontrollerar om användaren tryckt på Lägga till betyg knappen.
					if($this->addratingview->didUserPressAddGradeButton())
					{	
						//Kontrollerar om användaren redan satt betyg på den livespelningen med det bandet. 
						if($this->db->checkIfGradeExistOnEventBandUser($eventdropdownvalue,$banddropdownvalue,$loggedinUser))
						{	
							//Kontrollerar om livespelningen och/eller bandet har fått sina värden manipulerade.
							if($this->db->checkIfBandAndEventManipulated($eventdropdownvalue,$banddropdownvalue))
							{	
								//Kontrollerar om betyget har fått sitt värde manipulerat.
								if($this->db->checkIfPickRatingManipulated($gradedropdownvalue))
								{	
									//Lägger till betyg och anropar rätt meddelande och skickar ut det till doHTMLBody.
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


		/*Kontrollerar vilket formulär som ska skrivas ut av vyn beroende på vilka olika knappar och/eller länkar användaren tryckt på.
		Kastar felmeddelande om manipulering av event gjorts och fångar och kontrollerar vilken vy som ska visa detta meddelande. */
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