<?php

	class LoginModel
	{
		private $correctUsername = "";
		private $correctPassword = "";
		private $sessionUserAgent;
		private $success = false;
		

		protected $dbUsername = "root";
		protected $dbPassword = "";
		protected $dbConnstring = 'mysql:host=127.0.0.1;dbname=login';
		protected $dbConnection;
		protected $dbTable = "login";
		
		public function __construct($userAgent)
		{
			// Sparar användarens useragent i den privata variablerna.
			$this->sessionUserAgent = $userAgent;
		}
		
		// Kontrollerar loginstatusen. Är användaren inloggad returnerar metoden true, annars false.
		public function checkLoginStatus()
		{
			if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true && $_SESSION['sessionUserAgent'] === $this->sessionUserAgent)
			{
				return true;
			}
			
			return false;
		}

		public function CheckBothRegInput($registerUsername,$registerPassword){

			if(mb_strlen($registerUsername) < 3 && mb_strlen($registerPassword) < 6){

				// Kasta undantag.
				throw new Exception("Användarnamnet har för få tecken. Minst 3 tecken<br>Lösenordet har för få tecken. Minst 6 tecken");
				
			}
			return true;

		}

		public function CheckRegUsernameLength($registerUsername){

			if(mb_strlen($registerUsername) < 3){

				// Kasta undantag.
				throw new Exception("Användarnamnet har för få tecken. Minst 3 tecken");
				
			}
			return true;

			
		}

		public function CheckReqPasswordLength($registerPassword){

			if(mb_strlen($registerPassword) < 6){

				// Kasta undantag.
				throw new Exception("Lösenordet har för få tecken. Minst 6 tecken");
				
				
			}
			return true;
			
			

		}

		public function ComparePasswordRepPassword($registerPassword, $repeatPassword){

				if($registerPassword !== $repeatPassword)
				{
					throw new Exception("Lösenorden matchar inte");
				}
				return true;
		}

		
			
	
		protected function connection() {
			if ($this->dbConnection == NULL)
				$this->dbConnection = new \PDO($this->dbConnstring, $this->dbUsername, $this->dbPassword);
			
			$this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			
			return $this->dbConnection;
		}

		
	


		public function add($inputuser,$inputpassword) {
			try {
				$db = $this -> connection();
				
				$sql = "INSERT INTO $this->dbTable (`username`,`password`) VALUES (?, ?)";
				$params = array($inputuser, $inputpassword);

				$query = $db -> prepare($sql);
				$query -> execute($params);
				$this->success = true;

			} catch (\PDOException $e) {
				die('An unknown error have occured.');
			}
		}

		public function ReadSpecifik($inputuser)
		{

			
			$db = $this -> connection();

			$sql = "SELECT `username` FROM `$this->dbTable` WHERE `username` = ?";
			$params = array($inputuser);

			$query = $db -> prepare($sql);
			$query -> execute($params);

			$result = $query -> fetch();
			
			
			if ($result['username'] !== null) {
				
				$this->UsernameExistInDB();

			}else{
				return true;
			}
			
		
		}

		public function UsernameExistInDB(){
		
			
				throw new Exception("Användarnamnet är redan upptaget");
		}

		public function ValidateUsername($inputuser){
			


			if(!preg_match('/^[A-Za-z][A-Za-z0-9]{5,31}$/', $inputuser))
			{
				throw new Exception("Användarnamnet innehåller ogiltiga tecken");
			}
			return true;
		}

		public function UserRegistered(){

			return $this->success;
		}

		public function UserLogin(){

			return $this->loginsuccess;
		}

		public function encryptPassword($pw){

			return base64_encode($pw);
		}

		public function decodePassword($pwcrypt){

			return base64_decode($pwcrypt);
		}


		
		
		// Kontrollerar användarinput gentemot de faktiska användaruppgifterna.
		public function verifyUserInput($inputUsername, $inputPassword, $isCookieLogin = false)
		{



			$db = $this -> connection();

			$sql = "SELECT `username` FROM `$this->dbTable` WHERE `username` = ?";
			$params = array($inputUsername);

			$query = $db -> prepare($sql);
			$query -> execute($params);

			$result = $query -> fetch();
			
			
			if ($result) {
				
				
				$result['username'];
				$DB_Username = $result['username'];

			}


			$db = $this -> connection();

			$sql = "SELECT `password` FROM `$this->dbTable` WHERE `password` = ?";
			$params = array($inputPassword);

			$query = $db -> prepare($sql);
			$query -> execute($params);

			$result = $query -> fetch();
			
			
			if ($result) {
				
				
				$result['password'];
				$DB_Password = $result['password'];
				

			}


			if($inputUsername == "" || $inputUsername === NULL)
			{
				// Kasta undantag.
				throw new Exception("Användarnamn saknas");
			}
			
			if($inputPassword == "" || $inputPassword === NULL || $inputPassword === md5(""))
			{
				// Kasta undantag.
				throw new Exception("Lösenord saknas");
			}
			
			
			// Kontrollerar ifall inparametrarna matchar de faktiska användaruppgifterna.
			if($inputUsername == $DB_Username && $inputPassword == $DB_Password)
			{
				// Inloggningsstatus och användarnamn sparas i sessionen.
				$_SESSION['loggedIn'] = true;
				$_SESSION['loggedInUser'] = $inputUsername;
				
				// Sparar useragent i sessionen.
				$_SESSION['sessionUserAgent'] = $this->sessionUserAgent;
								
				return true;
			}
			else
			{
				// Är det en inloggning med cookies...
				if($isCookieLogin)
				{
					// Kasta cookie-felmeddelande.
					$this->cookieException();
				}
				
				// Kasta undantag.
				throw new Exception("Felaktigt användarnamn och/eller lösenord");
			}
		}
		
		public function cookieException()
		{
			// Kasta cookie-felmeddelande.
			throw new Exception("Felaktig information i cookie");
		}
		
		// Hämtar användarnamnet från sessionen.
		public function getLoggedInUser()
		{
			if(isset($_SESSION['loggedInUser']))
			{
				return $_SESSION['loggedInUser'];
			}
		}
		
		// Logout-metod som avsätter och förstör sessionen.
		public function logOut()
		{
			
			session_unset();
			session_destroy();
		}
		
		// Skapar en fil på servern som innehåller det medskickade objektets värden.
		public function createReferenceFile($referenceValue, $fileName)
		{
			// Skapar och öppnar en textfil.
			$referenceFile = fopen($fileName . ".txt", "w") or die("Unable to open file!");
			
			fwrite($referenceFile, $referenceValue);
			
			// Stänger textfilen.
			fclose($referenceFile);
		}
		
		// Kontrollerar textfilen gentemot kakornas tid.
		public function validateExpirationTime()
		{
			// Variabel som ska innehålla tiden från filen.
			$correctTime = "";
			
			// Öppnar filen, läser igenom den och sparar värdet i $correctTime, för att sedan stänga filen.
			$file = fopen('cookieExpirationTime.txt','r');
			while ($line = fgets($file))
			{
			  $correctTime = $line;
			}
			fclose($file);
			
			// Om tiden från filen är större än just precis nu...
			if(intval($correctTime) > time())
			{
				// Returnera true, kakan är fortfarande giltig.
				return true;
			}
			else
			{
				// Annars kalla på felmeddelandet, kakans levnadstid är över.
				$this->cookieException();
			}
		}
	}

?>