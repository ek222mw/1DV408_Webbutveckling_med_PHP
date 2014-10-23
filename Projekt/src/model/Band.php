<?php


	Class Band{

		private $m_name;
		private $m_id;

		//tilldelar privata variabler konstruktorns invärden.
		public function __construct($name,$id){
			$this->m_name = $name;
			$this->m_id = $id;

		}

		//returnerar namnet.
		public function getName(){

			return $this->m_name;
		}

		//returnerar idet.
		public function getID(){

			return $this->m_id;
		}
	}