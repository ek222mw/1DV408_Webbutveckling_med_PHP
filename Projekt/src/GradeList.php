<?php

	require_once("Grade.php");

	class GradeList{

		private $grades;

		public function __construct(){

			$this->grades = array();
		}

		public function add(Grade $grade){

			$this->grades[] = $grade;

		}

		public function toArray(){

			return $this->grades;

		}


	}