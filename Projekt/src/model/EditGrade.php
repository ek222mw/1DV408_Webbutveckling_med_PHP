<?php


	class EditGrade
	{
		private $m_grade;
		private $m_id;
		private $m_event;
		private $m_band;
		private $m_user;

		//tilldelar privata variabler konstruktorns invärden.
		public function __construct($grade,$id,$event,$band,$user){
			$this->m_grade = $grade;
			$this->m_id = $id;
			$this->m_event = $event;
			$this->m_band = $band;
			$this->m_user = $user;

		}

		//Returnerar betyget.
		public function getGrade(){

			return $this->m_grade;
		}

		//Returnerar idet.
		public function getID(){

			return $this->m_id;
		}

		//Returnerar livespelningen.
		public function getEvent(){

			return $this->m_event;
		}

		//Returnerar bandet.
		public function getBand(){

			return $this->m_band;

		}

		//Returnerar användaren.
		public function getUser(){

			return $this->m_user;
		}

	
	}