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
								<fieldset id='fielddeleterating'><legend>Ta bort betyg</legend><br><span id='spangradient' style='white-space: nowrap'>
								Livespelning:</span>";
							 	$contentString.= "<p id='pgradient'>".$grade->getEvent()."</p>";
							 	$contentString .= "<span id='spangradient' style='white-space: nowrap'>Band:</span>";
							 	$contentString.="<p id='pgradient'>".$grade->getBand()."</p>";
							 	$contentString .= "<span id='spangradient' style='white-space: nowrap'>Betyg:</span>";
							 	$contentString.= "<p id='pgradient'>".$grade->getGrade()."</p>"; 
							 	$contentString.= "<input type='hidden' name='$this->pickeddeleteid' value='". $grade->getID() ."'>";
							 	$contentString.= "<input type='submit' name='$this->deletegradebutton' value='Ta bort betyg'>";
							 	$contentString .= "</fieldset>";
							 	$contentString .= "</form>";
							 }
	
					$HTMLbody = "<div id='divdeletegrade'>
				<h1>Ta bort betyg till vald spelning med band</h1>
				<p><a href='?login'>Tillbaka</a></p>
				$contentString
				</div>";

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