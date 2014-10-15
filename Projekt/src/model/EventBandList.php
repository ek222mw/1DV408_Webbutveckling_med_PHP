<?php

	require_once("EventBand.php");

	class EventBandList{

		
		private $eventbands;

		public function __construct(){

			$this->eventbands = array();
		}

		public function add(EventBand $eventband){

			$this->eventbands[] = $eventband;

		}

		public function toArray(){

			return $this->eventbands;

		}


	



	}