<?php

	require_once("DBDetails.php");

	class AddBandEventModel{

			private $db;

			public function __construct($userAgent){

				$this->sessionUserAgent = $userAgent;
				$this->db = new DBDetails();
			}


			public function checkIfEventExist($inputevent,$inputband)
			{

				if($this->db->checkIfEventExist($inputevent,$inputband))
				{
					return true;
				}
				
			}

			public function AddEvent($event,$band)
			{
				$this->db->addEvent($event,$band);
			}

			public function CheckBothAddEventBandInput($event,$band){

			if(mb_strlen($event) < 1 && mb_strlen($band) < 1){

				// Kasta undantag.
				throw new Exception("Spelningen har för få tecken. Minst 1 tecken<br>Bandet har för få tecken. Minst 1 tecken");
				
			}
			return true;

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

