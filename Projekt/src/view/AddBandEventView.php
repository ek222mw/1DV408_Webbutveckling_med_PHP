<?php

	require_once("common/HTMLView.php");
	require_once("TimeDate.php");

	class AddBandEventView extends HTMLView{

		private $timedate;
		private $message = "";

		private $createevent = "createevent";
		private $createband = "createband";
		private $createeventbutton = "createeventbutton";
		private $createbandeventbutton = "createbandeventbutton";
		private $createbandbutton = "createbandbutton";
		private $dropdownpickevent = "dropdownpickevent";
		private $dropdownpickband = "dropdownpickband";

		public function __construct(){

			$this->timedate = new TimeDate();
				
		}

		public function getEventName(){

			if(isset($_POST[$this->createevent]))
			{
				return $_POST[$this->createevent];
			}
			return false;
		}

		public function getBandName(){

			if(isset($_POST[$this->createband]))
			{
				return $_POST[$this->createband];
			}
			return false;
		}

		public function didUserPressAddEventButton(){

			if(isset($_POST[$this->createeventbutton]))
			{
				return true;
			}
			return false;

		}

		

		public function didUserPressAddBandToEventButton()
		{
				if(isset($_POST[$this->createbandeventbutton]))
				{
					return true;
				}
			return false;

		}

		public function didUserPressAddBandButton()
		{

			if(isset($_POST[$this->createbandbutton]))
			{
				return true;
			}
			return false;

		}

		public function pickedEventDropdownValue(){

			if(isset($_POST[$this->dropdownpickevent]))
			{
				return $_POST[$this->dropdownpickevent];
			}
			return false;
		}

		public function pickedBandDropdownValue(){

			if(isset($_POST[$this->dropdownpickband]))
			{
				return $_POST[$this->dropdownpickband];
			}
			return false;

		}


		public function ShowAddEventPage(){

			$timedate = $this->timedate->TimeAndDate();
			
			


			// visa Lägga till event sidan.
				
					$contentString = 
					 "
					<form method=post >
						<fieldset>
							<legend>Lägga till ny spelning - Skriv in plats och band</legend>
							$this->message
							Plats: <input type='text' name='createevent'><br>
							Skicka: <input type='submit' name='createeventbutton'  value='Skapa'>
						</fieldset>
					</form>";

					$HTMLbody = "
				<h1>Skapa nytt band</h1>
				<p><a href='?login'>Tillbaka</a></p>
				$contentString<br>
				" . $timedate . ".";

				$this->echoHTML($HTMLbody);
			}


			public function ShowAddBandPage(){

			
			
			$timedate = $this->timedate->TimeAndDate();


			// visa Lägga till band sidan.
				
					$contentString = 
					 "
					<form method=post >
						<fieldset>
							<legend>Lägga till nytt band - Skriv in band</legend>
							$this->message
							Band: <input type='text' name='createband'><br>
							Skicka: <input type='submit' name='createbandbutton'  value='Skapa'>
						</fieldset>
					</form>";

					$HTMLbody = "
				<h1>Skapa nytt Band</h1>
				<p><a href='?login'>Tillbaka</a></p>
				$contentString<br>
				" . $timedate . ".";

				$this->echoHTML($HTMLbody);



			}




			public function ShowAddBandToEventPage(EventList $eventlist, BandList $bandlist){

			
			$timedate = $this->timedate->TimeAndDate();

			// visa Lägga till event och band sidan.
				
					$contentString = 
					 "
					<form method=post >
						<fieldset>
							<legend>Lägga till nytt band till spelning</legend>
							$this->message
							Plats:
							 <select name='dropdownpickevent'>";
							 foreach($eventlist->toArray() as $event)
							 {
							 	$contentString.= "<option value='". $event->getName()."'>".$event->getName()."</option>";
							 }
							 
							 $contentString .= "</select>
							 <br>
							Band:
							<select name='dropdownpickband'>";
							 foreach($bandlist->toArray() as $band)
							 {
							 	$contentString.= "<option value='". $band->getName()."'>".$band->getName()."</option>";
							 }
							 
							 $contentString .= "</select><br>
							Skicka: <input type='submit' name='createbandeventbutton'  value='Lägg till'>
						</fieldset>
					</form>";

					$HTMLbody = "
				<h1>Lägg till band till vald spelning</h1>
				<p><a href='?login'>Tillbaka</a></p>
				$contentString<br>
				" . $timedate . ".";

				$this->echoHTML($HTMLbody);
			}

			public function showMessage($message)
			{
				$this->message = "<p>" . $message . "</p>";
			}

				// Visar Lägga till event-meddelande.
			public function successfulAddEvent()
			{
				$this->showMessage("Eventet lades till!");
			}

			public function successfulAddBand()
			{
				$this->showMessage("Bandet lades till!");
			}

			public function successfulAddBandToEvent()
			{
				$this->showMessage("Bandet har lagt tills i event");
			}

		


}

