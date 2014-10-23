<?php

	
	require_once("./src/view/AddRatingView.php");
	require_once("./src/model/DBDetails.php");

	class ShowEventController{

		
		private $addratingview;
		private $db;

		public function __construct(){

			// Skapar nya instanser av modell- & vy-klasser och lägger dessa i privata variabler.
			$this->addratingview = new AddRatingView();
			$this->db = new DBDetails();


			$this->doHTMLBody();
		}

		//anropar vilken vy som ska visas.
		public function doHTMLBody()
		{
			$showEvents = $this->db->fetchShowAllEvents();

			$this->addratingview->ShowAllEventsWithBandGrades($showEvents);

		}


	}