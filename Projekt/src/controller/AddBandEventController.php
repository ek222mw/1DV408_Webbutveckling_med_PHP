<?php

	require_once("./src/model/LoginModel.php");
	require_once("./src/view/LoginView.php");
	require_once("./src/model/AddBandEventModel.php");
	require_once("./src/view/AddBandEventView.php");
	require_once("./src/model/Event.php");
	require_once("./src/model/EventList.php");

	class AddBandEventController{

		private $loginview;
		private $loginmodel;
		private $addeventmodel;
		private $addeventview;

		public function __construct(){
			
			// Sparar ner användarens användaragent och ip. Används vid verifiering av användaren.
			$userAgent = $_SERVER['HTTP_USER_AGENT'];
						
			// Skapar nya instanser av modell- & vy-klassen.
			$this->db = new DBDetails();
			$this->loginmodel = new LoginModel($userAgent);
			$this->loginview = new LoginView($this->loginmodel);
			$this->addeventmodel = new AddBandEventModel($userAgent);
			$this->addeventview = new AddBandEventView($this->loginmodel);

			//Kontroller vilken metod som ska anropas beroende på indata.
			if($this->loginview->didUserPressAddEvent() && $this->loginmodel->checkLoginStatus())
			{
				$this->doControllEvent();
			}
			
			if($this->loginview->didUserPressAddBand() && $this->loginmodel->checkLoginStatus())
			{
				
				$this->doControllBand();
			}

			if($this->loginview->didUserPressAddBandToEvent() && $this->loginmodel->checkLoginStatus())
			{
				$this->doControllBandToEvent();
			}


		}

		/*Kontrollerar om valideringen av indata är korrekt, då läggs Livespelning till.Annars kastas felmeddelande.Anropar alltid
		doHTMLBody som kontrollerar vilken vy som ska anropas. */
		public function doControllEvent(){
			
			//Kontrollerar om användaren är inloggad och har tryckt på lägg till livespelningslänken från menyn.
			if($this->loginview->didUserPressAddEvent() && $this->loginmodel->checkLoginStatus())
			{	
				//Variabler som innehåller funktionsanrop istället för hela funktionsanrop i koden. Gör det lättare att läsa koden.
				$event = $this->addeventview->getEventName();

				try{

					//Kontrollerar om användaren tryckt på lägg till livespelningsknappen.
					if($this->addeventview->didUserPressAddEventButton())
					{
							//Kontrollerar längden på det inmatade värdet.
							if($this->addeventmodel->CheckEventLength($event))
							{
								//Kontrollerar om det finns ogiltiga tecken i inmatningen, om inte så returneras true.
								if($this->loginmodel->ValidateInput($event))
								{
									//Kontrollerar om livespelningen redan finns.
									if($this->db->checkIfEventExist($event))
									{
											//lägger till livespelningen och anropar rätt meddelande.
											$this->db->AddEvent($event);
											$this->addeventview->successfulAddEvent();
										
									}

								}
								
							}
						
					}
				}
				catch(Exception $e)
				{
					$this->addeventview->showMessage($e->getMessage());
				}
			}

			$this->doHTMLBody();
		}


		public function doControllBand(){
		
			//Kontrollerar om användaren är inloggad och har tryckt på lägg till band länken från menyn.
			if($this->loginview->didUserPressAddBand() && $this->loginmodel->checkLoginStatus())
			{
				//Variabler som innehåller funktionsanrop istället för hela funktionsanrop i koden. Gör det lättare att läsa koden.
				$band = $this->addeventview->getBandName();
				

				try{

					//Kontrollerar om användaren tryckt på lägga till band knappen.
					if($this->addeventview->didUserPressAddBandButton())
					{
						
						//Kontroller längden på band inmatningen 
						if($this->addeventmodel->CheckBandLength($band))
						{

							//Kontroller om det finns ogiltiga tecken i inmatningen.
							if($this->loginmodel->ValidateInput($band))
							{	
								//Kontrollerar om bandet redan finns.
								if($this->db->checkIfBandExist($band))
								{		
										//Lägger till bandet och anropar rätt meddelandet.
										$this->db->addBand($band);
										$this->addeventview->successfulAddBand();
								}
							}
							
						}
					}

				}
				catch(Exception $e)
				{
					$this->addeventview->showMessage($e->getMessage());
				}

			}

			$this->doHTMLBody();

		}

		public function doControllBandToEvent(){

			if($this->loginview->didUserPressAddBandToEvent() && $this->loginmodel->checkLoginStatus())
			{
				$eventdropdownvalue = $this->addeventview->pickedEventDropdownValue();
				$banddropdownvalue = $this->addeventview->pickedBandDropdownValue();
				
				
				try{

					if($this->addeventview->didUserPressAddBandToEventButton())
					{

						if($this->db->checkIfBandExistsOnEvent($eventdropdownvalue,$banddropdownvalue))
						{
							if($this->db->checkIfBandAndEventManipulated($eventdropdownvalue,$banddropdownvalue))
							{

								$this->db->addBandToEvent($eventdropdownvalue,$banddropdownvalue);
								$this->addeventview->successfulAddBandToEvent();

							}

						}
					}

				}
				catch(Exception $e)
				{
					$this->addeventview->showMessage($e->getMessage());
				}




			}

			$this->doHTMLBody();


		}


		public function doHTMLBody()
		{
			
				if($this->loginview->didUserPressAddEvent())
				{
					$this->addeventview->ShowAddEventPage();
				}

				if($this->loginview->didUserPressAddBand())
				{
					$this->addeventview->ShowAddBandPage();
				}

				if($this->loginview->didUserPressAddBandToEvent())
				{
					$events = $this->db->fetchAllEvents();
					$bands = $this->db->fetchAllBands();
					

					$this->addeventview->ShowAddBandToEventPage($events, $bands);
				}

				
				
			
			
		}


	}