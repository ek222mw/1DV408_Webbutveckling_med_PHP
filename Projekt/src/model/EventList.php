<?php

require_once("Event.php");

	class EventList{


		private $events;

		public function __construct(){

			$this->events = array();
		}

		public function add(Event $event){

			$this->events[] = $event;

		}

		public function toArray(){

			return $this->events;

		}

	}