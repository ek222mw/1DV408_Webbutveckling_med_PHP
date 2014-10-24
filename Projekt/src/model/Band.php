<?php


	Class Band{

		private $m_name;
		private $m_id;

		//Tilldelar privata variabler konstruktorns invärden.
		public function __construct($name,$id){
			$this->m_name = $name;
			$this->m_id = $id;

		}

		//Returnerar namnet.
		public function getName(){

			return $this->m_name;
		}

		//Returnerar idet.
		public function getID(){

			return $this->m_id;
		}
	}