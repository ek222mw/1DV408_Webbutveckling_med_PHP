<?php

	require_once("common/HTMLView.php");
	require_once("TimeDate.php");

	class EditRatingView extends HTMLView {


		private $timedate;
		private $message = "";

		private $editbutton = "editbutton";
		private $pickededitid = "pickededitid";
		private $pickedid = "pickedid";
		private $dropdownneweditgrade = "dropdownneweditgrade";
		private $editgradebutton = "editgradebutton";



		public function __construct(){

				$this->timedate = new TimeDate();
		}

		public function didUserPressEditPickedButton()
		{
			if(isset($_POST[$this->editbutton]))
			{
				return true;
			}
			return false;
		}

		public function getEditPickedButtonValue()
		{
			if(isset($_POST[$this->pickededitid]))
			{
				return $_POST[$this->pickededitid];
			}
			return false;
		}

		public function getEditPickedButtonValueSaved()
		{
			if(isset($_POST[$this->pickedid]))
			{
				return $_POST[$this->pickedid];
			}
			return false;
		}



		public function getDropdownPickedEditGrade()
		{
			if(isset($_POST[$this->dropdownneweditgrade]))
			{
				return $_POST[$this->dropdownneweditgrade];
			}
			return false;
		}

		public function didUserPressEditGradeButton()
		{
			if(isset($_POST[$this->editgradebutton]))
			{
				return true;
			}
			return false;
		}
		

		public function ShowEditRatingPage(EditGradeList $gradelist)
		{


			$timedate = $this->timedate->TimeAndDate();
			


			// visa Editera betyg sidan.
				
					$contentString = "$this->message";
							 foreach($gradelist->toArray() as $grade)
							 {
							 	$contentString .=  "<form method=post >";
							 	$contentString .= "
								<fieldset><legend>Editera betyg</legend><br>Event";
							 	$contentString.= "<p>".$grade->getEvent()."</p>";
							 	$contentString .= "Band";
							 	$contentString.="<p>".$grade->getBand()."</p>";
							 	$contentString .= "Betyg:";
							 	$contentString.= "<p>".$grade->getGrade()."</p>"; 
							 	$contentString.= "<input type='hidden' name='pickededitid' value='". $grade->getID() ."'>";
							 	$contentString.= "<input type='submit' name='editbutton' value='Editera'>";
							 	$contentString .= "</fieldset><br>";
							 	$contentString .= "</form>";
							 }
							 

					$HTMLbody = "
				<h1>Editera betyg till vald spelning med band</h1>
				<p><a href='?login'>Tillbaka</a></p>
				$contentString<br>
				" . $timedate . ".";

				$this->echoHTML($HTMLbody);
		}


		public function ShowChosenEditRatingPage(EditGradeList $editgradelist, GradeList $gradelist)
		{
			
			
			$timedate = $this->timedate->TimeAndDate();

			// visa editerings sidan med valt betyg att ändra.
				
					$contentString = 
					 "
					<form method=post >
						
							<legend>Editera betyg</legend><br>$this->message";
							
							 foreach($editgradelist->toArray() as $editgrade)
							 {
							 	
							 	$contentString .= "
								<fieldset><br>Event";
							 	$contentString.= "<p>".$editgrade->getEvent()."</p>";
							 	$contentString .= "Band";
							 	$contentString.="<p>".$editgrade->getBand()."</p>";
							 	$contentString .= "Betyg";
							 	$contentString.="<p>".$editgrade->getGrade()."</p>";
							 	$contentString.= "<input type='hidden' name='pickedid' value='". $editgrade->getID() ."'>";
							 	
							 	
							 	
							 }
							 $contentString .= "Nytt betyg<br>";
							 $contentString.= "<select name='dropdownneweditgrade'>";
							 foreach($gradelist->toArray() as $grade)
							 {
							 	
							 	$contentString.="<option value='". $grade->getGrade()."'>".$grade->getGrade()."</option>";
							 	 
							 }
							 $contentString.="</select>";

							 $contentString.= "<input type='submit' name='editgradebutton'  value='Editera Betyg'>";
							 $contentString .= "</fieldset><br>";
							 $contentString .= "</form>";

					$HTMLbody = "
				<h1>Editera betyg till vald spelning med band</h1>
				<p><a href='?editrating'>Tillbaka</a></p>
				$contentString<br>
				" . $timedate . ".";

				$this->echoHTML($HTMLbody);
		}

		public function showMessage($message)
		{
			$this->message = "<p>" . $message . "</p>";
		}

		public function successfulEditGradeToEventWithBand()
		{
				$this->showMessage("Betyget har editerats!");
		}



	}