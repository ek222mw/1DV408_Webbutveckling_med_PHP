<?php

	require_once("EditGrade.php");

	class EditGradeList{


		private $grades;

		//Lägger in privata varibeln grades värden i en array.
		public function __construct(){

			$this->grades = array();
		}

		//Lägger in, in parametern grade i arrayen.
		public function add(EditGrade $grade){

			$this->grades[] = $grade;

		}

		//Returnerar arrayen.
		public function toArray(){

			return $this->grades;

		}


	}