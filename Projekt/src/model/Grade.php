<?php


	class Grade{

		private $m_grade;
		private $m_id;
		

		public function __construct($grade,$id){
			$this->m_grade = $grade;
			$this->m_id = $id;
			
		}

		public function getGrade(){

			return $this->m_grade;
		}

		public function getID(){

			return $this->m_id;
		}



	}