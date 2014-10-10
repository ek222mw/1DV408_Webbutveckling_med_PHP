<?php 

	require_once("BandList.php");
	require_once("EventList.php");

	class DBDetails{

			protected $dbUsername = "root";
			protected $dbPassword = "";
			protected $dbConnstring = 'mysql:host=127.0.0.1;dbname=login';
			protected $dbConnection;
			protected $dbTable = "";

			private static $event = "event";
			private static $band = "band";
			private static $id = "id";
			private static $bid = "bid";
			private static $eid = "eid";
			private static $eventband = "eventband";
			private static $username = "username";
			private static $password = "password";

			protected function connection() {
			if ($this->dbConnection == NULL)
				$this->dbConnection = new \PDO($this->dbConnstring, $this->dbUsername, $this->dbPassword);
			
			$this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			
			return $this->dbConnection;
			}

			public function addEvent($inputevent) {
				try {
					$db = $this -> connection();
					$this->dbTable = "event";

					$sql = "INSERT INTO $this->dbTable (".self::$event.") VALUES (?)";
					$params = array($inputevent);

					$query = $db -> prepare($sql);
					$query -> execute($params);
					

				} catch (\PDOException $e) {
					die('An unknown error have occured.');
				}
			}

		public function checkIfEventExist($inputevent)
		{

			
				$db = $this -> connection();
				$this->dbTable = "event";
				$sql = "SELECT ". self::$event ." FROM `$this->dbTable` WHERE ". self::$event ." = ?";
				$params = array($inputevent);

				$query = $db -> prepare($sql);
				$query -> execute($params);

				$result = $query -> fetch();
				
				

				
				if ($result['event'] !== null) {

					throw new Exception("Spelning med det namnet är redan upptaget");

				}else{

					return true;
				}
			
		
		}


		public function checkIfBandExist($inputband){

				$db = $this -> connection();
				$this->dbTable = "band";
				$sql = "SELECT ". self::$band ." FROM `$this->dbTable` WHERE ". self::$band ." = ?";
				$params = array($inputband);

				$query = $db -> prepare($sql);
				$query -> execute($params);

				$result = $query -> fetch();
				
				

				
				if ($result['band'] !== null) {

					throw new Exception("Bandet med det namnet är redan upptaget");

				}else{

					return true;
				}



		}

		public function fetchAllEvents()
		{
				$db = $this -> connection();
				$this->dbTable = "event";
				$sql = "SELECT * FROM `$this->dbTable`";
				

				$query = $db -> prepare($sql);
				$query -> execute();

				$result = $query -> fetchall();
				$events = new EventList();
				foreach ($result as $eventdb) {
					$event = new Event($eventdb['event'], $eventdb['id']);
					$events->add($event);

				}
				return $events;
				
				
		}

		public function fetchAllBands()
		{

				$db = $this -> connection();
				$this->dbTable = "band";
				$sql = "SELECT * FROM `$this->dbTable`";
				

				$query = $db -> prepare($sql);
				$query -> execute();

				$result = $query -> fetchall();
				$bands = new BandList();
				foreach ($result as $banddb) {
					$band = new Band($banddb['band'], $banddb['id']);
					$bands->add($band);

				}
				return $bands;

		}


		public function addBand($inputband)
		{
			try {
					$db = $this -> connection();
					$this->dbTable = "band";

					$sql = "INSERT INTO $this->dbTable (".self::$band.") VALUES (?)";
					$params = array($inputband);

					$query = $db -> prepare($sql);
					$query -> execute($params);
					

				} catch (\PDOException $e) {
					die('An unknown error have occured.');
				}


		}

		public function addBandToEvent($dropdownvalue)
		{

				$db = $this -> connection();
				$this->dbTable = "band";
				$sql = "SELECT ". self::$id ." FROM `$this->dbTable` as b JOIN ". self::$eventband ." as be ON b.". self::$id ." = be.". self::$bid ." ";
				

				$query = $db -> prepare($sql);
				$query -> execute();

				$result = $query -> fetchall();
				$var_dump($result);
				/*$events = new EventList();
				foreach ($result as $eventdb) {
					$event = new Event($eventdb['event'], $eventdb['id']);
					$events->add($event);

				}
				return $events;*/






		}


		

	}