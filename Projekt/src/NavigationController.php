<?php

	require_once("./common/HTMLView.php");
	require_once("LoginController.php");
	require_once("AddBandEventController.php");
	require_once("src/LoginModel.php");
	require_once("src/LoginView.php");
	
	
	class NavigationController{

			
		public function __construct(){
			$userAgent = $_SERVER['HTTP_USER_AGENT'];
						
			// Skapar nya instanser av modell- & vy-klassen.
			$this->model = new LoginModel($userAgent);
			$this->view = new LoginView($this->model);

			
			if(!$this->view->didUserPressAddEvent())
			{
				$loginC = new LoginController();
				$htmlBodyLogin = $loginC->doHTMLBody();
			}

			if($this->view->didUserPressAddEvent() && $this->model->checkLoginStatus())
			{
				$AddEventBandC = new AddBandEventController();
				$htmlBodyAddBandEvent = $AddEventBandC->doHTMLBody();
			}
		}


	}