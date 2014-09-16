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

		
		
		
		if($this->m_loginModel->isLoggedIn()){
			if($this->m_loginView->didUserLogout()){
				$this->m_loginModel->Logout();
				$this->m_loginView->DisplayUserPressedLogout();
			}else
			{
				
				$this->m_loginView->DisplayAlreadyLoggedin();
			}
		}
		

		






		if($this->m_loginView->didUserLogin())
		{
			//kanske måste vara såhär på webbhotelet;
			//$username = $this->m_loginView->getUsername();
			

			if(empty($this->m_loginView->getUsername()) && empty($this->m_loginView->getPassword()))
			{
				$this->m_loginView->DisplayEmpty();
				 
			}
			elseif(empty($this->m_loginView->getUsername()) && $this->m_loginView->getPassword())
			{
				$this->m_loginView->DisplayEmptyUsername();
			}
			elseif(empty($this->m_loginView->getPassword()) && $this->m_loginView->getUsername())
			{
				$this->m_loginView->DisplayEmptyPassword();
			}
			
			elseif($this->m_loginModel->comparePasswordSucced($this->m_loginView->getUsername(), $this->m_loginView->getPassword()))
			{	

				$this->m_loginModel->Login();
				if($this->m_loginView->getCheckboxStatus())
				{
				$this->m_loginView->makeUserCookies($this->m_loginView->getUsername());
				$this->m_loginView->makePasswordCookies($this->m_loginView->getPassword());
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
			
		}


		if(!$this->m_loginModel->isLoggedIn() && !$this->m_loginView->didUserLogout() && !$this->m_loginView->didUserLogin())
		{
			$this->m_loginView->showLoginLogout();
		}
		
		

			
		
		//Successful login.
		
		
		/*else{
			/*echo "<h2>Ej Inloggad</h2><br><br>
			<p>Användaren finns ej</p>
			";
			echo '<META HTTP-EQUIV="Refresh" content="2; URL=http://127.0.0.1/Labb2/index.php">';*/
			//$this->m_loginView->displayForm();
		//}
	}

}
?>