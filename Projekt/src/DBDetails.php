<?php 

	require_once("BandList.php");
	require_once("EventList.php");
	require_once("GradeList.php");

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
			private static $gid = "gid";
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


		public function checkIfBandExistsOnEvent($eventdropdown, $banddropdown){

				$db = $this -> connection();
				$this->dbTable = "eventband";
				$sql = "SELECT ". self::$eid .",". self::$bid ." FROM `".$this->dbTable."` WHERE ". self::$eid ." = ? AND ". self::$bid ." = ?";
				$params = array($eventdropdown,$banddropdown);

				$query = $db -> prepare($sql);
				$query -> execute($params);

				$result = $query -> fetch();
				
				

				
				if ($result['eid'] !== null && $result['bid'] !== null ) {

					throw new Exception("Spelning innehåller redan det bandet du försöker lägga till");

				}else{

					return true;
				}

		}

		public function checkIfGradeExistOnEventBandUser($eventdropdown,$banddropdown,$username){

				$db = $this -> connection();
				$this->dbTable = "summarygrade";
				$sql = "SELECT ". self::$eid .",". self::$bid .",". self::$username ." FROM `".$this->dbTable."` WHERE ". self::$eid ." = ? AND ". self::$bid ." = ? AND ". self::$username ." = ?";
				$params = array($eventdropdown,$banddropdown,$username);

				$query = $db -> prepare($sql);
				$query -> execute($params);

				$result = $query -> fetch();
								

				
				if ($result['eid'] !== null && $result['bid'] !== null && $result['username'] !== null ) {

					throw new Exception("Spelningen med det bandet och användarnamn har redan ett betyg");

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

		public function fetchAllGrades()
		{

				$db = $this -> connection();
				$this->dbTable = "rating";
				$sql = "SELECT * FROM `$this->dbTable`";
				

				$query = $db -> prepare($sql);
				$query -> execute();

				$result = $query -> fetchall();
				$grades = new GradeList();
				foreach ($result as $gradedb) {
					$grade = new Grade($gradedb['rating'], $gradedb['ID']);
					$grades->add($grade);

				}
				return $grades;


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

		public function addBandToEvent($eventdropdown,$banddropdown)
		{

				try {
					$db = $this -> connection();
					$this->dbTable = "eventband";

					$sql = "INSERT INTO $this->dbTable (".self::$eid.",". self::$bid .") VALUES (?,?)";
					$params = array($eventdropdown,$banddropdown);

					$query = $db -> prepare($sql);
					$query -> execute($params);
					

				} catch (\PDOException $e) {
					die('An unknown error have occured.');
				}






		}

		public function addGradeToEventBandWithUser($eventdropdown,$banddropdown,$gradedropdown,$username){

			try {
					$db = $this -> connection();
					$this->dbTable = "summarygrade";

					$sql = "INSERT INTO $this->dbTable (".self::$eid.",". self::$bid .",". self::$gid .", ". self::$username .") VALUES (?,?,?,?)";
					$params = array($eventdropdown,$banddropdown,$gradedropdown,$username);

					$query = $db -> prepare($sql);
					$query -> execute($params);
					

				} catch (\PDOException $e) {
					die('An unknown error have occured.');
				}

		}


		

	}