<?php

	require_once("DeleteGrade.php");

	class DeleteGradeList{

		private $grades;

		public function __construct(){

			$this->grades = array();
		}

		public function add(DeleteGrade $grade){

			$this->grades[] = $grade;

		}

		public function toArray(){

			return $this->grades;

		}



	}