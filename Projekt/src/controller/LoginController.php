<?php
	
	require_once("./src/model/LoginModel.php");
	require_once("./src/view/LoginView.php");
	require_once("./src/model/DBDetails.php");
	class LoginController
	{
		private $view;
		private $model;
		private $db;
		
		public function __construct()
		{
			// Sparar ner användarens användaragent och ip. Används vid verifiering av användaren.
			$userAgent = $_SERVER['HTTP_USER_AGENT'];
						
			// Skapar nya instanser av modell- & vy-klassen.
			$this->model = new LoginModel($userAgent);
			$this->view = new LoginView($this->model);
			$this->db = new DBDetails();
			
			// Kontrollerar ifall det finns kakor och ifall användaren inte är inloggad.
			if($this->view->searchForCookies() && !$this->model->checkLoginStatus())
			{
				try
				{
					// Logga in med kakor.
					$this->view->loginWithCookies();
					
					
				}
				catch(Exception $e)
				{
					// Visar eventuella felmeddelanden.
					$this->view->showMessage($e->getMessage());
					
					// Tar bort de felaktiga kakorna.
					$this->view->removeCookies();
				}
			}
			else // Annars, visa standardsidan på normalt vis.
			{
				// Ifall användaren tryckt på "Logga in" och inte redan är inloggad...
				if($this->view->didUserPressLogin() && !$this->model->checkLoginStatus())
				{
					// ...så loggas användaren in.
					$this->doLogin();
				}
			
				// Ifall användaren tryckt på "Logga ut" och är inloggad...
				if($this->view->didUserPressLogout() && $this->model->checkLoginStatus())
				{
					// ...så loggas användaren ut.
					$this->doLogout();
				}

				if($this->view->didUserPressRegister() && !$this->view->didUserPressLogin() && !$this->model->checkLoginStatus())
				{
					$this->doRegister();
				}
			}
			if($this->model->checkLoginStatus() && $this->view->searchForCookies())
			{
				$this->view->showLoginPage();
			}
			if($this->model->checkLoginStatus() && !$this->view->searchForCookies())
			{
				
				$this->view->showLoginPage();
			}
		}
		
		// Hämtar sidans innehåll.
		public function doHTMLBody()
		{
			if(!$this->view->didUserPressRegister() && !$this->view->didUserPressLogin() && !$this->model->checkLoginStatus())
			{
				
				$this->view->showLoginPage();
			}
			
		}
		
		// Försöker verifiera och logga in användaren.
		public function doLogin()
		{
			
			// Kontrollerar ifall användaren tryckt på "Logga in" och inte redan är inloggad.
			if($this->view->didUserPressLogin() && !$this->model->checkLoginStatus())
			{
				
				// Kontrollerar indata
				$checkboxStatus = false;
				
				// Kontrollera ifall "Håll mig inloggad"-rutan är ikryssad.
				if(isset($_POST['checkbox']))
				{
					$checkboxStatus = true;
				}
				
				try
				{
					$inputUsername = $this->view->getInputUsername();
					$inputPassword = $this->view->getInputPassword();

					$this->model->verifyUserInput($inputUsername, crypt($inputPassword,"emile"));
					
					// Kontrollerar om "Håll mig inloggad"-rutan är ikryssad.
					if($checkboxStatus === true)
					{
						// Skapa cookies.
						$this->view->createCookies($inputUsername, crypt($inputPassword,"emile"));
						
						// Visar cookielogin-meddelande.
						$this->view->successfulLoginAndCookieCreation();
					}
					else
					{
						// Visar login-meddelande.
						$this->view->successfulLogin();
						
					}
				}
				catch(Exception $e)
				{
					// Visar eventuella felmeddelanden.
					$this->view->showMessage($e->getMessage());
				}
			}
			
				
			
				if(!$this->view->didUserPressLogout() && !$this->model->checkLoginStatus())
				{
					
					$this->view->showLoginPage();
				}




				
			
			
		}
		
		// Loggar ut användaren.
		public function doLogout()
		{
			// Kontrollera indata, tryckte användaren på Logga ut?
			if($this->view->didUserPressLogout() && $this->model->checkLoginStatus())
			{
				// Logga ut.
				$this->model->logOut();
				
				// Ifall det finns cookies...
				if($this->view->searchForCookies())
				{
					// ...ta bort dem.
					$this->view->removeCookies();
				}
				
				//Generera utdata, tillåt användaren att logga in igen.
				$this->doLogin();
				$this->view->successfulLogout();
			}
		}

		public function doRegister(){

			$registerUsername = $this->view->getRegisterUsername();
			$registerPassword = $this->view->getRegisterPassword();
			$registerRepeatPassword = $this->view->getRepeatRegisterPassword();

			if($this->view->didUserPressRegister() && !$this->view->didUserPressLogin() && !$this->model->checkLoginStatus())
			{
				try{

						
					if($this->view->didUserPressCreateUser())
					{
						
						
						
						if($this->model->CheckBothRegInput($registerUsername,$registerPassword))
						{
							if($this->model->CheckRegUsernameLength($registerUsername) && $this->model->CheckReqPasswordLength($registerPassword))
							{
								if($this->model->ComparePasswordRepPassword($registerPassword,$registerRepeatPassword))
								{

									if($this->db->ReadSpecifik($registerUsername))
									{
										if($this->model->ValidateUsername($registerUsername))
										{
											
											$this->model->addUsersetSuccess($registerUsername,crypt($registerPassword, "emile"));
											
											if($this->model->UserRegistered())
											{
												$this->view->successfulRegistration();
												$this->view->showLoginPageWithRegname();
												
											}

											
										}
									}
								}
								
							}
						}
					}
					
				}
				catch(Exception $e)
				{
					$this->view->showMessage($e->getMessage());
				}
				
			}
			if($this->model->UserRegistered() == false)
			{

			
			
				return $this->view->showRegisterPage();
			}
			
		


		}
	}
	
?>