<?php
	require_once("DBDetails.php");

	class LoginModel
	{
		
		private $sessionUserAgent;
		private $success = false;
		private $db;
		private $loggedInUser = "loggedInUser";
		private $loggedIn = "loggedIn";

		
		
		public function __construct($userAgent)
		{
			// Sparar anv�ndarens useragent i den privata variablerna.
			$this->sessionUserAgent = $userAgent;
			$this->db = new DBDetails();
		}
		
		// Kontrollerar loginstatusen. �r anv�ndaren inloggad returnerar metoden true, annars false.
		public function checkLoginStatus()
		{
			if(isset($_SESSION[$this->loggedIn]) && $_SESSION[$this->loggedIn] === true && $_SESSION[$this->sessionUserAgent] === $this->sessionUserAgent)
			{
				return true;
			}
			
			return false;
		}

		public function CheckBothRegInput($registerUsername,$registerPassword){

			if(mb_strlen($registerUsername) < 3 && mb_strlen($registerPassword) < 6){

				// Kasta undantag.
				throw new Exception("Anv�ndarnamnet har f�r f� tecken. Minst 3 tecken<br>L�senordet har f�r f� tecken. Minst 6 tecken");
				
			}
			return true;

		}

		public function CheckRegUsernameLength($registerUsername){

			if(mb_strlen($registerUsername) < 3){

				// Kasta undantag.
				throw new Exception("Anv�ndarnamnet har f�r f� tecken. Minst 3 tecken");
				
			}
			return true;

			
		}

		public function CheckReqPasswordLength($registerPassword){

			if(mb_strlen($registerPassword) < 6){

				// Kasta undantag.
				throw new Exception("L�senordet har f�r f� tecken. Minst 6 tecken");
				
				
			}
			return true;
			
			

		}

		public function ComparePasswordRepPassword($registerPassword, $repeatPassword){

				if($registerPassword !== $repeatPassword)
				{
					throw new Exception("L�senorden matchar inte");
				}
				return true;
		}


		public function addUsersetSuccess($registerUsername,$registerPassword)
		{
			$this->success = $this->db->addUser($registerUsername,$registerPassword);
			  
			 	
			 
		}	
	
		public function ValidateInput($input){
			


			if(!preg_match('/^[A-Za-z][A-Za-z0-9]{2,31}$/', $input))
			{
				throw new Exception("Inmatade v�rdet inneh�ller ogiltiga tecken");
			}
			return true;
		}

		public function UserRegistered(){

			return $this->success;
		}

		public function UserLogin(){

			return $this->loginsuccess;
		}

		public function cryptPassword($pw)
		{
			return crypt($pw,"emile");
		}

		

		
		
		// Kontrollerar anv�ndarinput gentemot de faktiska anv�ndaruppgifterna.
		public function verifyUserInput($inputUsername, $inputPassword, $isCookieLogin = false)
		{

			$DB_Username = $this->db->verifyUserInput($inputUsername);
			$DB_Password = $this->db->verifyPassInput($inputPassword);
			$emptystring = "";
				

			if($inputUsername == "" || $inputUsername === NULL)
			{
				// Kasta undantag.
				throw new Exception("Anv�ndarnamn saknas");
			}
			
			if($inputPassword == "" || $inputPassword === NULL || $inputPassword === $this->cryptPassword($emptystring))
			{
				// Kasta undantag.
				throw new Exception("L�senord saknas");
			}
			
			
			// Kontrollerar ifall inparametrarna matchar de faktiska anv�ndaruppgifterna.
			if($inputUsername == $DB_Username && $inputPassword == $DB_Password)
			{
				// Inloggningsstatus och anv�ndarnamn sparas i sessionen.
				$_SESSION[$this->loggedIn] = true;
				$_SESSION[$this->loggedInUser] = $inputUsername;
				
				
				// Sparar useragent i sessionen.
				$_SESSION[$this->sessionUserAgent] = $this->sessionUserAgent;
								
				return true;
			}
			else
			{
				// �r det en inloggning med cookies...
				if($isCookieLogin)
				{
					// Kasta cookie-felmeddelande.
					$this->cookieException();
				}
				
				// Kasta undantag.
				throw new Exception("Felaktigt anv�ndarnamn och/eller l�senord");
			}
		}
		
		public function cookieException()
		{
			// Kasta cookie-felmeddelande.
			throw new Exception("Felaktig information i cookie");
		}
		
		// H�mtar anv�ndarnamnet fr�n sessionen.
		public function getLoggedInUser()
		{
			if(isset($_SESSION[$this->loggedInUser]))
			{
				return $_SESSION[$this->loggedInUser];
			}
		}
		
		// Logout-metod som avs�tter och f�rst�r sessionen.
		public function logOut()
		{
			
			session_unset();
			session_destroy();
		}
		
		// Skapar en fil p� servern som inneh�ller det medskickade objektets v�rden.
		public function createReferenceFile($referenceValue, $fileName)
		{
			// Skapar och �ppnar en textfil.
			$referenceFile = fopen($fileName . ".txt", "w") or die("Unable to open file!");
			
			fwrite($referenceFile, $referenceValue);
			
			// St�nger textfilen.
			fclose($referenceFile);
		}
		
		// Kontrollerar textfilen gentemot kakornas tid.
		public function validateExpirationTime()
		{
			// Variabel som ska inneh�lla tiden fr�n filen.
			$correctTime = "";
			
			// �ppnar filen, l�ser igenom den och sparar v�rdet i $correctTime, f�r att sedan st�nga filen.
			$file = fopen('cookieExpirationTime.txt','r');
			while ($line = fgets($file))
			{
			  $correctTime = $line;
			}
			fclose($file);
			
			// Om tiden fr�n filen �r st�rre �n just precis nu...
			if(intval($correctTime) > time())
			{
				// Returnera true, kakan �r fortfarande giltig.
				return true;
			}
			else
			{
				// Annars kalla p� felmeddelandet, kakans levnadstid �r �ver.
				$this->cookieException();
			}
		}
	}

?>