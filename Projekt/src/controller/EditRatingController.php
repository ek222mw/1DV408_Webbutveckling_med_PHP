<?php 
	
	require_once("./src/model/LoginModel.php");
	require_once("./src/view/LoginView.php");
	require_once("./src/model/AddBandEventModel.php");
	require_once("./src/view/AddBandEventView.php");
	require_once("./src/view/AddRatingView.php");
	require_once("./src/model/AddRatingModel.php");
	require_once("./src/model/DBDetails.php");
	require_once("./src/view/EditRatingView.php");

	class EditRatingController{

		private $loginview;
		private $loginmodel;
		private $addeventmodel;
		private $addeventview;
		private $addratingview;
		private $addratingmodel;
		private $db;
		private $editratingview;

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


			$this->doControll();
		}

		public function doControll()
		{
			if($this->loginview->didUserPressEditGrades() && $this->loginmodel->checkLoginStatus())
			{
				$pickedid = $this->editratingview->getEditPickedButtonValueSaved();
				$loggedinUser = $this->loginmodel->getLoggedInUser();
				$neweditgrade = $this->editratingview->getDropdownPickedEditGrade();
				try
				{
					if($this->editratingview->didUserPressEditGradeButton())
					{
						if($this->db->checkIfIdManipulated($pickedid,$loggedinUser))
						{
							$this->db->EditGrades($neweditgrade,$pickedid);
							$this->editratingview->successfulEditGradeToEventWithBand();
						}
					}

				}
				catch(Exception $e)
				{
					$this->editratingview->showMessage($e->getMessage());
				}

			}

			$this->doHTMLBody();
		}

		public function doHTMLBody()
		{
			
			if(!$this->editratingview->didUserPressEditPickedButton())
			{
				$loggedinUser = $this->loginmodel->getLoggedInUser();
				$loggedinUserwithdetails = $this->db->fetchEditGrades($loggedinUser);

				$this->editratingview->ShowEditRatingPage($loggedinUserwithdetails);
			}

			if($this->editratingview->didUserPressEditPickedButton())
			{

				$pickedid = $this->editratingview->getEditPickedButtonValue();
				$pickedgradetoEdit = $this->db->fetchIdPickedEditGrades($pickedid);
				$newgrade = $this->db->fetchAllGrades();

				$this->editratingview->ShowChosenEditRatingPage($pickedgradetoEdit, $newgrade);
			}

		}


	}