<?php


	class TimeDate{

		public function __construct()
		{

		}

		public function TimeAndDate()
		{
			// Variabler
			$weekDay = ucfirst(utf8_encode(strftime("%A"))); // Hittar veckodagen, tillåter Å,Ä,Ö och gör den första bokstaven stor.
			$month = ucfirst(strftime("%B")); // Hittar månaden och gör den första bokstaven stor.
			$year = strftime("%Y");
			$time = strftime("%H:%M:%S");
			$format = '%e'; // Fixar formatet så att datumet anpassas för olika platformar. Lösning hittade på http://php.net/manual/en/function.strftime.php
			
			if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
			{
    				$format = preg_replace('#(?<!%)((?:%%)*)%e#', '\1%#d', $format);
			}
			
			$datetime =   strftime('' . $weekDay . ', den ' . $format . ' '. $month . ' år ' . $year . '. Klockan är [' . $time . ']');

			return $datetime;

		}

	}
