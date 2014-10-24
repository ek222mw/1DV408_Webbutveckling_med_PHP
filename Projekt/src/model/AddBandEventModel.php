<?php

	

	class AddBandEventModel{

			

		public function __construct(){

				
		}


		//Kontrollerar längden på det inmatade livespelningsvärdet. om giltigt returnera sant annars kasta undantag.	
		public function CheckEventLength($event){

			if(mb_strlen($event) < 1 || mb_strlen($event) > 50 ){

				// Kasta undantag.
				throw new Exception("Spelningen har för få tecken eller för många tecken. Måste vara mellan 1-50 tecken");
				
			}
			return true;

		}
		//Kontrollerar längden på det inmatade bandvärdet. Om giltigt returnera sant annars kasta undantag.
		public function CheckBandLength($band){

			if(mb_strlen($band) < 1 || mb_strlen($band) > 50 ){

				// Kasta undantag.
				throw new Exception("Bandet har för få tecken eller för många tecken. Måste vara mellan 1-50 tecken");
				
				
			}
			return true;
			
		}


	}

