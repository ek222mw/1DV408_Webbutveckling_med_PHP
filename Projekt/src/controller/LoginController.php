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
						
			// Skapar nya instanser av modell- & vy-klassen och lägger dessa i privata variabler.
			$this->model = new LoginModel();
			$this->view = new LoginView($this->model);
			$this->db = new DBDetails();
			
			// Kontrollerar ifall det finns kakor och ifall användaren inte är inloggad.Tilldelad kod.
			if($this->view->searchForCookies() && !$this->model->checkLoginStatus())
			{
				try
				{
					// Logga in med kakor.Tilldelad kod.
					$this->view->loginWithCookies();
					
					
				}
				catch(Exception $e)
				{
					// Visar eventuella felmeddelanden.Tilldelad kod.
					$this->view->showMessage($e->getMessage());
					
					// Tar bort de felaktiga kakorna.Tilldelad kod.
					$this->view->removeCookies();
				}
			}
			else // Annars, visa standardsidan på normalt vis.Tilldelad kod.
			{
				// Ifall användaren tryckt på "Logga in" och inte redan är inloggad...Tilldelad kod.
				if($this->view->didUserPressLogin() && !$this->model->checkLoginStatus())
				{
					// ...så loggas användaren in.Tilldelad kod.
					$this->doLogin();
				}
			
				// Ifall användaren tryckt på "Logga ut" och är inloggad...Tilldelad kod.
				if($this->view->didUserPressLogout() && $this->model->checkLoginStatus())
				{
					// ...så loggas användaren ut.Tilldelad kod.
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
		
		// Försöker verifiera och logga in användaren.Tilldelad kod.Tilldelad kod.
		public function doLogin()
		{
			
			// Kontrollerar ifall användaren tryckt på "Logga in" och inte redan är inloggad.Tilldelad kod.Tilldelad kod.
			if($this->view->didUserPressLogin() && !$this->model->checkLoginStatus())
			{
				
				// Kontrollerar indata.Tilldelad kod.
				$checkboxStatus = false;
				
				// Kontrollera ifall "Håll mig inloggad"-rutan är ikryssad.Tilldelad kod.
				if(isset($_POST['checkbox']))
				{
					$checkboxStatus = true;
				}
				
				try
				{
					$inputUsername = $this->view->getInputUsername();
					$inputPassword = $this->view->getInputPassword();

					$this->model->verifyUserInput($inputUsername, $this->model->cryptPassword($inputPassword));
					
					// Kontrollerar om "Håll mig inloggad"-rutan är ikryssad.
					if($checkboxStatus === true)
					{
						// Skapa cookies.
						$this->view->createCookies($inputUsername, $this->model->cryptPassword($inputPassword));
						
						// Visar cookielogin-meddelande.Tilldelad kod.Tilldelad kod.
						$this->view->successfulLoginAndCookieCreation();
					}
					else
					{
						// Visar login-meddelande.Tilldelad kod.
						$this->view->successfulLogin();
						
					}
				}
				catch(Exception $e)
				{
					// Visar eventuella felmeddelanden.Tilldelad kod.
					$this->view->showMessage($e->getMessage());
				}
			}
			
				
			//Kontrollerar om användaren inte tryckt på logga ut knappen och inte är inloggad så anropa logga in sidan i vyn.
			if(!$this->view->didUserPressLogout() && !$this->model->checkLoginStatus())
			{
					
				$this->view->showLoginPage();
			}




				
			
			
		}
		
		// Loggar ut användaren.Tilldelad kod.
		public function doLogout()
		{
			// Kontrollera indata, tryckte användaren på Logga ut?Tilldelad kod.
			if($this->view->didUserPressLogout() && $this->model->checkLoginStatus())
			{
				// Logga ut.Tilldelad kod.
				$this->model->logOut();
				
				// Ifall det finns cookies...Tilldelad kod.
				if($this->view->searchForCookies())
				{
					// ...ta bort dem.Tilldelad kod.
					$this->view->removeCookies();
				}
				
				//Generera utdata, tillåt användaren att logga in igen.Tilldelad kod.
				$this->doLogin();
				$this->view->successfulLogout();
			}
		}

		//Kontrollerar indata om allt är uppfyllt så registreras en ny användare med inmatade uppgifter annars kastas undantag som innehåller felmeddelande.
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
										if($this->model->ValidateInput($registerUsername))
										{
											
											$this->model->addUsersetSuccess($registerUsername,$this->model->cryptPassword($registerPassword));
											
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

			//Kontrollerar om uttrycket är falskt så anropas registrerings sidan i vyn.
			if($this->model->UserRegistered() == false)
			{

				return $this->view->showRegisterPage();
			}
			
		


		}
	}
	
?>