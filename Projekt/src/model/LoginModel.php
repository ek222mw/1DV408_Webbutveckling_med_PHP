<?php
	require_once("DBDetails.php");

	class LoginModel
	{
		
		private $sessionUserAgent;
		private $success = false;
		private $db;
		private $loggedInUser = "loggedInUser";
		private $loggedIn = "loggedIn";

		
		
		public function __construct()
		{
			// Sparar användarens useragent i den privata variablerna.
			// Sparar ner användarens användaragent och ip. Används vid verifiering av användaren.
			$this->sessionUserAgent = $_SERVER['HTTP_USER_AGENT'];
			$this->db = new DBDetails();
		}
		
		// Kontrollerar loginstatusen. Är användaren inloggad returnerar metoden true, annars false.Tilldelad kod.
		public function checkLoginStatus()
		{
			if(isset($_SESSION[$this->loggedIn]) && $_SESSION[$this->loggedIn] === true && $_SESSION[$this->sessionUserAgent] === $this->sessionUserAgent)
			{
				return true;
			}
			
			return false;
		}

		//Kontrollerar om registrerings användarnamn och lösenord har för få tecken, isådanafall kasta undantag, annars returnerar true.
		public function CheckBothRegInput($registerUsername,$registerPassword){

			if(mb_strlen($registerUsername) < 3 && mb_strlen($registerPassword) < 6){

				// Kasta undantag.
				throw new Exception("Användarnamnet har för få tecken. Minst 3 tecken<br>Lösenordet har för få tecken. Minst 6 tecken");
				
			}
			return true;

		}

		//Kontrollerar om registrerings användarnamnet har för få tecken, isådanafall kasta undantag, annars returnerar true.
		public function CheckRegUsernameLength($registerUsername){

			if(mb_strlen($registerUsername) < 3){

				// Kasta undantag.
				throw new Exception("Användarnamnet har för få tecken. Minst 3 tecken");
				
			}
			return true;

			
		}

		//Kontrollerar om registrerings lösenordet har för få tecken, isådanafall kasta undantag, annars returnerar true.
		public function CheckReqPasswordLength($registerPassword){

			if(mb_strlen($registerPassword) < 6){

				// Kasta undantag.
				throw new Exception("Lösenordet har för få tecken. Minst 6 tecken");
				
				
			}
			return true;
			
			

		}

		//Kontrollerar om registrerings lösenordet och det repiterade lösenordet matchar, isådanafall returnera true, annars kasta undantag.
		public function ComparePasswordRepPassword($registerPassword, $repeatPassword){

				if($registerPassword !== $repeatPassword)
				{
					throw new Exception("Lösenorden matchar inte");
				}
				return true;
		}

		//Lägger till registrerings användarnamn och lösenord och får tillbaks true som sätter privata variabeln success som i sin tur aktiverar så det kommer ut ett rätt meddelande. 
		public function addUsersetSuccess($registerUsername,$registerPassword)
		{
			$this->success = $this->db->addUser($registerUsername,$registerPassword);
			  
			 	
			 
		}	
	
		//Kontrollerar om det finns ogiltiga tecken i inmatningen, om inte så returneras true annars kasta undantag.
		public function ValidateInput($input){
			
			if(!preg_match('/^[A-Za-z-åäöÅÄÖ][A-Za-z0-9-\s-&-åäöÅÄÖ]{2,50}$/', $input))
			{
				throw new Exception("Inmatade värdet innehåller ogiltiga tecken");
			}
			return true;
		}

		//Returnerar privata variabeln success status.
		public function UserRegistered(){

			return $this->success;
		}

		//Returnerar statusen på variabeln loginsuccess.
		public function UserLogin(){

			return $this->loginsuccess;
		}

		//Returnerar lösenordet som krypterat.
		public function cryptPassword($pw)
		{
			return crypt($pw,"emile");
		}

		

		
		
		// Kontrollerar användarinput gentemot de faktiska användaruppgifterna.
		public function verifyUserInput($inputUsername, $inputPassword, $isCookieLogin = false)
		{

			$DB_Username = $this->db->getDBUserInput($inputUsername);
			$DB_Password = $this->db->getDBPassInput($inputPassword);
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
				// Är det en inloggning med cookies...Tilldelad kod.
				if($isCookieLogin)
				{
					// Kasta cookie-felmeddelande.Tilldelad kod.
					$this->cookieException();
				}
				
				// Kasta undantag.
				throw new Exception("Felaktigt användarnamn och/eller lösenord");
			}
		}
		
		//Tilldelad kod.
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
		
		// Logout-metod som avsätter och förstör sessionen.Tilldelad kod.
		public function logOut()
		{
			
			session_unset();
			session_destroy();
		}
		
		// Skapar en fil på servern som innehåller det medskickade objektets värden.Tilldelad kod.
		public function createReferenceFile($referenceValue, $fileName)
		{
			// Skapar och öppnar en textfil.
			$referenceFile = fopen($fileName . ".txt", "w") or die("Unable to open file!");
			
			fwrite($referenceFile, $referenceValue);
			
			// Stänger textfilen.
			fclose($referenceFile);
		}
		
		// Kontrollerar textfilen gentemot kakornas tid.Tilldelad kod.
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