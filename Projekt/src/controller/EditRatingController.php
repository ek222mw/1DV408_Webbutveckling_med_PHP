<?php 
	
	require_once("./src/model/LoginModel.php");
	require_once("./src/view/LoginView.php");
	require_once("./src/model/DBDetails.php");
	require_once("./src/view/EditRatingView.php");

	class EditRatingController{

		private $loginview;
		private $loginmodel;
		private $db;
		private $editratingview;

		public function __construct(){
						
			// Skapar nya instanser av modell- & vy-klasser och lägger dessa i privata variabler.
			$this->loginmodel = new LoginModel();
			$this->loginview = new LoginView($this->loginmodel);
			$this->db = new DBDetails();
			$this->editratingview = new EditRatingView();


			$this->doControll();
		}

		/*Kontrollerar om valideringen av indata är korrekt, då editeras betyg.Annars kastas felmeddelande.Anropar alltid
		doHTMLBody som kontrollerar vilken vy som ska anropas. */
		public function doControll()
		{
			if($this->loginview->didUserPressEditGrades() && $this->loginmodel->checkLoginStatus())
			{
				$pickedid = $this->editratingview->getEditPickedValueSaved();
				$loggedinUser = $this->loginmodel->getLoggedInUser();
				$neweditgrade = $this->editratingview->getDropdownPickedEditGrade();

				try
				{
					if($this->editratingview->didUserPressEditGradeButton())
					{
						if($this->db->checkIfIdManipulated($pickedid,$loggedinUser))
						{
							if($this->db->checkIfPickRatingManipulated($neweditgrade))
							{
								$this->db->EditGrades($neweditgrade,$pickedid);
								$this->editratingview->successfulEditGradeToEventWithBand();
							}
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

		//Kontrollerar vilket formulär som ska skrivas ut av vyn beroende på vilka olika knappar och/eller länkar användaren tryckt på.
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

				$pickedid = $this->editratingview->getEditPickedValue();
				$pickedgradetoEdit = $this->db->fetchIdPickedEditGrades($pickedid);
				$newgrade = $this->db->fetchAllGrades();

				$this->editratingview->ShowChosenEditRatingPage($pickedgradetoEdit, $newgrade);
			}

		}


	}