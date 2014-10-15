<?php 


	class ShowEvent{


		private $m_band;
		private $m_id;
		private $m_event;
		private $m_grade;
		private $m_user;


		public function __construct($band,$id,$event,$grade,$user){
			$this->m_band = $band;
			$this->m_id = $id;
			$this->m_event = $event;
			$this->m_grade = $grade;
			$this->m_user = $user;

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

		public function getUser()
		{
			return $this->m_user;
		}


	}