<?php

	require_once("common/HTMLView.php");
	

	//Ärver HTMLView
	class EditRatingView extends HTMLView {


		
		private $message = "";

		private $editbutton = "editbutton";
		private $pickededitid = "pickededitid";
		private $pickedid = "pickedid";
		private $dropdownneweditgrade = "dropdownneweditgrade";
		private $editgradebutton = "editgradebutton";


		
		public function __construct(){

				
		}

		//Kollar om användaren tryckt på vald editeringsknapp, returnera sant annars falskt.
		public function didUserPressEditPickedButton()
		{
			if(isset($_POST[$this->editbutton]))
			{
				return true;
			}
			return false;
		}

		//Kollar om användaren valt ett värde i inputen, om så returnera värdet annars falskt.
		public function getEditPickedValue()
		{
			if(isset($_POST[$this->pickededitid]))
			{
				return $_POST[$this->pickededitid];
			}
			return false;
		}

		//Kollar om användaren valt ett värde i inputen, om så returnera värdet annars falskt.
		public function getEditPickedValueSaved()
		{
			if(isset($_POST[$this->pickedid]))
			{
				return $_POST[$this->pickedid];
			}
			return false;
		}


		//Kollar om användaren valt ett värde i editeringsdropdownen, returnera värdet annars falskt.
		public function getDropdownPickedEditGrade()
		{
			if(isset($_POST[$this->dropdownneweditgrade]))
			{
				return $_POST[$this->dropdownneweditgrade];
			}
			return false;
		}

		//Kollar om användaren tryckt på editera betyg knappen, returnera sant annars falskt.
		public function didUserPressEditGradeButton()
		{
			if(isset($_POST[$this->editgradebutton]))
			{
				return true;
			}
			return false;
		}
		
		//Visar editera betyg formuläret.
		public function ShowEditRatingPage(EditGradeList $gradelist)
		{

				
			$contentString = "$this->message";
			foreach($gradelist->toArray() as $grade)
			{
			$contentString .=  "<form method=post >";
			$contentString .= "
			<fieldset class='fieldeditrating'><legend>Editera betyg</legend><br>
			<span class='spangradient' style='white-space: nowrap'>LiveSpelning:</span>";
			$contentString.= "<p class='pgradient'>".$grade->getEvent()."</p>";
			$contentString .= "<span class='spangradient' style='white-space: nowrap'>Band:</span>";
			$contentString.="<p class='pgradient'>".$grade->getBand()."</p>";
			$contentString .= "<span class='spangradient' style='white-space: nowrap'>Betyg:</span>";
			$contentString.= "<p class='pgradient'>".$grade->getGrade()."</p>"; 
			$contentString.= "<input type='hidden' name='$this->pickededitid' value='". $grade->getID() ."'>";
			$contentString.= "<input type='submit' name='$this->editbutton' value='Editera'>";
			$contentString .= "</fieldset>";
			$contentString .= "</form>";
			}
							 

			$HTMLbody = "<div class='diveditrating'>
			<h1>Editera betyg till vald spelning med band</h1>
			<p><a href='?login'>Tillbaka</a></p>
			$contentString<br>
			</div>";

			$this->echoHTML($HTMLbody);
		}

		// visa editerings formuläret med valt betyg att ändra.
		public function ShowChosenEditRatingPage(EditGradeList $editgradelist, GradeList $gradelist)
		{
			
			
			

			
				
			$contentString = "
			<form method=post >
			<legend>Editera betyg</legend><br>$this->message";
			foreach($editgradelist->toArray() as $editgrade)
			{
							 	
				$contentString .= "
				<fieldset class='fieldchoseneditrating'><br><span class='spangradient' style='white-space: nowrap'>
				LiveSpelning</span>";
				$contentString.= "<p class='pgradient'>".$editgrade->getEvent()."</p>";
				$contentString .= "<span class='spangradient' style='white-space: nowrap'>Band:</span>";
				$contentString.="<p class='pgradient'>".$editgrade->getBand()."</p>";
				$contentString .= "<span class='spangradient' style='white-space: nowrap'>Betyg:</span>";
				$contentString.="<p class='pgradient'>".$editgrade->getGrade()."</p>";
				$contentString.= "<input type='hidden' name='$this->pickedid' value='". $editgrade->getID() ."'>";	
			}

			$contentString .= "<span class='spangradient' style='white-space: nowrap'>Nytt betyg:</span><br>";
			$contentString.= "<select name='dropdownneweditgrade'>";

			foreach($gradelist->toArray() as $grade)
			{
							 	
				$contentString.="<option value='". $grade->getGrade()."'>".$grade->getGrade()."</option>";
							 	 
			}

			$contentString.="</select>";
			$contentString.= "<input type='submit' name='$this->editgradebutton'  value='Editera Betyg'>";
			$contentString .= "</fieldset>";
			$contentString .= "</form>";

			$HTMLbody = "<div class='divchoseneditrating'>
			<h1>Editera betyg till vald spelning med band</h1>
			<p><a href='?editrating'>Tillbaka</a></p>
			$contentString
			</div>";

			$this->echoHTML($HTMLbody);
		}

		//Lägger in, inparameterns sträng i privata variabeln message som sedan skickas till formulären.
		public function showMessage($message)
		{
			$this->message = "<p>" . $message . "</p>";
		}

		//Lägger in lyckat editera betyg meddelande i funktionen showMessage.
		public function successfulEditGradeToEventWithBand()
		{
				$this->showMessage("Betyget har editerats!");
		}



	}