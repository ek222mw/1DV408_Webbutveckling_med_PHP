<?php

	require_once("EventBand.php");

	class EventBandList{

		
		private $eventbands;

		//Lägger in privata varibeln eventbands värden i en array.
		public function __construct(){

			$this->eventbands = array();
		}

		//Lägger in, in parametern eventband i arrayen.
		public function add(EventBand $eventband){

			$this->eventbands[] = $eventband;

		}

		//Returnerar arrayen.
		public function toArray(){

			return $this->eventbands;

		}


	



	}