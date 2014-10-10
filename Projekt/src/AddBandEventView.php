<?php

	require_once 'common/HTMLView.php';

	class AddBandEventView extends HTMLView{

		private $loginmodel;
		private $message = "";

		public function __construct(LoginModel $model){

				$this->loginmodel = $model;
		}

		public function getEventName(){

			if(isset($_POST['createevent']))
			{
				return $_POST['createevent'];
			}
			return false;
		}

		public function getBandName(){

			if(isset($_POST['createband']))
			{
				return $_POST['createband'];
			}
			return false;
		}

		public function didUserPressAddEventButton(){

			if(isset($_POST['createeventbutton']))
			{
				return true;
			}
			return false;

		}

		public function didUserPressAddBandToEventButton()
		{
				if(isset($_POST['createbandeventbutton']))
				{
					return true;
				}
			return false;

		}

		public function didUserPressAddBandButton()
		{

			if(isset($_POST['createbandbutton']))
			{
				return true;
			}
			return false;

		}

		public function pickedEventDropdownValue(){

			if(isset($_POST['dropdownpickevent']))
			{
				return $_POST['dropdownpickevent'];
			}
			return false;
		}

		public function pickedBandDropdownValue(){

			if(isset($_POST['dropdownpickband']))
			{
				return $_POST['dropdownpickband'];
			}
			return false;

		}


		public function ShowAddEventPage(){

			// Variabler
			$weekDay = ucfirst(utf8_encode(strftime("%A"))); // Hittar veckodagen, tillåter Å,Ä,Ö och gör den första bokstaven stor.
			$month = ucfirst(strftime("%B")); // Hittar månaden och gör den första bokstaven stor.
			$year = strftime("%Y");
			$time = strftime("%H:%M:%S");
			$format = '%e'; // Fixar formatet så att datumet anpassas för olika platformar. Lösning hittade på http://php.net/manual/en/function.strftime.php
			
			


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

					if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
					{
    					$format = preg_replace('#(?<!%)((?:%%)*)%e#', '\1%#d', $format);
					}

					$HTMLbody = "
				<h1>Skapa nytt band</h1>
				<p><a href='?login'>Tillbaka</a></p>
				$contentString<br>
				" . strftime('' . $weekDay . ', den ' . $format . ' '. $month . ' år ' . $year . '. Klockan är [' . $time . ']') . ".";

				$this->echoHTML($HTMLbody);
			}


			public function ShowAddBandPage(){

				// Variabler
			$weekDay = ucfirst(utf8_encode(strftime("%A"))); // Hittar veckodagen, tillåter Å,Ä,Ö och gör den första bokstaven stor.
			$month = ucfirst(strftime("%B")); // Hittar månaden och gör den första bokstaven stor.
			$year = strftime("%Y");
			$time = strftime("%H:%M:%S");
			$format = '%e'; // Fixar formatet så att datumet anpassas för olika platformar. Lösning hittade på http://php.net/manual/en/function.strftime.php
			
			


			// visa Lägga till event sidan.
				
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

					if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
					{
    					$format = preg_replace('#(?<!%)((?:%%)*)%e#', '\1%#d', $format);
					}

					$HTMLbody = "
				<h1>Skapa nytt Band</h1>
				<p><a href='?login'>Tillbaka</a></p>
				$contentString<br>
				" . strftime('' . $weekDay . ', den ' . $format . ' '. $month . ' år ' . $year . '. Klockan är [' . $time . ']') . ".";

				$this->echoHTML($HTMLbody);



			}




			public function ShowAddBandToEventPage(EventList $eventlist, BandList $bandlist){

			// Variabler
			$weekDay = ucfirst(utf8_encode(strftime("%A"))); // Hittar veckodagen, tillåter Å,Ä,Ö och gör den första bokstaven stor.
			$month = ucfirst(strftime("%B")); // Hittar månaden och gör den första bokstaven stor.
			$year = strftime("%Y");
			$time = strftime("%H:%M:%S");
			$format = '%e'; // Fixar formatet så att datumet anpassas för olika platformar. Lösning hittade på http://php.net/manual/en/function.strftime.php
			
			


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
							 	$contentString.= "<option value='". $event->getID()."'>".$event->getName()."</option>";
							 }
							 
							 $contentString .= "</select>
							 <br>
							Band:
							<select name='dropdownpickband'>";
							 foreach($bandlist->toArray() as $band)
							 {
							 	$contentString.= "<option value='". $band->getID()."'>".$band->getName()."</option>";
							 }
							 
							 $contentString .= "</select><br>
							Skicka: <input type='submit' name='createbandeventbutton'  value='Lägg till'>
						</fieldset>
					</form>";

					if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
					{
    					$format = preg_replace('#(?<!%)((?:%%)*)%e#', '\1%#d', $format);
					}

					$HTMLbody = "
				<h1>Lägg till band till vald spelning</h1>
				<p><a href='?login'>Tillbaka</a></p>
				$contentString<br>
				" . strftime('' . $weekDay . ', den ' . $format . ' '. $month . ' år ' . $year . '. Klockan är [' . $time . ']') . ".";

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

