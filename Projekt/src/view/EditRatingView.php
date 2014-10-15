<?php

	require_once 'common/HTMLView.php';

	class EditRatingView extends HTMLView {


		
		private $message = "";

		public function __construct(){

				
		}

		public function didUserPressEditPickedButton()
		{
			if(isset($_POST['editbutton']))
			{
				return true;
			}
			return false;
		}

		public function getEditPickedButtonValue()
		{
			if(isset($_POST['pickededitid']))
			{
				return $_POST['pickededitid'];
			}
			return false;
		}

		public function getEditPickedButtonValueSaved()
		{
			if(isset($_POST['pickedid']))
			{
				return $_POST['pickedid'];
			}
			return false;
		}



		public function getDropdownPickedEditGrade()
		{
			if(isset($_POST['dropdownneweditgrade']))
			{
				return $_POST['dropdownneweditgrade'];
			}
			return false;
		}

		public function didUserPressEditGradeButton()
		{
			if(isset($_POST['editgradebutton']))
			{
				return true;
			}
			return false;
		}
		

		public function ShowEditRatingPage(EditGradeList $gradelist)
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
							 
							 

					if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
					{
    					$format = preg_replace('#(?<!%)((?:%%)*)%e#', '\1%#d', $format);
					}

					$HTMLbody = "
				<h1>Editera betyg till vald spelning med band</h1>
				<p><a href='?login'>Tillbaka</a></p>
				$contentString<br>
				" . strftime('' . $weekDay . ', den ' . $format . ' '. $month . ' år ' . $year . '. Klockan är [' . $time . ']') . ".";

				$this->echoHTML($HTMLbody);
		}


		public function ShowChosenEditRatingPage(EditGradeList $editgradelist, GradeList $gradelist)
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

					if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
					{
    					$format = preg_replace('#(?<!%)((?:%%)*)%e#', '\1%#d', $format);
					}

					$HTMLbody = "
				<h1>Editera betyg till vald spelning med band</h1>
				<p><a href='?editrating'>Tillbaka</a></p>
				$contentString<br>
				" . strftime('' . $weekDay . ', den ' . $format . ' '. $month . ' år ' . $year . '. Klockan är [' . $time . ']') . ".";

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