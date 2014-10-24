<?php

	require_once("common/HTMLView.php");
	

	//Ärver HTMLView
	class LoginView extends HTMLView
	{
		private $model;
		private $loginStatus = "";
		private $username = "username";
		private $password = "password";
		private $checkbox = "checkbox";
		private $message = "";
		private $welcomemessage = "";

		private $logout = "logout";
		private $register = "register";
		private $addevent = "addevent";
		private $showevents = "showevents";
		private $editrating = "editrating";
		private $login = "login";
		private $createuserbutton = "createuserbutton";
		private $createusername = "createusername";
		private $createpassword = "createpassword";
		private $repeatpassword = "repeatpassword";
		private $addrating = "addrating";
		private $addbandtoevent = "addbandtoevent";
		private $addband = "addband";
		private $deleterating = "deleterating";
		
		//Gör nya instanser av klasser.
		public function __construct(LoginModel $model)
		{
			$this->model = $model;
			
		}
		
		// Kontrollerar ifall användarnamnet är lagrat i POST-arrayen.Tilldelad kod.
		public function didUserPressLogin()
		{
			return isset($_POST[$this->username]);
		}
		
		// Kontrollerar ifall URL:en innehåller logout.Tilldelad kod.
		public function didUserPressLogout()
		{
			return isset($_GET[$this->logout]);
		}

		//Kollar om användaren tryckt på register länken, returnerar sant annars falskt.
		public function didUserPressRegister()
		{
			 
			return isset($_GET[$this->register]);
			
		}

		//Kollar om användaren tryckt på lägga till livespelning länken i menyn, returnerar sant annars falskt.
		public function didUserPressAddEvent()
		{

			return isset($_GET[$this->addevent]);
		}

		//Kollar om användaren tryckt på visar livespelningar med band samt betyg länken i menyn, returnerar sant annars falskt.
		public function didUserPressShowAllEvents()
		{
			return isset($_GET[$this->showevents]);
		}

		//Kollar om användaren tryckt på editera betyg till livespelning med angivet band länken i menyn, returnerar sant annars falskt.
		public function didUserPressEditGrades()
		{
			return isset($_GET[$this->editrating]);
		}


		//Kontrollerar om användaren tryckt på skapa användare knappen, returnera true annars falskt.
		public function didUserPressCreateUser(){

			if(isset($_POST[$this->createuserbutton]))
			{
				return true;
			}
			return false;
		}

		//Kollar om användaren matat in något i registrera användare inputen, returnera värdet annars falskt.
		public function getRegisterUsername(){

			if(isset($_POST[$this->createusername]))
			{
				return $_POST[$this->createusername];
			}
			return false;
		}

		//Kollar om användaren matat in något i registrera lösenord inputen, returnera värdet annars falskt.
		public function getRegisterPassword(){

			if(isset($_POST[$this->createpassword]))
			{
				return $_POST[$this->createpassword];
			}
			return false;
		}

		//Kollar om användaren matat in något i repitera registrera lösenord inputen, returnera värdet annars falskt.
		public function getRepeatRegisterPassword(){

			if(isset($_POST[$this->repeatpassword]))
			{
				return $_POST[$this->repeatpassword];
			}
			return false;
		}

		//Kollar om användaren matat in något i lösenord inputen, returnera värdet annars falskt.
		public function getInputPassword()
		{
			if(isset($_POST[$this->password]))
			{
				return $_POST[$this->password];
			}
			return false;
		}

		//Kollar om användaren tryckt på lägga till betyg till livespelning med angivet band länken i menyn, returnerar sant annars falskt.
		public function didUserPressAddRating()
		{
			return isset($_GET[$this->addrating]);
		}

		//Kollar om användaren tryckt på lägga till band till livespelning länken i menyn, returnerar sant annars falskt.
		public function didUserPressAddBandToEvent()
		{
			return isset($_GET[$this->addbandtoevent]);
		}

		//Kollar om användaren tryckt på lägga till band länken i menyn, returnerar sant annars falskt.
		public function didUserPressAddBand()
		{
			return isset($_GET[$this->addband]);
		}

		//Kollar om användaren tryckt på ta bort betyg till livespelning med angivet band länken i menyn, returnerar sant annars falskt.
		public function didUserPressDeleteGrade()
		{
			return isset($_GET[$this->deleterating]);
		}

		
		
		// Visar logga in sidan.
		public function showLoginPage()
		{
			
			

			// Kontrollerar inloggningsstatus. Är användaren inloggad...Tilldelad kod.	
			if($this->model->checkLoginStatus())
			{				
				// ...visa användarsidan...Tilldelad kod.
				$contentString = "$this->message<p><a href='?logout'>Logga ut</a></p>";
				$this->loginStatus = $this->model->getLoggedInUser() . " är inloggad";
			}
			else 
			{
				
				
					
				$this->welcomemessage = "<h1 class='h1welcome'>Välkommen till Music-Live Review</h1>
				<h2 class='h2welcome'>Logga in för att se menyn. Utan konto? Registrera dig och logga in.</h2>
				<div class='divwelcome'>Musik Live Review handlar om att sätta betyg på livespelningar med band, det är ett lätt sätt att se på vilken livespelning som ett band presterar bäst.
				När du loggat in kan du lägga till livespelningar,band och koppla band till livespelningar. Du kan även Lägga till, editera och ta bort betyg på livespelningar med band.</div>";
				$this->loginStatus = "Ej inloggad";

				$contentString = 
					"<form id='loginForm' method=post action='?login'>
						<fieldset>
							<legend class='legendgradient'>Login - Skriv in användarnamn och lösenord</legend>
							$this->message
							<span class='spangradient' style='white-space: nowrap'>Namn:</span> <input type='text' name='$this->username' value='" . $this->getInputUsername() . "'>
							<span class='spangradient' style='white-space: nowrap'>Lösenord:</span> <input type='password' name='$this->password'><br> 
							<span class='spangradient' style='white-space: nowrap'>Håll mig inloggad:</span><input type='checkbox' name='$this->checkbox' value='checked'><br><br>
							<button type='submit' name='button' form='loginForm' value='Submit'>Logga in</button>
						</fieldset>
					</form>";
				
			}
			
			
			$HTMLbody = "
			<div class='divlogin'>
			$this->welcomemessage
			<div class='form'>
			<div class='loginstatus'>$this->loginStatus</div>
			<p><a href='?register'>Registrera ny användare</a></p>
			$contentString
			</div></div>";

			if($this->model->checkLoginStatus())
			{
				$HTMLbody = "<div class='divmenu'>
				<h2>$this->loginStatus</h2>
				$contentString<br>
				<h2>Meny</h2>
				<p><a href='?addevent'>Lägg till livespelning</a></p>
				<p><a href='?addband'>Lägg till band</a></p>
				<p><a href='?addbandtoevent'>Lägg till band till livespelning</a></p>
				<p><a href='?addrating'>Lägg till betyg till livespelning med angivet band</a></p>
				<p><a href='?editrating'>Editera betyg till livespelning med angivet band</a></p>
				<p><a href='?deleterating'>Ta bort betyg till livespelning med angivet band</a></p>
				<p><a href='?showevents'>Visa livespelningar med band samt betyg</a></p>
				</div>";
			}

			$this->echoHTML($HTMLbody);
		}

		// Visar login formulär med just registrerad användares uppgifter i användarnamn inputen.
		public function showLoginPageWithRegname()
		{
			
			
			
			// Kontrollerar inloggningsstatus. Är användaren inloggad...Tilldelad kod.	
			if($this->model->checkLoginStatus())
			{				
				// ...visa användarsidan...Tilldelad kod.
				$contentString = "
					$this->message
					<p><a href='?logout'>Logga ut</a></p>";
				$this->loginStatus = $this->model->getLoggedInUser() . " är inloggad";
			}
			else 
			{
					$this->welcomemessage = "<h1 class='h1welcome'>Välkommen till Music-Live Review</h1>
					<h2 class='h2welcome'>Logga in för att se menyn. Utan konto? Registrera dig och logga in.</h2>
					<div class='divwelcome'>Musik Live Review handlar om att sätta betyg på livespelningar med band, det är ett lätt att se på vilken livespelning som ett band presterar bäst.
					När du loggat in kan du lägga till livespelningar,band och koppla band till livespelningar. Du kan även Lägga till, editera och ta bort betyg pålivespelningar med band.</div>";
				
					// ...annars visas inloggningssidan.
					$this->loginStatus = "Ej inloggad";
					$contentString = 
					"<form id='loginForm' method=post action='?login'>
						<fieldset>
							<legend class='legendgradient'>Login - Skriv in användarnamn och lösenord</legend>
							$this->message
							<span class='spangradient' style='white-space: nowrap'>Namn:</span> <input type='text' name='$this->username' value='" . $this->getRegisterUsername() . "'>
							<span class='spangradient' style='white-space: nowrap'>Lösenord:</span> <input type='password' name='$this->password'> 
							<input type='checkbox' name='$this->checkbox' value='checked'>Håll mig inloggad:
							<button type='submit' name='button' form='loginForm' value='Submit'>Logga in</button>
						</fieldset>
					</form>";
				
			}
			
			$HTMLbody = "<div class='divlogin'>
			$this->welcomemessage
			<div class='form'>
			<div class='loginstatus'>$this->loginStatus</div>
			<p><a href='?register'>Registrera ny användare</a></p>
			$contentString
			</div></div>";
			
			$this->echoHTML($HTMLbody);
		}

		public function showRegisterPage(){

			
			
			// Kontrollerar inloggningsstatus. Är användaren inloggad...Tilldelad kod.	
			if($this->model->checkLoginStatus())
			{			
				
				// ...visa användarsidan...Tilldelad kod.
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
						<fieldset class='fieldregister'>
							<legend>Registrera ny användare - Skriv in användarnamn och lösenord</legend>
							$this->message
							<span style='white-space: nowrap'>Namn:</span><br> <input type='text' name='$this->createusername' value='". strip_tags($_POST[$this->createusername]) ."'><br>
							<span style='white-space: nowrap'>Lösenord:</span><br> <input type='password' name='$this->createpassword'><br>
							<span style='white-space: nowrap'>Repetera Lösenord:</span><br> <input type='password' name='$this->repeatpassword'><br>
							<span style='white-space: nowrap'>Skicka:</span> <input type='submit' name='$this->createuserbutton'  value='Registrera'>
						</fieldset>
					</form>";

					$HTMLbody = "<div class='divregister'>
					<p><a href='?login'>Tillbaka</a></p>
					<h2>$this->loginStatus</h2>
					$contentString<br>
					</div>";

					$this->echoHTML($HTMLbody);
			}

				
		}
		
		// Skapar cookies innehållande de medskickande värdena.Tilldelad kod.
		public function createCookies($usernameToSave, $passwordToSave)
		{
			// Bestämmer cookies livslängd.
			$cookieExpirationTime = time()+ 60;
			
			// Skapar cookies.Tilldelad kod.
			setcookie("Username", $usernameToSave, $cookieExpirationTime);
			setcookie("Password", $passwordToSave, $cookieExpirationTime);
			
			//Skapar en fil innehållande information om kakornas livslängd.Tilldelad kod.
			$this->model->createReferenceFile($cookieExpirationTime, "cookieExpirationTime");
		}
		
		//Söker efter kakor.
		public function searchForCookies()
		{
			if(isset($_COOKIE["Username"]) === true && isset($_COOKIE["Password"]) === true)
			{
				return true;
			}
			
			return false;
		}
		
		// Logga in med kakor.Tilldelad kod.
		public function loginWithCookies()
		{
			// Validera cookies mot textfilen.
			$this->model->validateExpirationTime();
			
			// Validera kakornas innehåll.
			$this->model->verifyUserInput($_COOKIE["Username"],$_COOKIE["Password"], true);
			
			// Visa rättmeddelande.
			$this->showMessage("Inloggningen lyckades via cookies");
		}
		
		// Tar bort alla cookies.Tilldelad kod.
		public function removeCookies()
		{
			foreach ($_COOKIE as $c_key => $c_value)
			{
				setcookie($c_key, NULL, 1);
			}
		}
		
		// Sparar angivet användarnamn i textfältet.Tilldelad kod.
		public function getInputUsername()
		{
			if(isset($_POST[$this->username]))
			{
				return $_POST[$this->username];
			}
			
			// Är inte användarnamnet satt skickas en tomsträng med.Tilldelad kod.
			return "";
		}
		
		// Visar eventuella meddelanden.Tilldelad kod.
		public function showMessage($message)
		{
			$this->message = "<p>" . $message . "</p>";
		}
		
		// Visar login-meddelande.Tilldelad kod.
		public function successfulLogin()
		{
			$this->showMessage("Inloggningen lyckades!");
		}
		
		// Visar login-meddelande för "Håll mig inloggad"-funktionen.Tilldelad kod.
		public function successfulLoginAndCookieCreation()
		{
			$this->showMessage("Inloggningen lyckades och vi kommer ihåg dig nästa gång");
		}
		
		// Visar logout-meddelande.Tilldelad kod.
		public function successfulLogout()
		{
			$this->showMessage("Du har nu loggat ut");
		}

		//Lägger in lyckat lägga till användare meddelande i funktionen showMessage.
		public function successfulRegistration()
		{
			$this->showMessage("Registrering av ny användare lyckades");
		}


		
	}
?>