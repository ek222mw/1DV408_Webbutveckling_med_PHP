<?php

	require_once 'common/HTMLView.php';

	class DeleteRatingView extends HTMLView {


		private $message = "";

		public function __construct(){

				
		}


		public function didUserPressDeleteGradeButton()
		{
			if(isset($_POST['deletegradebutton']))
			{
				return true;
			}
			return false;
		}

		public function getDeletePickedValue()
		{
			if(isset($_POST['pickeddeleteid']))
			{
				return $_POST['pickeddeleteid'];
			}
			return false;
		}


		public function ShowDeleteRatingPage(DeleteGradeList $deletegradelist)
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
					
							$this->message";
							
							 foreach($deletegradelist->toArray() as $grade)
							 {
							 	$contentString .=  "<form method=post >";
							 	$contentString .= "
								<fieldset><legend>Ta bort betyg</legend><br>Event";
							 	$contentString.= "<p>".$grade->getEvent()."</p>";
							 	$contentString .= "Band";
							 	$contentString.="<p>".$grade->getBand()."</p>";
							 	$contentString .= "Betyg:";
							 	$contentString.= "<p>".$grade->getGrade()."</p>"; 
							 	$contentString.= "<input type='hidden' name='pickeddeleteid' value='". $grade->getID() ."'>";
							 	$contentString.= "<input type='submit' name='deletegradebutton' value='Ta bort betyg'>";
							 	$contentString .= "</fieldset><br>";
							 	$contentString .= "</form>";
							 }
							 
							 

					if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
					{
    					$format = preg_replace('#(?<!%)((?:%%)*)%e#', '\1%#d', $format);
					}

					$HTMLbody = "
				<h1>Ta bort betyg till vald spelning med band</h1>
				<p><a href='?login'>Tillbaka</a></p>
				$contentString<br>
				" . strftime('' . $weekDay . ', den ' . $format . ' '. $month . ' år ' . $year . '. Klockan är [' . $time . ']') . ".";

				$this->echoHTML($HTMLbody);
		}

		public function showMessage($message)
		{
			$this->message = "<p>" . $message . "</p>";
		}

		public function successfulDeleteGradeToEventWithBand()
		{
				$this->showMessage("Betyget har tagits bort!");
		}


	}