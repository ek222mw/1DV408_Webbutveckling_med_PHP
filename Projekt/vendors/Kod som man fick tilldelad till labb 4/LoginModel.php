<?php

	class LoginModel
	{
		private $correctUsername = "Admin";
		private $correctPassword = "dc647eb65e6711e155375218212b3964";
		private $sessionUserAgent;
		
		public function __construct($userAgent)
		{
			// Sparar anv�ndarens useragent i den privata variablerna.
			$this->sessionUserAgent = $userAgent;
		}
		
		// Kontrollerar loginstatusen. �r anv�ndaren inloggad returnerar metoden true, annars false.
		public function checkLoginStatus()
		{
			if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true && $_SESSION['sessionUserAgent'] === $this->sessionUserAgent)
			{
				return true;
			}
			
			return false;
		}
		
		// Kontrollerar anv�ndarinput gentemot de faktiska anv�ndaruppgifterna.
		public function verifyUserInput($inputUsername, $inputPassword, $isCookieLogin = false)
		{										
			if($inputUsername == "" || $inputUsername === NULL)
			{
				// Kasta undantag.
				throw new Exception("Anv�ndarnamn saknas");
			}
			
			if($inputPassword == "" || $inputPassword === NULL || $inputPassword === md5(""))
			{
				// Kasta undantag.
				throw new Exception("L�senord saknas");
			}
			
			// Kontrollerar ifall inparametrarna matchar de faktiska anv�ndaruppgifterna.
			if($inputUsername == $this->correctUsername && $inputPassword == $this->correctPassword)
			{
				// Inloggningsstatus och anv�ndarnamn sparas i sessionen.
				$_SESSION['loggedIn'] = true;
				$_SESSION['loggedInUser'] = $inputUsername;
				
				// Sparar useragent i sessionen.
				$_SESSION['sessionUserAgent'] = $this->sessionUserAgent;
								
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
			if(isset($_SESSION['loggedInUser']))
			{
				return $_SESSION['loggedInUser'];
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