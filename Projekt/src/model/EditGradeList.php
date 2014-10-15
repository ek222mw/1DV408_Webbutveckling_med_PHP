<?php

	require_once("EditGrade.php");

	class EditGradeList{


		private $grades;

		public function __construct(){

			$this->grades = array();
		}

		public function add(EditGrade $grade){

			$this->grades[] = $grade;

		}

		public function toArray(){

			return $this->grades;

		}


	}