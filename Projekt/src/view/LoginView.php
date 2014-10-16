<?php

	require_once("common/HTMLView.php");
	require_once("TimeDate.php");

	class LoginView extends HTMLView
	{
		private $model;
		private $loginStatus = "";
		private $username = "username";
		private $password = "password";
		private $checkbox = "checkbox";
		private $message = "";
		private $timedate;

		private $logout = "logout";
		private $register = "register";
		private $addevent = "addevent";
		private $showevents = "showevents";
		private $editrating = "editrating";
		private $createuserbutton = "createuserbutton";
		private $createusername = "createusername";
		private $createpassword = "createpassword";
		private $repeatpassword = "repeatpassword";
		private $addrating = "addrating";
		private $addbandtoevent = "addbandtoevent";
		private $addband = "addband";
		private $deleterating = "deleterating";
		
		public function __construct(LoginModel $model)
		{
			$this->model = $model;
			$this->timedate = new TimeDate();
		}
		
		// Kontrollerar ifall användarnamnet är lagrat i POST-arrayen.
		public function didUserPressLogin()
		{
			return isset($_POST[$this->username]);
		}
		
		// Kontrollerar ifall URL:en innehåller logout.
		public function didUserPressLogout()
		{
			return isset($_GET[$this->logout]);
		}

		public function didUserPressRegister()
		{
			 
			return isset($_GET[$this->register]);
			
		}

		public function didUserPressAddEvent()
		{

			return isset($_GET[$this->addevent]);
		}

		public function didUserPressShowAllEvents()
		{
			return isset($_GET[$this->showevents]);
		}

		public function didUserPressEditGrades()
		{
			return isset($_GET[$this->editrating]);
		}



		public function didUserPressCreateUser(){

			if(isset($_POST[$this->createuserbutton]))
			{
				return true;
			}
			return false;
		}		

		public function getRegisterUsername(){

			if(isset($_POST[$this->createusername]))
			{
				return $_POST[$this->createusername];
			}
			return false;
		}

		public function getRegisterPassword(){

			if(isset($_POST[$this->createpassword]))
			{
				return $_POST[$this->createpassword];
			}
			return false;
		}

		public function getRepeatRegisterPassword(){

			if(isset($_POST[$this->repeatpassword]))
			{
				return $_POST[$this->repeatpassword];
			}
			return false;
		}


		public function didUserPressAddRating()
		{

			return isset($_GET[$this->addrating]);
		}

		public function didUserPressAddBandToEvent()
		{
			return isset($_GET[$this->addbandtoevent]);
		}

		public function didUserPressAddBand()
		{

			return isset($_GET[$this->addband]);
		}

		public function didUserPressDeleteGrade()
		{
			return isset($_GET[$this->deleterating]);
		}
		
		// Sätter body-innehållet.
		public function showLoginPage()
		{
			
			$timedate = $this->timedate->TimeAndDate();

			// Kontrollerar inloggningsstatus. Är användaren inloggad...	
			if($this->model->checkLoginStatus())
			{				
				// ...visa användarsidan...
				$contentString = "
					$this->message
					<p><a href='?logout'>Logga ut</a></p>";
				$this->loginStatus = $this->model->getLoggedInUser() . " är inloggad";
			}
			else 
			{
				
				
					// ...annars visas inloggningssidan.
					$this->loginStatus = "Ej inloggad";
					$contentString = 
					"<form id='loginForm' method=post action='?login'>
						<fieldset>
							<legend>Login - Skriv in användarnamn och lösenord</legend>
							$this->message
							Namn: <input type='text' name='$this->username' value='" . $this->getInputUsername() . "'>
							Lösenord: <input type='password' name='$this->password'> 
							<input type='checkbox' name='$this->checkbox' value='checked'>Håll mig inloggad:
							<button type='submit' name='button' form='loginForm' value='Submit'>Logga in</button>
						</fieldset>
					</form>";
				
			}
			
			
			$HTMLbody = "
				
				<h2>$this->loginStatus</h2>
				<p><a href='?register'>Registrera ny användare</a></p>
				$contentString
				" . $timedate . ".";
			if($this->model->checkLoginStatus())
			{
			$HTMLbody = "
				<h2>$this->loginStatus</h2>
				$contentString<br>
				<h2>Meny</h2>
				<p><a href='?addevent'>Lägg till event</a></p>
				<p><a href='?addband'>Lägg till band</a></p>
				<p><a href='?addbandtoevent'>Lägg till band till event</a></p>
				<p><a href='?addrating'>Lägg till betyg till event med angivet band</a></p>
				<p><a href='?editrating'>Editera betyg till event med angivet band</a></p>
				<p><a href='?deleterating'>Ta bort betyg till event med angivet band</a></p>
				<p><a href='?showevents'>Visa events med band samt betyg</a></p>
				
				" . $timedate . ".";
			}

			$this->echoHTML($HTMLbody);
		}


		public function showLoginPageWithRegname()
		{
			
			$timedate = $this->timedate->TimeAndDate();
			
			// Kontrollerar inloggningsstatus. Är användaren inloggad...	
			if($this->model->checkLoginStatus())
			{				
				// ...visa användarsidan...
				$contentString = "
					$this->message
					<p><a href='?logout'>Logga ut</a></p>";
				$this->loginStatus = $this->model->getLoggedInUser() . " är inloggad";
			}
			else 
			{
				
				
					// ...annars visas inloggningssidan.
					$this->loginStatus = "Ej inloggad";
					$contentString = 
					"<form id='loginForm' method=post action='?login'>
						<fieldset>
							<legend>Login - Skriv in användarnamn och lösenord</legend>
							$this->message
							Namn: <input type='text' name='$this->username' value='" . $this->getRegisterUsername() . "'>
							Lösenord: <input type='password' name='$this->password'> 
							<input type='checkbox' name='$this->checkbox' value='checked'>Håll mig inloggad:
							<button type='submit' name='button' form='loginForm' value='Submit'>Logga in</button>
						</fieldset>
					</form>";
				
			}
			
			$HTMLbody = "
				
				<h2>$this->loginStatus</h2>
				<p><a href='?register'>Registrera ny användare</a></p>
				$contentString
				" . $timedate . ".";
			
			$this->echoHTML($HTMLbody);
		}

		public function showRegisterPage(){

			$timedate = $this->timedate->TimeAndDate();
			
			// Kontrollerar inloggningsstatus. Är användaren inloggad...	
			if($this->model->checkLoginStatus())
			{			
				
				// ...visa användarsidan...
				$contentString = "
					$this->message
					<p><a href='?logout'>Logga ut</a></p>";
				$this->loginStatus = $this->model->getLoggedInUser() . " är inloggad";
			}else{

					// visa registreringssidan.
					$this->loginStatus = "Ej inloggad, Registrerar användare";
					$contentString = 
					 "
					<form method=post >
						<fieldset>
							<legend>Registrera ny användare - Skriv in användarnamn och lösenord</legend>
							$this->message
							Namn: <input type='text' name='$this->createusername' value='". strip_tags($_POST[$this->createusername]) ."'><br>
							Lösenord: <input type='password' name='$this->createpassword'><br>
							Repetera Lösenord: <input type='password' name='$this->repeatpassword'><br>
							Skicka: <input type='submit' name='$this->createuserbutton'  value='Registrera'>
						</fieldset>
					</form>";

					$HTMLbody = "
				
				
				<p><a href='?login'>Tillbaka</a></p>
				
				<h2>$this->loginStatus</h2>
				
				$contentString<br>
				" . $timedate . ".";

				$this->echoHTML($HTMLbody);
			}

				
		}
		
		// Skapar cookies innehållande de medskickande värdena.
		public function createCookies($usernameToSave, $passwordToSave)
		{
			// Bestämmer cookies livslängd.
			$cookieExpirationTime = time()+ 60;
			
			// Skapar cookies.
			setcookie("Username", $usernameToSave, $cookieExpirationTime);
			setcookie("Password", $passwordToSave, $cookieExpirationTime);
			
			//Skapar en fil innehållande information om kakornas livslängd.
			$this->model->createReferenceFile($cookieExpirationTime, "cookieExpirationTime");
		}
		
		public function searchForCookies()
		{
			if(isset($_COOKIE["Username"]) === true && isset($_COOKIE["Password"]) === true)
			{
				return true;
			}
			
			return false;
		}
		
		// Logga in med kakor.
		public function loginWithCookies()
		{
			// Validera cookies mot textfilen.
			$this->model->validateExpirationTime();
			
			// Validera kakornas innehåll.
			$this->model->verifyUserInput($_COOKIE["Username"], $this->model->decodePassword($_COOKIE["Password"]), true);
			
			// Visa rättmeddelande.
			$this->showMessage("Inloggningen lyckades via cookies");
		}
		
		// Tar bort alla cookies.
		public function removeCookies()
		{
			foreach ($_COOKIE as $c_key => $c_value)
			{
				setcookie($c_key, NULL, 1);
			}
		}
		
		// Sparar angivet användarnamn i textfältet.
		public function getInputUsername()
		{
			if(isset($_POST['username']))
			{
				return $_POST['username'];
			}
			
			// Är inte användarnamnet satt skickas en tomsträng med.
			return "";
		}
		
		// Visar eventuella meddelanden.
		public function showMessage($message)
		{
			$this->message = "<p>" . $message . "</p>";
		}
		
		// Visar login-meddelande.
		public function successfulLogin()
		{
			$this->showMessage("Inloggningen lyckades!");
		}
		
		// Visar login-meddelande för "Håll mig inloggad"-funktionen.
		public function successfulLoginAndCookieCreation()
		{
			$this->showMessage("Inloggningen lyckades och vi kommer ihåg dig nästa gång");
		}
		
		// Visar logout-meddelande.
		public function successfulLogout()
		{
			$this->showMessage("Du har nu loggat ut");
		}

		public function successfulRegistration()
		{
			$this->showMessage("Registrering av ny användare lyckades");
		}


		
	}
?>