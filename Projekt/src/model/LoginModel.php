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
			// Sparar användarens useragent i den privata variablerna.
			$this->sessionUserAgent = $userAgent;
			$this->db = new DBDetails();
		}
		
		// Kontrollerar loginstatusen. Är användaren inloggad returnerar metoden true, annars false.
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


		public function addUsersetSuccess($registerUsername,$registerPassword)
		{
			$this->success = $this->db->addUser($registerUsername,$registerPassword);
			  
			 	
			 
		}	
	
		public function ValidateInput($input){
			


			if(!preg_match('/^[A-Za-z][A-Za-z0-9]{2,31}$/', $input))
			{
				throw new Exception("Inmatade värdet innehåller ogiltiga tecken");
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

		

		
		
		// Kontrollerar användarinput gentemot de faktiska användaruppgifterna.
		public function verifyUserInput($inputUsername, $inputPassword, $isCookieLogin = false)
		{

			$DB_Username = $this->db->verifyUserInput($inputUsername);
			$DB_Password = $this->db->verifyPassInput($inputPassword);
			$emptystring = "";
				

			if($inputUsername == "" || $inputUsername === NULL)
			{
				// Kasta undantag.
				throw new Exception("Användarnamn saknas");
			}
			
			if($inputPassword == "" || $inputPassword === NULL || $inputPassword === $this->cryptPassword($emptystring))
			{
				// Kasta undantag.
				throw new Exception("Lösenord saknas");
			}
			
			
			// Kontrollerar ifall inparametrarna matchar de faktiska användaruppgifterna.
			if($inputUsername == $DB_Username && $inputPassword == $DB_Password)
			{
				// Inloggningsstatus och användarnamn sparas i sessionen.
				$_SESSION[$this->loggedIn] = true;
				$_SESSION[$this->loggedInUser] = $inputUsername;
				
				
				// Sparar useragent i sessionen.
				$_SESSION[$this->sessionUserAgent] = $this->sessionUserAgent;
								
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
			if(isset($_SESSION[$this->loggedInUser]))
			{
				return $_SESSION[$this->loggedInUser];
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