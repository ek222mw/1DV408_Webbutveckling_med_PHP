<?php


	class Grade{

		private $m_grade;
		private $m_id;
		
		//Tilldelar privata variabler konstruktorns invärden.
		public function __construct($grade,$id){
			$this->m_grade = $grade;
			$this->m_id = $id;
			
		}

		//Returnerar betyget.
		public function getGrade(){

			return $this->m_grade;
		}

		//Returnerar idet.
		public function getID(){

			return $this->m_id;
		}



	}