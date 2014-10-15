<?php

	require_once("DBDetails.php");

	class AddBandEventModel{

			private $db;

			public function __construct(){

				
				$this->db = new DBDetails();
			}


			
		public function CheckEventLength($event){

			if(mb_strlen($event) < 1){

				// Kasta undantag.
				throw new Exception("Spelningen har för få tecken. Minst 1 tecken");
				
			}
			return true;

		}

		public function CheckBandLength($band){

			if(mb_strlen($band) < 1){

				// Kasta undantag.
				throw new Exception("Bandet har för få tecken. Minst 1 tecken");
				
				
			}
			return true;
			
		}


	}

