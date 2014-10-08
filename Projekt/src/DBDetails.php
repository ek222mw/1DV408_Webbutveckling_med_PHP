<?php 


	class DBDetails{

			protected $dbUsername = "root";
			protected $dbPassword = "";
			protected $dbConnstring = 'mysql:host=127.0.0.1;dbname=login';
			protected $dbConnection;
			protected $dbTable = "";

			private static $event = "event";
			private static $band = "band";
			private static $username = "username";
			private static $password = "password";

			protected function connection() {
			if ($this->dbConnection == NULL)
				$this->dbConnection = new \PDO($this->dbConnstring, $this->dbUsername, $this->dbPassword);
			
			$this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			
			return $this->dbConnection;
			}

			public function addEvent($inputevent,$inputband) {
			try {
				$db = $this -> connection();
				$this->dbTable = "event";

				$sql = "INSERT INTO $this->dbTable (".self::$event.",". self::$band .") VALUES (?, ?)";
				$params = array($inputevent, $inputband);

				$query = $db -> prepare($sql);
				$query -> execute($params);
				

			} catch (\PDOException $e) {
				die('An unknown error have occured.');
			}
		}

		public function checkIfEventExist($inputevent,$inputband)
		{

			
				$db = $this -> connection();
				$this->dbTable = "event";
				$sql = "SELECT ". self::$event .", ". self::$band ." FROM `$this->dbTable` WHERE ". self::$event ." = ? AND ". self::$band ." =?";
				$params = array($inputevent,$inputband);

				$query = $db -> prepare($sql);
				$query -> execute($params);

				$result = $query -> fetch();
				
				var_dump($result['event']);
				var_dump($result['band']);

				
				if ($result['event'] !== null && $result['band'] !== null ) {

					throw new Exception("Spelning med det bandet är redan upptaget");

				}else{

					return true;
				}
			
		
		}

	}