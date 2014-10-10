<?php

require_once("Band.php");

	class BandList{


		private $bands;

		public function __construct(){

			$this->bands = array();
		}

		public function add(Band $band){

			$this->bands[] = $band;

		}

		public function toArray(){

			return $this->bands;

		}


	}