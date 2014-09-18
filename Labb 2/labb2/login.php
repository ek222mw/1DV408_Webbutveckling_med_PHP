<?php

require_once("loginView.php");
require_once("loginModel.php");



class login{

private $m_loginView;
private $m_loginModel;
public function __construct(){

$this->m_loginView = new loginView();
$this->m_loginModel = new loginModel();

}

		public function doControll(){

			//handle input 

		
		
		$this->m_loginView->setAgent2();
		if($this->m_loginModel->isLoggedIn() && $this->m_loginModel->compareAgent($this->m_loginView->getAgent2())){
			if($this->m_loginView->didUserLogout()){
				$this->m_loginModel->Logout();
				$this->m_loginView->DisplayUserPressedLogout();
			}else
			{
				
				$this->m_loginView->DisplayAlreadyLoggedin();
				
			}
		}
		elseif(!$this->m_loginModel->isLoggedIn() && $this->m_loginView->loadUserCookies() != NULL && $this->m_loginView->loadPassCookies() != NULL){
			
			if($this->m_loginView->checkCookieTime())
			{
				if($this->m_loginModel->comparePasswordSucced($this->m_loginView->loadUserCookies(), $this->m_loginModel->decodePassword($this->m_loginView->loadPassCookies())))
				{
				$this->m_loginView->DisplaySuccessLoginCookieNoSess();
				$this->m_loginModel->Login();
				$this->m_loginView->setAgent();
				$this->m_loginModel->setAgent($this->m_loginView->getAgent());
				}
				else{
					$this->m_loginView->DisplayWrongCookieDetNoSess();
				}
			}else{
				
				$this->m_loginView->DisplayTryManipulateCookieNoSess();	
			}

		}

						

					
		

		






		if($this->m_loginView->didUserLogin())
		{
			//kanske måste vara såhär på webbhotelet;
			//$username = $this->m_loginView->getUsername();
			$inputUsername = $this->m_loginView->getUsername();
			$inputPassword = $this->m_loginView->getPassword();

			if(empty($inputUsername) && empty($inputPassword))
			{
				$this->m_loginView->DisplayEmpty();
				 
			}
			elseif(empty($inputUsername) && $this->m_loginView->getPassword())
			{
				$this->m_loginView->DisplayEmptyUsername();
			}
			elseif(empty($inputPassword) && $this->m_loginView->getUsername())
			{
				$this->m_loginView->DisplayEmptyPassword();
			}
			
			elseif($this->m_loginModel->comparePasswordSucced($this->m_loginView->getUsername(), $this->m_loginView->getPassword()))
			{	

				$this->m_loginModel->Login();
				$this->m_loginView->setAgent();
				$this->m_loginModel->setAgent($this->m_loginView->getAgent());
				

				if($this->m_loginView->getCheckboxStatus())
				{
					$this->m_loginView->makeUserCookies($this->m_loginView->getUsername());
					$this->m_loginView->makePasswordCookies($this->m_loginModel->encryptPassword($this->m_loginView->getPassword()));
					$this->m_loginView->DisplaySuccessLoginCookie();
					
					
				
				}
				else{
					$this->m_loginView->DisplaySuccessfulLogin();
				}

			}
			elseif($this->m_loginModel->comparePasswordWrongPass(
					$this->m_loginView->getUsername(), $this->m_loginView->getPassword()
				)
			)
			{	
				$this->m_loginView->DisplayCorrUserWrongPass();
			}
			elseif(
				$this->m_loginModel->comparePasswordWrongUsername(
					$this->m_loginView->getUsername(), $this->m_loginView->getPassword()
				)
			)
			{	
				$this->m_loginView->DisplayWrongUserCorrPass();
			}
			elseif(
				$this->m_loginModel->comparePasswordAllWrong(
					$this->m_loginView->getUsername(), $this->m_loginView->getPassword()
				)
			)
			{	
				$this->m_loginView->DisplayAllWrong();
			}
			
		}
        

		if(!$this->m_loginModel->isLoggedIn() && !$this->m_loginView->didUserLogout() && !$this->m_loginView->didUserLogin() 
			&& $this->m_loginView->loadUserCookies() == NULL && $this->m_loginView->loadPassCookies() == NULL
			)
		{
			$this->m_loginView->showLoginLogout();
		}
		
	

	}

}
?>