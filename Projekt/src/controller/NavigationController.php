<?php

	require_once("./common/HTMLView.php");
	require_once("LoginController.php");
	require_once("AddBandEventController.php");
	require_once("./src/model/LoginModel.php");
	require_once("./src/view/LoginView.php");
	require_once("AddRatingController.php");
	require_once("ShowEventController.php");
	require_once("EditRatingController.php");
	require_once("DeleteRatingController.php");
	
	
	class NavigationController{

			
		public function __construct(){
			$userAgent = $_SERVER['HTTP_USER_AGENT'];
						
			// Skapar nya instanser av modell- & vy-klassen.
			$this->model = new LoginModel($userAgent);
			$this->view = new LoginView($this->model);

			
			if(!$this->view->didUserPressAddEvent() && !$this->view->didUserPressAddRating() && !$this->view->didUserPressAddBandToEvent() && !$this->view->didUserPressAddBand() && 
				!$this->view->didUserPressShowAllEvents() && !$this->view->didUserPressEditGrades() && !$this->view->didUserPressDeleteGrade())
			{
				$loginC = new LoginController();
				$htmlBodyLogin = $loginC->doHTMLBody();
			}


			if(($this->view->didUserPressAddEvent() || $this->view->didUserPressAddBandToEvent() || $this->view->didUserPressAddBand()) && $this->model->checkLoginStatus())
			{
				$AddEventBandC = new AddBandEventController();
				
			}


			if($this->view->didUserPressAddRating() && $this->model->checkLoginStatus())
			{
				$AddRatingC = new AddRatingController();
			}

			if($this->view->didUserPressShowAllEvents() && $this->model->checkLoginStatus())
			{
				$ShowEventsC = new ShowEventController();
			}

			if($this->view->didUserPressEditGrades() && $this->model->checkLoginStatus())
			{	
				$EditRatingC = new EditRatingController();
			}

			if($this->view->didUserPressDeleteGrade() && $this->model->checkLoginStatus())
			{
				$DeleteRatingC = new DeleteRatingController();
			}



			
		}


	}