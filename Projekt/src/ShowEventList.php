<?php

	require_once("ShowEvent.php");
	
	class ShowEventList{

		private $showevents;

		public function __construct(){

			$this->showevents = array();
		}

		public function add(ShowEvent $showevent){

			$this->showevents[] = $showevent;

		}

		public function toArray(){

			return $this->showevents;

		}

	}