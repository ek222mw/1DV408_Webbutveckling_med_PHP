<?php

	require_once 'common/HTMLView.php';
	
	class AddRatingView extends HTMLView {

		private $loginmodel;
		private $message = "";

		public function __construct(LoginModel $model){

				$this->loginmodel = $model;
		}

		public function ShowAddRatingPage(){

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
							<legend>Lägga till nytt betyg för spelning - Ange spelning till vilket betyg</legend>
							$this->message
							Plats:
							 <select name='dropdownpickevent'>
							 <option value='101'>101</option>
							 <option value='102'>102</option>
							 <option value='103'>103</option>
							 <option value='104'>104</option>
							 <option value='105'>105</option>
							 <option value='106'>106</option>
							 <option value='107'>107</option>
							 <option value='108'>108</option>
							 <option value='109'>109</option>
							 <option value='110'>110</option>
							 </select>
							 <br>
							Betyg: <input type='number' name='createrating'><br>
							Skicka: <input type='submit' name='createratingbutton'  value='Skapa'>
						</fieldset>
					</form>";

					if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
					{
    					$format = preg_replace('#(?<!%)((?:%%)*)%e#', '\1%#d', $format);
					}

					$HTMLbody = "
				<h1>Skapa ny betyg för spelning</h1>
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
			public function successfulAddEvent()
			{
				$this->showMessage("Betyget lades till!");
			}





	}