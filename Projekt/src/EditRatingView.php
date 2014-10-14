<?php

	require_once 'common/HTMLView.php';

	class EditRatingView extends HTMLView {


		
		private $message = "";

		public function __construct(){

				
		}

		public function ShowEditRatingPage(GradeList $gradelist)
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
						
							<legend>Editera betyg</legend><br>";
							
							 foreach($gradelist->toArray() as $grade)
							 {
							 	
							 	$contentString .= "
								<fieldset><br>Event";
							 	$contentString.= "<p>".$grade->getEvent()."</p>";
							 	$contentString .= "Band";
							 	$contentString.="<p>".$grade->getBand()."</p>";
							 	$contentString .= "Betyg:";
							 	$contentString.= "<p>".$grade->getGrade()."</p>"; 
							 	$contentString.= "<button type='button' name='pickedid' value='". $grade->getID() ."'>Editera betyg </button>";
							 	$contentString .= "</fieldset><br>";
							 }
							 
							 $contentString .= "</form>";

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



	}