<?php

	require_once("ShowEvent.php");
	
	class ShowEventList{

		private $showevents;

		//Lägger in privata varibeln showevents värden i en array.
		public function __construct(){

			$this->showevents = array();
		}

		//Lägger in, in parametern showevent i arrayen.
		public function add(ShowEvent $showevent){

			$this->showevents[] = $showevent;

		}

		//Returnerar arrayen.
		public function toArray(){

			return $this->showevents;

		}

	}