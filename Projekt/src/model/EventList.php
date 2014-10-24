<?php

require_once("Event.php");

	class EventList{


		private $events;

		//Lägger in privata varibeln events värden i en array.
		public function __construct(){

			$this->events = array();
		}

		//Lägger in, in parametern event i arrayen.
		public function add(Event $event){

			$this->events[] = $event;

		}

		//Returnerar arrayen.
		public function toArray(){

			return $this->events;

		}

	}