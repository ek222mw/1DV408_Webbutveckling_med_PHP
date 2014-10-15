<?php

	class EventBand{

		private $m_name;
		private $m_id;


		public function __construct($name,$id){
			$this->m_name = $name;
			$this->m_id = $id;

		}

		public function getName(){

			return $this->m_name;
		}

		public function getID(){

			return $this->m_id;
		}



		
	}