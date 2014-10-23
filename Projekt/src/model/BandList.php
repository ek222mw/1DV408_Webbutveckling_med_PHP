<?php

require_once("Band.php");

	class BandList{


		private $bands;

		//Lägger in privata varibeln bands värden i en array.
		public function __construct(){

			$this->bands = array();
		}

		//Lägger in, in parametern band i arrayen.
		public function add(Band $band){

			$this->bands[] = $band;

		}

		//Returnerar arrayen.
		public function toArray(){

			return $this->bands;

		}


	}