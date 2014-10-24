<?php

	require_once("common/HTMLView.php");
	

	//Ärver HTMLView.
	class AddBandEventView extends HTMLView{

		
		private $message = "";

		private $createevent = "createevent";
		private $createband = "createband";
		private $createeventbutton = "createeventbutton";
		private $createbandeventbutton = "createbandeventbutton";
		private $createbandbutton = "createbandbutton";
		private $dropdownpickevent = "dropdownpickevent";
		private $dropdownpickband = "dropdownpickband";

		
		public function __construct(){

			
				
		}

		//Om satt så returnera livespelningsnamnet annars returnera falskt.
		public function getEventName(){

			if(isset($_POST[$this->createevent]))
			{
				return $_POST[$this->createevent];
			}
			return false;
		}

		//Om satt så returnera bandnamnet annars returnera falskt.
		public function getBandName(){

			if(isset($_POST[$this->createband]))
			{
				return $_POST[$this->createband];
			}
			return false;
		}

		//Kontrollerar om användaren tryckt på lägga till livespelning knappen, returnera sant annars falskt.
		public function didUserPressAddEventButton(){

			if(isset($_POST[$this->createeventbutton]))
			{
				return true;
			}
			return false;

		}

		//Kontrollerar om användaren tryckt på lägga till band till livespelning, returnera sant annars falskt.
		public function didUserPressAddBandToEventButton()
		{
				if(isset($_POST[$this->createbandeventbutton]))
				{
					return true;
				}
			return false;

		}

		//Kontrollerar om användaren tryckt på lägga till band knappen,returnera sant annars falskt. 
		public function didUserPressAddBandButton()
		{

			if(isset($_POST[$this->createbandbutton]))
			{
				return true;
			}
			return false;

		}

		//Om satt så returnera valt livespelningsdropdown värde, annars falskt.
		public function pickedEventDropdownValue(){

			if(isset($_POST[$this->dropdownpickevent]))
			{
				return $_POST[$this->dropdownpickevent];
			}
			return false;
		}

		//Om satt så returnera valt banddropdown värde, annars falskt.
		public function pickedBandDropdownValue(){

			if(isset($_POST[$this->dropdownpickband]))
			{
				return $_POST[$this->dropdownpickband];
			}
			return false;

		}

		//Visar lägga till livespelnings forumläret.
		public function ShowAddEventPage(){

					
				
					$contentString = 
					 "
					<form method=post >
						<fieldset class='fieldaddevent'>
							<legend>Lägga till ny livespelning - Skriv in ny livespelning</legend>
							$this->message
							<span style='white-space: nowrap'>Livespelning:</span> <input type='text' name='$this->createevent'><br>
							<span style='white-space: nowrap'>Skicka:</span> <input type='submit' name='$this->createeventbutton'  value='Skapa'>
						</fieldset>
					</form>";

					$HTMLbody = "<div class='divaddevent'>
					<h1>Skapa nytt band</h1>
					<p><a href='?login'>Tillbaka</a></p>
					$contentString<br>
					</div>";

					$this->echoHTML($HTMLbody);
			}

			//Visar lägga till band formuläret.
			public function ShowAddBandPage(){

					
				
					$contentString = 
					 "
					<form method=post >
						<fieldset class='fieldaddband'>
							<legend>Lägga till nytt band - Skriv in band</legend>
							$this->message
							<span style='white-space: nowrap'>Band:</span><input type='text' name='$this->createband'><br>
							<span style='white-space: nowrap'>Skicka:</span> <input type='submit' name='$this->createbandbutton'  value='Skapa'>
						</fieldset>
					</form>";

					$HTMLbody = "<div class='divaddband'>
					<h1>Skapa nytt Band</h1>
					<p><a href='?login'>Tillbaka</a></p>
					$contentString<br>
					</div>";

					$this->echoHTML($HTMLbody);

			}



			//Visar lägga till band till livespelning formuläret.
			public function ShowAddBandToEventPage(EventList $eventlist, BandList $bandlist){

			
					
				
					$contentString = 
					 "
					<form method=post >
						<fieldset class='fieldaddbandevent'>
							<legend>Lägga till nytt band till spelning</legend>
							$this->message
							<span style='white-space: nowrap'>Livespelning:</span><br>
							 <select name='$this->dropdownpickevent'>";
							 foreach($eventlist->toArray() as $event)
							 {
							 	$contentString.= "<option value='". $event->getName()."'>".$event->getName()."</option>";
							 }
							 
							 $contentString .= "</select>
							 <br>
							<span style='white-space: nowrap'>Band:</span><br>
							<select name='$this->dropdownpickband'>";
							 foreach($bandlist->toArray() as $band)
							 {
							 	$contentString.= "<option value='". $band->getName()."'>".$band->getName()."</option>";
							 }
							 
							 $contentString .= "</select><br><br>
							<span style='white-space: nowrap'>Skicka:</span> <input type='submit' name='$this->createbandeventbutton'  value='Lägg till'>
						</fieldset>
					</form>";

					$HTMLbody = "<div class='divaddbandevent'>
					<h1>Lägg till band till vald spelning</h1>
					<p><a href='?login'>Tillbaka</a></p>
					$contentString<br>
					</div>";

					$this->echoHTML($HTMLbody);
			}

			//Lägger in, inparameterns sträng i privata variabeln message som sedan skickas till formulären.
			public function showMessage($message)
			{
				$this->message = "<p>" . $message . "</p>";
			}

			//Lägger in lyckat lägga till livespelningsmeddelande i funktionen showMessage.
			public function successfulAddEvent()
			{
				$this->showMessage("Livespelningen lades till!");
			}

			//Lägger in lyckat lägga till bandmeddelande i funktionen showMessage.
			public function successfulAddBand()
			{
				$this->showMessage("Bandet lades till!");
			}

			//Lägger in lyckat lägga till band till livespelning meddelande i funktionen showMessage.
			public function successfulAddBandToEvent()
			{
				$this->showMessage("Bandet har lagt tills i livespelningen");
			}

		


}

