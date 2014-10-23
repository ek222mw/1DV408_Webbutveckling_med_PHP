<?php

	require_once("./src/model/LoginModel.php");
	require_once("./src/view/LoginView.php");
	require_once("./src/model/DBDetails.php");
	require_once("./src/view/DeleteRatingView.php");


	class DeleteRatingController{


		private $loginview;
		private $loginmodel;
		private $db;
		private $deleteratingview;

		public function __construct(){

						
			// Skapar nya instanser av modell- & vy-klasser och lägger dessa i privata variabler.
			$this->loginmodel = new LoginModel();
			$this->loginview = new LoginView($this->loginmodel);
			$this->db = new DBDetails();
			$this->deleteratingview = new DeleteRatingView();


			$this->doControll();
		}

		/*Kontrollerar indata, om alla valideringar är uppfyllda så tas ett betyg bort, annars kastas ett felmeddelande.
		Anropar alltid doHTMLBody som har hand om kontroll av vilka vyer som ska visas. */
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

		//Kontrollerar vilket formulär som ska skrivas ut av vyn beroende på vilka olika knappar och/eller länkar användaren tryckt på.
		
		public function doHTMLBody()
		{

				$loggedinUser = $this->loginmodel->getLoggedInUser();
				$loggedinUserwithdetails = $this->db->fetchDeleteGradesWithSpecUser($loggedinUser);

				$this->deleteratingview->ShowDeleteRatingPage($loggedinUserwithdetails);
		}




	}