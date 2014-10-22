<?php 

	require_once("BandList.php");
	require_once("EventList.php");
	require_once("GradeList.php");
	require_once("EventBandList.php");
	require_once("ShowEventList.php");
	require_once("EditGradeList.php");
	require_once("DeleteGradeList.php");

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
			private static $grade = "grade";
			private static $eventband = "eventband";
			private static $username = "username";
			private static $password = "password";
			private static $rating = "rating";

			protected function connection() {
			if ($this->dbConnection == NULL)
				$this->dbConnection = new \PDO($this->dbConnstring, $this->dbUsername, $this->dbPassword);
			
			$this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			
			return $this->dbConnection;
			}

		

		public function ReadSpecifik($inputuser)
		{

			
			$db = $this -> connection();
			$this->dbTable = "login";

			$sql = "SELECT `username` FROM `$this->dbTable` WHERE `username` = ?";
			$params = array($inputuser);

			$query = $db -> prepare($sql);
			$query -> execute($params);

			$result = $query -> fetch();
			
			
			if ($result['username'] !== null) {
				
				throw new Exception("Användarnamnet är redan upptaget");

			}else{
				return true;
			}
			
		
		}	

		public function verifyUserInput($inputUser)
		{
			$db = $this -> connection();
			$this->dbTable = "login";

			$sql = "SELECT ". self::$username ." FROM `$this->dbTable` WHERE ". self::$username ." = ?";
			$params = array($inputUser);

			$query = $db -> prepare($sql);
			$query -> execute($params);

			$result = $query -> fetch();
			
			
			if ($result) {
				
				return $result['username'];
				
			}

		}

		public function verifyPassInput($inputPassword)
		{

			$db = $this -> connection();
			$this->dbTable = "login";

			$sql = "SELECT ". self::$password ." FROM `$this->dbTable` WHERE ". self::$password ." = ?";
			$params = array($inputPassword);

			$query = $db -> prepare($sql);
			$query -> execute($params);

			$result = $query -> fetch();
			
			
			if ($result) {
				
				return $result['password'];
				
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
				$sql = "SELECT ". self::$event .",". self::$band ." FROM `".$this->dbTable."` WHERE ". self::$event ." = ? AND ". self::$band ." = ?";
				$params = array($eventdropdown,$banddropdown);

				$query = $db -> prepare($sql);
				$query -> execute($params);

				$result = $query -> fetch();
				
				

				
				if ($result['event'] !== null && $result['band'] !== null ) {

					throw new Exception("Spelning innehåller redan det bandet du försöker lägga till");

				}else{

					return true;
				}

		}

		public function checkIfGradeExistOnEventBandUser($eventdropdown,$banddropdown,$username){

				$db = $this -> connection();
				$this->dbTable = "summarygrade";
				$sql = "SELECT ". self::$event .",". self::$band .",". self::$username ." FROM `".$this->dbTable."` WHERE ". self::$event ." = ? AND ". self::$band ." = ? AND ". self::$username ." = ?";
				$params = array($eventdropdown,$banddropdown,$username);

				$query = $db -> prepare($sql);
				$query -> execute($params);

				$result = $query -> fetch();
								

				
				if ($result['event'] !== null && $result['band'] !== null && $result['username'] !== null ) {

					throw new Exception("Spelningen med det bandet och användarnamn har redan ett betyg");

				}else{

					return true;
				}

		}

		public function checkIfIdManipulated($pickedid, $loggedinUser)
		{
				$db = $this -> connection();
				$this->dbTable = "summarygrade";
				$sql = "SELECT ". self::$id .",". self::$username ." FROM `".$this->dbTable."` WHERE ". self::$id ." = ? AND ". self::$username ." = ? ";
				$params = array($pickedid,$loggedinUser);

				$query = $db -> prepare($sql);
				$query -> execute($params);

				$result = $query -> fetch();
								

				
				if ($result['id'] == null && $result['username'] == null ) {

					throw new Exception("Id till det betyget har inte rätt användarnamn");

				}else{

					return true;
				}
		}

		public function checkIfBandAndEventManipulated($pickedevent,$pickedband)
		{
				$db = $this -> connection();
				$this->dbTable = "eventband";
				$sql = "SELECT ". self::$event .",". self::$band ." FROM `".$this->dbTable."` WHERE ". self::$event ." = ? AND ". self::$band ." = ? ";
				$params = array($pickedevent,$pickedband);

				$query = $db -> prepare($sql);
				$query -> execute($params);

				$result = $query -> fetch();
								

				
				if ($result['event'] == null && $result['band'] == null ) {

					throw new Exception("Livespelning och/eller bandet existerar ej i kolumnen livespelning respektive band");

				}else{

					return true;
				}

		}

		public function checkIfPickEventManipulated($pickedevent)
		{
				$db = $this -> connection();
				$this->dbTable = "eventband";
				$sql = "SELECT ". self::$event ." FROM `".$this->dbTable."` WHERE ". self::$event ." = ?";
				$params = array($pickedevent);

				$query = $db -> prepare($sql);
				$query -> execute($params);

				$result = $query -> fetch();
								

				
				if ($result['event'] == null) {

					throw new Exception("Livespelningen existerar ej i kolumnen");

				}else{

					return true;
				}

		}

		public function checkIfPickRatingManipulated($pickedrating)
		{
				$db = $this -> connection();
				$this->dbTable = "rating";
				$sql = "SELECT ". self::$rating ." FROM `".$this->dbTable."` WHERE ". self::$rating ." = ?";
				$params = array($pickedrating);

				$query = $db -> prepare($sql);
				$query -> execute($params);

				$result = $query -> fetch();
								

				
				if ($result['rating'] == null) {

					throw new Exception("Betyg existerar ej i kolumnen");

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

		public function fetchAllEventWithBands(){


				$db = $this -> connection();
				$this->dbTable = "eventband";
				$sql = "SELECT * FROM `$this->dbTable`";
				

				$query = $db -> prepare($sql);
				$query -> execute();

				$result = $query -> fetchall();
				$eventbands = new EventBandList();
				foreach ($result as $eventbanddb) {
					$eventband = new EventBand($eventbanddb['event'], $eventbanddb['id']);
					$eventbands->add($eventband);

				}
				return $eventbands;




		}

		public function fetchAllBandsWithEvent(){

				$db = $this -> connection();
				$this->dbTable = "eventband";
				$sql = "SELECT * FROM `$this->dbTable`";
				

				$query = $db -> prepare($sql);
				$query -> execute();

				$result = $query -> fetchall();
				$eventbands = new EventBandList();
				foreach ($result as $eventbanddb) {
					$eventband = new EventBand($eventbanddb['band'], $eventbanddb['id']);
					$eventbands->add($eventband);

				}
				return $eventbands;


		}

		public function fetchChosenBandsInEventDropdown($eventdropdown)
		{
				$db = $this -> connection();
				$this->dbTable = "eventband";
				$sql = "SELECT * FROM `$this->dbTable` WHERE ". self::$event ." = ?";
				$params = array($eventdropdown);
				

				$query = $db -> prepare($sql);
				$query -> execute($params);

				$result = $query -> fetchall();
				$eventbands = new EventBandList();
				foreach ($result as $eventbanddb) {
					$eventband = new EventBand($eventbanddb['band'], $eventbanddb['id']);
					$eventbands->add($eventband);

				}
				return $eventbands;

		}

		public function fetchChosenEventInEventDropDown($eventdropdown)
		{
				$db = $this -> connection();
				$this->dbTable = "eventband";
				$sql = "SELECT * FROM `$this->dbTable` WHERE ". self::$event ." = ?";
				$params = array($eventdropdown);
				

				$query = $db -> prepare($sql);
				$query -> execute($params);

				$result = $query -> fetchall();
				$eventbands = new EventBandList();
				foreach ($result as $eventbanddb) {
					$eventband = new EventBand($eventbanddb['event'], $eventbanddb['id']);
					$eventbands->add($eventband);

				}
				return $eventbands;

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

		public function fetchShowAllEvents()
		{
				$db = $this -> connection();
				$this->dbTable = "summarygrade";
				$sql = "SELECT * FROM `$this->dbTable`";
				

				$query = $db -> prepare($sql);
				$query -> execute();

				$result = $query -> fetchall();
				
				
				$showevents = new ShowEventList();
				foreach ($result as $showeventdb) {
					$showevent = new ShowEvent($showeventdb['band'], $showeventdb['id'], $showeventdb['event'], $showeventdb['grade'],$showeventdb['username']);
					$showevents->add($showevent);

				}
				return $showevents;
		}

		public function fetchEditGrades($loggedinUser)
		{
				$db = $this -> connection();
				$this->dbTable = "summarygrade";
				$sql = "SELECT * FROM `$this->dbTable` WHERE ". self::$username ." = ? ";
				$params = array($loggedinUser);
				

				$query = $db -> prepare($sql);
				$query -> execute($params);

				$result = $query -> fetchall();
				
				
				$editgrades = new EditGradeList();
				foreach ($result as $editgradedb) {
					$editgrade = new EditGrade($editgradedb['grade'], $editgradedb['id'], $editgradedb['event'], $editgradedb['band'],$editgradedb['username']);
					$editgrades->add($editgrade);

				}
				return $editgrades;
		}

		public function fetchIdPickedEditGrades($pickedid)
		{
				$db = $this -> connection();
				$this->dbTable = "summarygrade";
				$sql = "SELECT * FROM `$this->dbTable` WHERE ". self::$id ." = ? ";
				$params = array($pickedid);
				

				$query = $db -> prepare($sql);
				$query -> execute($params);

				$result = $query -> fetchall();
				
				
				$editgrades = new EditGradeList();
				foreach ($result as $editgradedb) {
					$editgrade = new EditGrade($editgradedb['grade'], $editgradedb['id'], $editgradedb['event'], $editgradedb['band'],$editgradedb['username']);
					$editgrades->add($editgrade);

				}
				return $editgrades;
		}


		public function fetchDeleteGradesWithSpecUser($loggedinUser)
		{
				$db = $this -> connection();
				$this->dbTable = "summarygrade";
				$sql = "SELECT * FROM `$this->dbTable` WHERE ". self::$username ." = ? ";
				$params = array($loggedinUser);
				

				$query = $db -> prepare($sql);
				$query -> execute($params);

				$result = $query -> fetchall();
				
				
				$deletegrades = new DeleteGradeList();
				foreach ($result as $deletegradedb) {
					$deletegrade = new DeleteGrade($deletegradedb['grade'], $deletegradedb['id'], $deletegradedb['event'], $deletegradedb['band'],$deletegradedb['username']);
					$deletegrades->add($deletegrade);

				}
				return $deletegrades;
		}

		public function addUser($inputuser,$inputpassword) {
			try {

				$db = $this -> connection();
				$this->dbTable = "login";

				$sql = "INSERT INTO $this->dbTable (". self::$username .",". self::$password  .") VALUES (?, ?)";
				$params = array($inputuser, $inputpassword);

				$query = $db -> prepare($sql);
				$query -> execute($params);
				
				return true;

			} catch (\PDOException $e) {
				die('An unknown error have occured.');
			}
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

					$sql = "INSERT INTO $this->dbTable (".self::$event.",". self::$band .") VALUES (?,?)";
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

					$sql = "INSERT INTO $this->dbTable (".self::$event.",". self::$band .",". self::$grade .", ". self::$username .") VALUES (?,?,?,?)";
					$params = array($eventdropdown,$banddropdown,$gradedropdown,$username);

					$query = $db -> prepare($sql);
					$query -> execute($params);
					

				} catch (\PDOException $e) {
					die('An unknown error have occured.');
				}

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

		public function EditGrades($inputgrade,$inputid)
		{
			try{
				
			$db = $this -> connection();
			$this->dbTable = "summarygrade";
			$sql = "UPDATE $this->dbTable SET ". self::$grade ."=? WHERE ". self::$id ."=?";
			$params = array($inputgrade,$inputid);

			$query = $db -> prepare($sql);
			$query -> execute($params);
					

			} catch (\PDOException $e) {
					die('An unknown error have occured.');
			}
        
		}

		public function DeleteGrades($inputid)
		{

			$db = $this -> connection();
			$this->dbTable = "summarygrade";

			$sql = "DELETE FROM $this->dbTable WHERE ". self::$id ." = ?";
			$params = array($inputid);

			$query = $db -> prepare($sql);
			$query -> execute($params);


		}


		

	}