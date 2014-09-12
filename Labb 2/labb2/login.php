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
			}
		}else
		{
			if($this->m_loginView->didUserLogin()){
				$this->m_loginModel->Login();
			}

		}
		

		






		if($this->m_loginView->didUserLogin())
		{
			var_dump(empty($this->m_loginView->getUsername()));
			var_dump(empty($this->m_loginView->getPassword()));	
			var_dump($this->m_loginView->getUsername());
			var_dump($this->m_loginView->getPassword());
			

			if(empty($this->m_loginView->getUsername()) && empty($this->m_loginView->getPassword()))
			{
				return $this->m_loginView->DisplayEmpty();
				 
			}
			elseif(empty($this->m_loginView->getUsername() && $this->m_loginView->getPassword()))
			{
				return $this->m_loginView->DisplayEmptyUsername();
			}
			elseif(
				$this->m_loginModel->comparePassword(
					$this->m_loginView->getUsername(), $this->m_loginView->getPassword()
				)
			)
			{	
				return $this->m_loginView->DisplaySuccessfulLogin();
			}
		}
		
		return $this->m_loginView->showLoginLogout();
		

			
		
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