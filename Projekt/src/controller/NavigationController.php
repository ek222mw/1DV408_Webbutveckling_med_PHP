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

		private $model;
		private $view;
			
		public function __construct(){
			
						
			// Skapar nya instanser av modell- & vy-klassen och lägger dessa i privata variabler.
			$this->model = new LoginModel();
			$this->view = new LoginView($this->model);

			//Väljer vilken controller som ska användas beroende på indata, t.ex. knappar och länkar.
			if(!$this->view->didUserPressAddEvent() && !$this->view->didUserPressAddRating() && !$this->view->didUserPressAddBandToEvent() && !$this->view->didUserPressAddBand() && 
				!$this->view->didUserPressShowAllEvents() && !$this->view->didUserPressEditGrades() && !$this->view->didUserPressDeleteGrade())
			{
				$loginC = new LoginController();
				$htmlBodyLogin = $loginC->doHTMLBody();
			}
			
			else if(($this->view->didUserPressAddEvent() || $this->view->didUserPressAddBandToEvent() || $this->view->didUserPressAddBand()) && $this->model->checkLoginStatus())
			{
				$AddEventBandC = new AddBandEventController();
				
			}

			else if($this->view->didUserPressAddRating() && $this->model->checkLoginStatus())
			{
				$AddRatingC = new AddRatingController();
			}

			else if($this->view->didUserPressShowAllEvents() && $this->model->checkLoginStatus())
			{
				$ShowEventsC = new ShowEventController();
			}

			else if($this->view->didUserPressEditGrades() && $this->model->checkLoginStatus())
			{	
				$EditRatingC = new EditRatingController();
			}

			else if($this->view->didUserPressDeleteGrade() && $this->model->checkLoginStatus())
			{
				$DeleteRatingC = new DeleteRatingController();
			}
			else{

				$loginControl = new LoginController();
				$htmlBodyLogin = $loginControl->doHTMLBody();
			}
			

			

			
		}


	}