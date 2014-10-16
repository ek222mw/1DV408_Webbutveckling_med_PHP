<?php

	require_once("common/HTMLView.php");
	require_once("TimeDate.php");
	
	class AddRatingView extends HTMLView {

		
		private $message = "";
		private $timedate;

		private $creategradebutton = "creategradebutton";
		private $dropdownpickgrade = "dropdownpickgrade";
		private $chooseeventbutton = "chooseeventbutton";
		private $chooseothereventbutton = "chooseothereventbutton";

		public function __construct(){

				
				$this->timedate = new TimeDate();
		}

		public function didUserPressAddGradeButton(){

			if(isset($_POST[$this->creategradebutton]))
			{
				return true;
			}
			return false;
		}

		

		public function pickedGradeDropdownValue(){

			if(isset($_POST[$this->dropdownpickgrade]))
			{
				return $_POST[$this->dropdownpickgrade];
			}
			return false;

		}

		public function didUserPressChooseGradeEvent()
		{
			if(isset($_POST[$this->chooseeventbutton]))
			{
				return true;
			}
			return false;
			
		}

		public function didUserPressChooseOtherGradeEvent()
		{
			if(isset($_POST[$this->chooseothereventbutton]))
			{
				return true;
			}
			return false;
		}

		public function ShowAddRatingPage(EventBandList $eventbandlist){

			$timedate = $this->timedate->TimeAndDate();

			// visa Lägga till event och band sidan.
				
					$contentString = 
					 "
					<form method=post >
						<fieldset>
							<legend>Lägga till nytt betyg till spelning med följande band</legend>
							$this->message
							Event:
							 <select name='dropdownpickevent'>";
							 foreach($eventbandlist->toArray() as $event)
							 {
							 	$contentString.= "<option value='". $event->getName()."'>".$event->getName()."</option>";
							 }
							 
							 $contentString .= "</select><input type='submit' name='chooseeventbutton'  value='Välj Event'>";
							
							 
							 $contentString .= "
						</fieldset>
					</form>";

					$HTMLbody = "
				<h1>Lägg till betyg till vald spelning med band</h1>
				<p><a href='?login'>Tillbaka</a></p>
				$contentString<br>
				" . $timedate . ".";

				$this->echoHTML($HTMLbody);
			
			}

			public function ShowChosenEventRatingPage(EventBandList $eventbandlist, EventBandList $bandeventlist, GradeList $gradelist){

			
			// visa Lägga till event och band sidan.
				$timedate = $this->timedate->TimeAndDate();

					$contentString = 
					 "
					<form method=post >
						<fieldset>
							<legend>Lägga till nytt betyg till spelning med följande band</legend>
							$this->message
							Event:
							 <select name='dropdownpickevent'>";
							 foreach($eventbandlist->toArray() as $event)
							 {
							 	$contentString.= "<option value='". $event->getName()."'>".$event->getName()."</option>";
							 }
							 
							 $contentString .= "</select>
							<input type='submit' name='chooseothereventbutton'  value='Välj Annat Event'><br>
							Band:
							<select name='dropdownpickband'>";
							 foreach($bandeventlist->toArray() as $band)
							 {
							 	$contentString.= "<option value='". $band->getName()."'>".$band->getName()."</option>";
							 }
							 
							 $contentString .= "</select><br>
							 Betyg:
							<select name='dropdownpickgrade'>";
							 foreach($gradelist->toArray() as $grade)
							 {
							 	$contentString.= "<option value='". $grade->getGrade()."'>".$grade->getGrade()."</option>";
							 }
							 
							 $contentString .= "</select><br>
							Skicka: <input type='submit' name='creategradebutton'  value='Lägg till Betyg'>
						</fieldset>
					</form>";

					$HTMLbody = "
				<h1>Lägg till betyg till vald spelning med band</h1>
				<p><a href='?login'>Tillbaka</a></p>
				$contentString<br>
				" . $timedate . ".";

				$this->echoHTML($HTMLbody);
			
			}


			public function ShowAllEventsWithBandGrades(ShowEventList $showeventlist)
			{

			
			
			$timedate = $this->timedate->TimeAndDate();


			// visa Lägga till event och band sidan.
				
					$contentString = 
					 "
					<form method=post >
						
							<legend>Visar Alla event</legend><br>";
							
							 foreach($showeventlist->toArray() as $event)
							 {
							 	
							 	$contentString .= "
								<fieldset><br>Event:
								";
							 	$contentString.= "<p>".$event->getEvent()."</p>";
							 	$contentString .= "
								<br>Band:
								";
							 	$contentString.= "<p>".$event->getBand()."</p>";
							 	$contentString .= "
							 	<br>Betyg:
								";
								$contentString.= "<p>".$event->getGrade()."</p>";
								$contentString .= "
							 	<br>Användare:
								";
								$contentString.= "<p>".$event->getUser()."</p>";
								$contentString .= "</fieldset><br>";
							 }
							 
							 $contentString .= "</form>";

					

					$HTMLbody = "
				<h1>Visar alla events med band och betyg</h1>
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
			public function successfulAddGradeToEventWithBand()
			{
				$this->showMessage("Betyget har lagts till event med band!");
			}





	}