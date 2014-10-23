<?php


	require_once("./src/model/LoginModel.php");
	require_once("./src/view/LoginView.php");
	require_once("./src/view/AddBandEventView.php");
	require_once("./src/view/AddRatingView.php");
	require_once("./src/model/DBDetails.php");

	class AddRatingController{


		private $loginview;
		private $loginmodel;
		private $addbandeventview;
		private $addratingview;
		private $db;

		public function __construct(){

						
			// Skapar nya instanser av modell- & vy-klasser och lägger dessa i privata variabler.
			$this->loginmodel = new LoginModel();
			$this->loginview = new LoginView($this->loginmodel);
			$this->addbandeventview = new AddBandEventView();
			$this->addratingview = new AddRatingView();
			$this->db = new DBDetails();


			$this->doControll();
		}


		/*Kontrollerar indata, om alla valideringar är uppfyllda så skapas ett betyg, annars kastas ett felmeddelande.
		Anropar alltid doHTMLBody som har hand om kontroll av vilka vyer som ska visas. */
		public function doControll(){

			if($this->loginview->didUserPressAddRating() && $this->loginmodel->checkLoginStatus())
			{
				//Variabler som innehåller funktionsanrop istället för hela funktionsanrop i koden. Gör det lättare att läsa koden.
				$eventdropdownvalue = $this->addbandeventview->pickedEventDropdownValue();
				$banddropdownvalue = $this->addbandeventview->pickedBandDropdownValue();
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


		/*Kontrollerar vilket formulär som ska skrivas ut av vyn beroende på vilka olika knappar och/eller länkar användaren tryckt på.
		Kastar felmeddelande om manipulering av event gjorts och fångar och kontrollerar vilken vy som ska visa detta meddelande. */
		public function doHTMLBody()
		{
				
				//Variabler som innehåller funktionsanrop istället för hela funktionsanrop i koden. Gör det lättare att läsa koden
				$events = $this->db->fetchAllEventWithBands();
				$bands = $this->db->fetchAllBandsWithEvent();
				$grades = $this->db->fetchAllGrades();
				$eventdropdownvalue = $this->addbandeventview->pickedEventDropdownValue();
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