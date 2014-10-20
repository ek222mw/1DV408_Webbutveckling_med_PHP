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


			
			


			// visa Editera betyg sidan.
				
					$contentString = "$this->message";
							 foreach($gradelist->toArray() as $grade)
							 {
							 	$contentString .=  "<form method=post >";
							 	$contentString .= "
								<fieldset id='fieldeditrating'><legend>Editera betyg</legend><br>
								<span id='spangradient' style='white-space: nowrap'>LiveSpelning:</span>";
							 	$contentString.= "<p id='pgradient'>".$grade->getEvent()."</p>";
							 	$contentString .= "<span id='spangradient' style='white-space: nowrap'>Band:</span>";
							 	$contentString.="<p id='pgradient'>".$grade->getBand()."</p>";
							 	$contentString .= "<span id='spangradient' style='white-space: nowrap'>Betyg:</span>";
							 	$contentString.= "<p id='pgradient'>".$grade->getGrade()."</p>"; 
							 	$contentString.= "<input type='hidden' name='$this->pickededitid' value='". $grade->getID() ."'>";
							 	$contentString.= "<input type='submit' name='$this->editbutton' value='Editera'>";
							 	$contentString .= "</fieldset>";
							 	$contentString .= "</form>";
							 }
							 

					$HTMLbody = "<div id='diveditrating'>
				<h1>Editera betyg till vald spelning med band</h1>
				<p><a href='?login'>Tillbaka</a></p>
				$contentString<br>
				</div>";

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
								<fieldset id='fieldchoseneditrating'><br><span id='spangradient' style='white-space: nowrap'>
								LiveSpelning</span>";
							 	$contentString.= "<p id='pgradient'>".$editgrade->getEvent()."</p>";
							 	$contentString .= "<span id='spangradient' style='white-space: nowrap'>Band:</span>";
							 	$contentString.="<p id='pgradient'>".$editgrade->getBand()."</p>";
							 	$contentString .= "<span id='spangradient' style='white-space: nowrap'>Betyg:</span>";
							 	$contentString.="<p id='pgradient'>".$editgrade->getGrade()."</p>";
							 	$contentString.= "<input type='hidden' name='$this->pickedid' value='". $editgrade->getID() ."'>";
							 	
							 	
							 	
							 }
							 $contentString .= "<span id='spangradient' style='white-space: nowrap'>Nytt betyg:</span><br>";
							 $contentString.= "<select name='dropdownneweditgrade'>";
							 foreach($gradelist->toArray() as $grade)
							 {
							 	
							 	$contentString.="<option value='". $grade->getGrade()."'>".$grade->getGrade()."</option>";
							 	 
							 }
							 $contentString.="</select>";

							 $contentString.= "<input type='submit' name='$this->editgradebutton'  value='Editera Betyg'>";
							 $contentString .= "</fieldset>";
							 $contentString .= "</form>";

					$HTMLbody = "<div id='divchoseneditrating'>
				<h1>Editera betyg till vald spelning med band</h1>
				<p><a href='?editrating'>Tillbaka</a></p>
				$contentString
				</div>";

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