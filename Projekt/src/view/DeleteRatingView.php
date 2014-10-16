<?php

	require_once("common/HTMLView.php");
	require_once("TimeDate.php");

	class DeleteRatingView extends HTMLView {

		private $timedate;
		private $message = "";

		private $deletegradebutton = "deletegradebutton";
		private $pickeddeleteid = "pickeddeleteid";


		public function __construct(){

				$this->timedate = new TimeDate();
		}


		public function didUserPressDeleteGradeButton()
		{
			if(isset($_POST[$this->deletegradebutton]))
			{
				return true;
			}
			return false;
		}

		public function getDeletePickedValue()
		{
			if(isset($_POST[$this->pickeddeleteid]))
			{
				return $_POST[$this->pickeddeleteid];
			}
			return false;
		}


		public function ShowDeleteRatingPage(DeleteGradeList $deletegradelist)
		{
			
			$timedate = $this->timedate->TimeAndDate();

			// visa ta bort betyg sidan.
				
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
	
					$HTMLbody = "
				<h1>Ta bort betyg till vald spelning med band</h1>
				<p><a href='?login'>Tillbaka</a></p>
				$contentString<br>
				" . $timedate. ".";

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