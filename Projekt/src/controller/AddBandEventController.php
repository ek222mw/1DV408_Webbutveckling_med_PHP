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
		private $addbandeventmodel;
		private $addbandeventview;

		public function __construct(){
			
			
						
			// Skapar nya instanser av modell- & vy-klassen och lägger dessa i privata variabler.
			$this->db = new DBDetails();
			$this->loginmodel = new LoginModel();
			$this->loginview = new LoginView($this->loginmodel);
			$this->addbandeventmodel = new AddBandEventModel();
			$this->addbandeventview = new AddBandEventView();

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

		/*Kontrollerar om valideringen av indata är korrekt, då läggs livespelning till.Annars kastas felmeddelande.Anropar alltid
		doHTMLBody som kontrollerar vilken vy som ska anropas. */
		public function doControllEvent(){
			
			//Kontrollerar om användaren är inloggad och har tryckt på lägg till livespelningslänken från menyn.
			if($this->loginview->didUserPressAddEvent() && $this->loginmodel->checkLoginStatus())
			{	
				//Variabler som innehåller funktionsanrop istället för hela funktionsanrop i koden. Gör det lättare att läsa koden.
				$event = $this->addbandeventview->getEventName();

				try{

					
					if($this->addbandeventview->didUserPressAddEventButton())
					{
							
							if($this->addbandeventmodel->CheckEventLength($event))
							{
								
								if($this->loginmodel->ValidateInput($event))
								{
									
									if($this->db->checkIfEventExist($event))
									{
											
											$this->db->AddEvent($event);
											$this->addbandeventview->successfulAddEvent();
										
									}

								}
								
							}
						
					}
				}
				catch(Exception $e)
				{
					$this->addbandeventview->showMessage($e->getMessage());
				}
			}

			$this->doHTMLBody();
		}

		/*Kontrollerar om valideringen av indata är korrekt, då läggs bandet till.Annars kastas felmeddelande.Anropar alltid
		doHTMLBody som kontrollerar vilken vy som ska anropas. */
		public function doControllBand(){
		
			//Kontrollerar om användaren är inloggad och har tryckt på lägg till band länken från menyn.
			if($this->loginview->didUserPressAddBand() && $this->loginmodel->checkLoginStatus())
			{
				//Variabler som innehåller funktionsanrop istället för hela funktionsanrop i koden. Gör det lättare att läsa koden.
				$band = $this->addbandeventview->getBandName();
				

				try{

					
					if($this->addbandeventview->didUserPressAddBandButton())
					{
						
						
						if($this->addbandeventmodel->CheckBandLength($band))
						{

							
							if($this->loginmodel->ValidateInput($band))
							{	
								
								if($this->db->checkIfBandExist($band))
								{		
										
										$this->db->addBand($band);
										$this->addbandeventview->successfulAddBand();
								}
							}
							
						}
					}

				}
				catch(Exception $e)
				{
					$this->addbandeventview->showMessage($e->getMessage());
				}

			}

			$this->doHTMLBody();

		}

		/*Kontrollerar om valideringen av indata är korrekt, då läggs band till livespelningen. Annars kastas felmeddelande.Anropar alltid
		doHTMLBody som kontrollerar vilken vy som ska anropas. */
		public function doControllBandToEvent(){

			if($this->loginview->didUserPressAddBandToEvent() && $this->loginmodel->checkLoginStatus())
			{

				//Variabler som innehåller funktionsanrop istället för hela funktionsanrop i koden. Gör det lättare att läsa koden.
				$eventdropdownvalue = $this->addbandeventview->pickedEventDropdownValue();
				$banddropdownvalue = $this->addbandeventview->pickedBandDropdownValue();
				
				
				try{

					if($this->addbandeventview->didUserPressAddBandToEventButton())
					{

						if($this->db->checkIfBandExistsOnEvent($eventdropdownvalue,$banddropdownvalue))
						{
							if($this->db->checkIfPickEventFromEventTableIsManipulated($eventdropdownvalue))
							{
								if($this->db->checkIfPickBandFromBandTableIsManipulated($banddropdownvalue))
								{
									$this->db->addBandToEvent($eventdropdownvalue,$banddropdownvalue);
									$this->addbandeventview->successfulAddBandToEvent();
								}
								

							}

						}
					}

				}
				catch(Exception $e)
				{
					$this->addbandeventview->showMessage($e->getMessage());
				}




			}

			$this->doHTMLBody();


		}

		//Kontrollerar vilket formulär som ska skrivas ut av vyn beroende på vilka olika knappar och/eller länkar användaren tryckt på.
		public function doHTMLBody()
		{
			
				if($this->loginview->didUserPressAddEvent())
				{
					$this->addbandeventview->ShowAddEventPage();
				}

				if($this->loginview->didUserPressAddBand())
				{
					$this->addbandeventview->ShowAddBandPage();
				}

				if($this->loginview->didUserPressAddBandToEvent())
				{
					$events = $this->db->fetchAllEvents();
					$bands = $this->db->fetchAllBands();
					

					$this->addbandeventview->ShowAddBandToEventPage($events, $bands);
				}

				
				
			
			
		}


	}