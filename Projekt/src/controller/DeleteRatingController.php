<?php

	require_once("./src/model/LoginModel.php");
	require_once("./src/view/LoginView.php");
	require_once("./src/model/AddBandEventModel.php");
	require_once("./src/view/AddBandEventView.php");
	require_once("./src/view/AddRatingView.php");
	require_once("./src/model/AddRatingModel.php");
	require_once("./src/model/DBDetails.php");
	require_once("./src/view/EditRatingView.php");
	require_once("./src/view/DeleteRatingView.php");


	class DeleteRatingController{


		private $loginview;
		private $loginmodel;
		private $addeventmodel;
		private $addeventview;
		private $addratingview;
		private $addratingmodel;
		private $db;
		private $editratingview;
		private $deleteratingview;

		public function __construct(){

			// Sparar ner användarens användaragent och ip. Används vid verifiering av användaren.
			$userAgent = $_SERVER['HTTP_USER_AGENT'];
						
			// Skapar nya instanser av modell- & vy-klasser.
			$this->loginmodel = new LoginModel($userAgent);
			$this->loginview = new LoginView($this->loginmodel);
			$this->addeventmodel = new AddBandEventModel();
			$this->addeventview = new AddBandEventView($this->loginmodel);
			$this->addratingview = new AddRatingView($this->loginmodel);
			$this->addratingmodel = new AddRatingModel();
			$this->db = new DBDetails();
			$this->editratingview = new EditRatingView();
			$this->deleteratingview = new DeleteRatingView();


			$this->doControll();
		}

		public function doControll()
		{
			if($this->loginview->didUserPressDeleteGrade() && $this->loginmodel->checkLoginStatus())
			{
				$loggedinUser = $this->loginmodel->getLoggedInUser();
				$pickedid = $this->deleteratingview->getDeletePickedValue();

				try{

					if($this->deleteratingview->didUserPressDeleteGradeButton())
					{
						if($this->db->checkIfIdManipulated($pickedid,$loggedinUser))
						{
							$this->db->DeleteGrades($pickedid);
							$this->deleteratingview->successfulDeleteGradeToEventWithBand();
						}
					}

				}
				catch(Exception $e)
				{
					$this->deleteratingview->showMessage($e->getMessage());
				}

			}


			$this->doHTMLBody();
		}

		public function doHTMLBody()
		{

				$loggedinUser = $this->loginmodel->getLoggedInUser();
				$loggedinUserwithdetails = $this->db->fetchDeleteGradesWithSpecUser($loggedinUser);

				$this->deleteratingview->ShowDeleteRatingPage($loggedinUserwithdetails);
		}




	}