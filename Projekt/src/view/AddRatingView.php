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

		//kontrollerar om användaren tryckt på lägga till betyg knappen.
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
						<fieldset id='fieldaddrating'>
							<legend>Lägga till nytt betyg till spelning med följande band</legend>
							$this->message
							<span style='white-space: nowrap'>Livespelning:</span>
							 <select name='dropdownpickevent'>";
							 foreach($eventbandlist->toArray() as $event)
							 {
							 	$contentString.= "<option value='". $event->getName()."'>".$event->getName()."</option>";
							 }
							 
							 $contentString .= "</select><input type='submit' name='$this->chooseeventbutton'  value='Välj livespelning'>";
							
							 
							 $contentString .= "
						</fieldset>
					</form>";

					$HTMLbody = "<div id='divaddrating'>
				<h1>Lägg till betyg till vald spelning med band</h1>
				<p><a href='?login'>Tillbaka</a></p>
				$contentString<br>
				" . $timedate . ".</div>";

				$this->echoHTML($HTMLbody);
			
			}

			public function ShowChosenEventRatingPage(EventBandList $eventbandlist, EventBandList $bandeventlist, GradeList $gradelist){

			
			// visa Lägga till event och band sidan.
				$timedate = $this->timedate->TimeAndDate();

					$contentString = 
					 "
					<form method=post >
						<fieldset id='fieldaddchosenrating'>
							<legend>Lägga till nytt betyg till spelning med följande band</legend>
							$this->message
							<span style='white-space: nowrap'>Livespelning:</span><br>
							 <select name='dropdownpickevent'>";
							 foreach($eventbandlist->toArray() as $event)
							 {
							 	$contentString.= "<option value='". $event->getName()."'>".$event->getName()."</option>";
							 }
							 
							 $contentString .= "</select>
							<input type='submit' name='$this->chooseothereventbutton'  value='Välj en annan livespelning'><br>
							<span style='white-space: nowrap'>Band:</span><br>
							<select name='dropdownpickband'>";
							 foreach($bandeventlist->toArray() as $band)
							 {
							 	$contentString.= "<option value='". $band->getName()."'>".$band->getName()."</option>";
							 }
							 
							 $contentString .= "</select><br>
							 <span style='white-space: nowrap'>Betyg:</span><br>
							<select name='$this->dropdownpickgrade'>";
							 foreach($gradelist->toArray() as $grade)
							 {
							 	$contentString.= "<option value='". $grade->getGrade()."'>".$grade->getGrade()."</option>";
							 }
							 
							 $contentString .= "</select><br>
							Skicka: <input type='submit' name='$this->creategradebutton'  value='Lägg till Betyg'>
						</fieldset>
					</form>";

					$HTMLbody = "<div id='divaddchosenrating'>
				<h1>Lägg till betyg till vald spelning med band</h1>
				<p><a href='?login'>Tillbaka</a></p>
				$contentString<br>
				" . $timedate . ".</div>";

				$this->echoHTML($HTMLbody);
			
			}


			public function ShowAllEventsWithBandGrades(ShowEventList $showeventlist)
			{

			
			
			


			// visa Lägga till event och band sidan.
				
					$contentString = 
					 "
					<form method=post >
						
							<h3>Visar Alla event</h3>";
							
							 foreach($showeventlist->toArray() as $event)
							 {
							 	
							 	$contentString .= "
								<fieldset id='fieldshowall'><span id='spangradient'  style='white-space: nowrap'>Livespelning:</span>
								";
							 	$contentString.= "<p id='pgradient'>".$event->getEvent()."</p>";
							 	$contentString .= "
								<span id='spangradient' style='white-space: nowrap'>Band:<span>
								";
							 	$contentString.= "<p id='pgradient'>".$event->getBand()."</p>";
							 	$contentString .= "
							 	<span id='spangradient' style='white-space: nowrap'>Betyg:</span>
								";
								$contentString.= "<p id='pgradient'>".$event->getGrade()."</p>";
								$contentString .= "
							 	<span id='spangradient' style='white-space: nowrap'>Användare:</span>
								";
								$contentString.= "<p id='pgradient'>".$event->getUser()."</p>";
								$contentString .= "</fieldset>";
							 }
							 
							 $contentString .= "</form>";

					

					$HTMLbody = "<div id='divshowall'>
				<h1>Visar alla events med band och betyg</h1>
				<p><a href='?login'>Tillbaka</a></p>
				$contentString
				</div>";

				$this->echoHTML($HTMLbody);


			}

			public function showMessage($message)
			{
				$this->message = "<p>" . $message . "</p>";
			}

				// Visar Lägga till event-meddelande.
			public function successfulAddGradeToEventWithBand()
			{
				$this->showMessage("Betyget har lagts till livespelning med band!");
			}





	}