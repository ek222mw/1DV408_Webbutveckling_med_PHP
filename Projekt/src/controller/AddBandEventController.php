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

		public function doControllEvent(){

			if($this->loginview->didUserPressAddEvent() && $this->loginmodel->checkLoginStatus())
			{	
				$event = $this->addeventview->getEventName();
				


				try{

					if($this->addeventview->didUserPressAddEventButton())
					{

							if($this->addeventmodel->CheckEventLength($event))
							{
								
									if($this->db->checkIfEventExist($event))
									{
										
									$this->db->AddEvent($event);
									$this->addeventview->successfulAddEvent();

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
		

			if($this->loginview->didUserPressAddBand() && $this->loginmodel->checkLoginStatus())
			{

				$band = $this->addeventview->getBandName();
				

				try{

					if($this->addeventview->didUserPressAddBandButton())
					{
						

						if($this->addeventmodel->CheckBandLength($band))
						{
							if($this->db->checkIfBandExist($band))
							{
								$this->db->addBand($band);
								$this->addeventview->successfulAddBand();

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
							$this->db->addBandToEvent($eventdropdownvalue,$banddropdownvalue);
							$this->addeventview->successfulAddBandToEvent();

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