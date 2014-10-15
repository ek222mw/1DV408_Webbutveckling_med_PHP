<?php

	require_once 'common/HTMLView.php';
	
	class AddRatingView extends HTMLView {

		private $loginmodel;
		private $message = "";

		public function __construct(LoginModel $model){

				$this->loginmodel = $model;
		}

		public function didUserPressAddGradeButton(){

			if(isset($_POST['creategradebutton']))
			{
				return true;
			}
			return false;
		}

		public function pickedGradeDropdownValue(){

			if(isset($_POST['dropdownpickgrade']))
			{
				return $_POST['dropdownpickgrade'];
			}
			return false;

		}

		public function didUserPressChooseGradeEvent()
		{
			if(isset($_POST['chooseeventbutton']))
			{
				return true;
			}
			return false;
			
		}

		public function didUserPressChooseOtherGradeEvent()
		{
			if(isset($_POST['chooseothereventbutton']))
			{
				return true;
			}
			return false;
		}

		public function ShowAddRatingPage(EventBandList $eventbandlist, EventBandList $bandeventlist, GradeList $gradelist){

			

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
							<legend>Lägga till nytt betyg till spelning med följande band</legend>
							$this->message
							Plats:
							 <select name='dropdownpickevent'>";
							 foreach($eventbandlist->toArray() as $event)
							 {
							 	$contentString.= "<option value='". $event->getName()."'>".$event->getName()."</option>";
							 }
							 
							 $contentString .= "</select>
							 Välj Event: <input type='submit' name='chooseeventbutton'  value='Välj Event'><br>
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
							
						</fieldset>
					</form>";

					if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
					{
    					$format = preg_replace('#(?<!%)((?:%%)*)%e#', '\1%#d', $format);
					}

					$HTMLbody = "
				<h1>Lägg till betyg till vald spelning med band</h1>
				<p><a href='?login'>Tillbaka</a></p>
				$contentString<br>
				" . strftime('' . $weekDay . ', den ' . $format . ' '. $month . ' år ' . $year . '. Klockan är [' . $time . ']') . ".";

				$this->echoHTML($HTMLbody);
			
			}

			public function ShowChosenEventRatingPage(EventBandList $eventbandlist, EventBandList $bandeventlist, GradeList $gradelist){

			

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
							<legend>Lägga till nytt betyg till spelning med följande band</legend>
							$this->message
							Plats:
							 <select name='dropdownpickevent'>";
							 foreach($eventbandlist->toArray() as $event)
							 {
							 	$contentString.= "<option value='". $event->getName()."'>".$event->getName()."</option>";
							 }
							 
							 $contentString .= "</select>
							 Välj Annat Event: <input type='submit' name='chooseothereventbutton'  value='Välj Annat Event'><br>
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

					if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
					{
    					$format = preg_replace('#(?<!%)((?:%%)*)%e#', '\1%#d', $format);
					}

					$HTMLbody = "
				<h1>Lägg till betyg till vald spelning med band</h1>
				<p><a href='?login'>Tillbaka</a></p>
				$contentString<br>
				" . strftime('' . $weekDay . ', den ' . $format . ' '. $month . ' år ' . $year . '. Klockan är [' . $time . ']') . ".";

				$this->echoHTML($HTMLbody);
			
			}


			public function ShowAllEventsWithBandGrades(ShowEventList $showeventlist)
			{

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

					if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
					{
    					$format = preg_replace('#(?<!%)((?:%%)*)%e#', '\1%#d', $format);
					}

					$HTMLbody = "
				<h1>Visar alla events med band och betyg</h1>
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
			public function successfulAddGradeToEventWithBand()
			{
				$this->showMessage("Betyget har lagts till event med band!");
			}





	}