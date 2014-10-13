<?php 


	class ShowEvent{


		private $m_band;
		private $m_id;
		private $m_event;
		private $m_grade;


		public function __construct($band,$id,$event,$grade){
			$this->m_band = $band;
			$this->m_id = $id;
			$this->m_event = $event;
			$this->m_grade = $grade;

		}

		public function getBand(){

			return $this->m_band;
		}

		public function getID(){

			return $this->m_id;
		}

		public function getEvent()
		{
			return $this->m_event;
		}

		public function getGrade()
		{
			return $this->m_grade;
		}


	}