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
		
		// Kontrollerar ifall anv�ndarnamnet �r lagrat i POST-arrayen.
		public function didUserPressLogin()
		{
			return isset($_POST[$this->username]);
		}
		
		// Kontrollerar ifall URL:en inneh�ller logout.
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
		
		// S�tter body-inneh�llet.
		public function showLoginPage()
		{
			
			$timedate = $this->timedate->TimeAndDate();

			// Kontrollerar inloggningsstatus. �r anv�ndaren inloggad...	
			if($this->model->checkLoginStatus())
			{				
				// ...visa anv�ndarsidan...
				$contentString = "
					$this->message
					<p><a href='?logout'>Logga ut</a></p>";
				$this->loginStatus = $this->model->getLoggedInUser() . " �r inloggad";
			}
			else 
			{
				
				
					// ...annars visas inloggningssidan.
					$this->loginStatus = "Ej inloggad";
					$contentString = 
					"<form id='loginForm' method=post action='?login'>
						<fieldset>
							<legend>Login - Skriv in anv�ndarnamn och l�senord</legend>
							$this->message
							Namn: <input type='text' name='$this->username' value='" . $this->getInputUsername() . "'>
							L�senord: <input type='password' name='$this->password'> 
							<input type='checkbox' name='$this->checkbox' value='checked'>H�ll mig inloggad:
							<button type='submit' name='button' form='loginForm' value='Submit'>Logga in</button>
						</fieldset>
					</form>";
				
			}
			
			
			$HTMLbody = "
				
				<h2>$this->loginStatus</h2>
				<p><a href='?register'>Registrera ny anv�ndare</a></p>
				$contentString
				" . $timedate . ".";
			if($this->model->checkLoginStatus())
			{
			$HTMLbody = "
				<h2>$this->loginStatus</h2>
				$contentString<br>
				<h2>Meny</h2>
				<p><a href='?addevent'>L�gg till event</a></p>
				<p><a href='?addband'>L�gg till band</a></p>
				<p><a href='?addbandtoevent'>L�gg till band till event</a></p>
				<p><a href='?addrating'>L�gg till betyg till event med angivet band</a></p>
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
			
			// Kontrollerar inloggningsstatus. �r anv�ndaren inloggad...	
			if($this->model->checkLoginStatus())
			{				
				// ...visa anv�ndarsidan...
				$contentString = "
					$this->message
					<p><a href='?logout'>Logga ut</a></p>";
				$this->loginStatus = $this->model->getLoggedInUser() . " �r inloggad";
			}
			else 
			{
				
				
					// ...annars visas inloggningssidan.
					$this->loginStatus = "Ej inloggad";
					$contentString = 
					"<form id='loginForm' method=post action='?login'>
						<fieldset>
							<legend>Login - Skriv in anv�ndarnamn och l�senord</legend>
							$this->message
							Namn: <input type='text' name='$this->username' value='" . $this->getRegisterUsername() . "'>
							L�senord: <input type='password' name='$this->password'> 
							<input type='checkbox' name='$this->checkbox' value='checked'>H�ll mig inloggad:
							<button type='submit' name='button' form='loginForm' value='Submit'>Logga in</button>
						</fieldset>
					</form>";
				
			}
			
			$HTMLbody = "
				
				<h2>$this->loginStatus</h2>
				<p><a href='?register'>Registrera ny anv�ndare</a></p>
				$contentString
				" . $timedate . ".";
			
			$this->echoHTML($HTMLbody);
		}

		public function showRegisterPage(){

			$timedate = $this->timedate->TimeAndDate();
			
			// Kontrollerar inloggningsstatus. �r anv�ndaren inloggad...	
			if($this->model->checkLoginStatus())
			{			
				
				// ...visa anv�ndarsidan...
				$contentString = "
					$this->message
					<p><a href='?logout'>Logga ut</a></p>";
				$this->loginStatus = $this->model->getLoggedInUser() . " �r inloggad";
			}else{

					// visa registreringssidan.
					$this->loginStatus = "Ej inloggad, Registrerar anv�ndare";
					$contentString = 
					 "
					<form method=post >
						<fieldset>
							<legend>Registrera ny anv�ndare - Skriv in anv�ndarnamn och l�senord</legend>
							$this->message
							Namn: <input type='text' name='$this->createusername' value='". strip_tags($_POST[$this->createusername]) ."'><br>
							L�senord: <input type='password' name='$this->createpassword'><br>
							Repetera L�senord: <input type='password' name='$this->repeatpassword'><br>
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
		
		// Skapar cookies inneh�llande de medskickande v�rdena.
		public function createCookies($usernameToSave, $passwordToSave)
		{
			// Best�mmer cookies livsl�ngd.
			$cookieExpirationTime = time()+ 60;
			
			// Skapar cookies.
			setcookie("Username", $usernameToSave, $cookieExpirationTime);
			setcookie("Password", $passwordToSave, $cookieExpirationTime);
			
			//Skapar en fil inneh�llande information om kakornas livsl�ngd.
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
			
			// Validera kakornas inneh�ll.
			$this->model->verifyUserInput($_COOKIE["Username"], $this->model->decodePassword($_COOKIE["Password"]), true);
			
			// Visa r�ttmeddelande.
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
		
		// Sparar angivet anv�ndarnamn i textf�ltet.
		public function getInputUsername()
		{
			if(isset($_POST['username']))
			{
				return $_POST['username'];
			}
			
			// �r inte anv�ndarnamnet satt skickas en tomstr�ng med.
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
		
		// Visar login-meddelande f�r "H�ll mig inloggad"-funktionen.
		public function successfulLoginAndCookieCreation()
		{
			$this->showMessage("Inloggningen lyckades och vi kommer ih�g dig n�sta g�ng");
		}
		
		// Visar logout-meddelande.
		public function successfulLogout()
		{
			$this->showMessage("Du har nu loggat ut");
		}

		public function successfulRegistration()
		{
			$this->showMessage("Registrering av ny anv�ndare lyckades");
		}


		
	}
?>