<?php

	require_once("common/HTMLView.php");
	

	//Ärver HTMLView
	class DeleteRatingView extends HTMLView {

		
		private $message = "";

		private $deletegradebutton = "deletegradebutton";
		private $pickeddeleteid = "pickeddeleteid";

		
		public function __construct(){

				
		}

		//Kollar om användaren tryckt på ta bort betyg knappen, returnera sant annars falskt.
		public function didUserPressDeleteGradeButton()
		{
			if(isset($_POST[$this->deletegradebutton]))
			{
				return true;
			}
			return false;
		}

		//Kollar om användaren valt ett värde i inputen, returnera värdet annars falskt.
		public function getDeletePickedValue()
		{
			if(isset($_POST[$this->pickeddeleteid]))
			{
				return $_POST[$this->pickeddeleteid];
			}
			return false;
		}

		//Visar ta bort betyg forumläret.
		public function ShowDeleteRatingPage(DeleteGradeList $deletegradelist)
		{
			
			

			$contentString = "$this->message";
			foreach($deletegradelist->toArray() as $grade)
			{
				$contentString .=  "<form method=post >";
				$contentString .= "<fieldset class='fielddeleterating'><legend>Ta bort betyg</legend><br><span class='spangradient' style='white-space: nowrap'>
				Livespelning:</span>";
				$contentString.= "<p class='pgradient'>".$grade->getEvent()."</p>";
				$contentString .= "<span class='spangradient' style='white-space: nowrap'>Band:</span>";
				$contentString.="<p class='pgradient'>".$grade->getBand()."</p>";
				$contentString .= "<span class='spangradient' style='white-space: nowrap'>Betyg:</span>";
				$contentString.= "<p class='pgradient'>".$grade->getGrade()."</p>"; 
				$contentString.= "<input type='hidden' name='$this->pickeddeleteid' value='". $grade->getID() ."'>";
				$contentString.= "<input type='submit' name='$this->deletegradebutton' value='Ta bort betyg'>";
				$contentString .= "</fieldset>";
				$contentString .= "</form>";
			}
	
			$HTMLbody = "<div class='divdeletegrade'>
			<h1>Ta bort betyg till vald spelning med band</h1>
			<p><a href='?login'>Tillbaka</a></p>
			$contentString
			</div>";

			$this->echoHTML($HTMLbody);
		}

		//Lägger in, inparameterns sträng i privata variabeln message som sedan skickas till formulären.
		public function showMessage($message)
		{
			$this->message = "<p>" . $message . "</p>";
		}

		//Lägger in lyckat ta bort betyg meddelande i funktionen showMessage.
		public function successfulDeleteGradeToEventWithBand()
		{
				$this->showMessage("Betyget har tagits bort!");
		}


	}