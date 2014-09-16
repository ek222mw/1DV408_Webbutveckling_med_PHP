<?php


class loginView{


	private static $cookieUsername = "Username";
	private static $cookiePassword = "Password";

	public function UsernameAndPasswordCorrectMess(){

		return $UserPassCorrMess = "
				<h2>Admin är Inloggad</h2><br><br>
				<p>Inloggningen lyckades</p>
				<form method='post'>
				<input type='submit' name='Logout' value='Logga ut'>
				</form>
				";

	}

	public function CookieLoginMess(){

		return $CookieLogin =  "
				<h2>Admin är Inloggad</h2><br><br>
				<p>Inloggningen lyckades och vi kommer ihåg dig nästa gång</p>
				<form method='post'>
				<input type='submit' name='Logout' value='Logga ut'>
				</form>
				";
	}

	public function AlreadyLoggedInUser(){

		return $AlreadyLoggedinMess  = "
				<h2>Admin är Inloggad</h2><br>
				<form method='post'>
				<input type='submit' name='Logout' value='Logga ut'>
				</form>
				";
	}

	public function UsernameAndPasswordWrongMess(){

		return $UserPassWrongMess = "<h2>Ej Inloggad</h2><br><br>
				<p>Användarnamn saknas</p>
				";
	}

	public function UsernameCorrPasswordEmpty(){
		return $UserCorrPassEmptyMess = "<h2>Ej Inloggad</h2><br><br>
			<p>Lösenord saknas</p>
			";
	}

	public function UsernameEmptyPasswordCorr(){

		return $UserEmptyPassCorrMess = "<h2>Ej Inloggad</h2><br><br>
			<p>Användarnamn saknas</p>
			";
	}

	public function UsernameCorrAndPassWrong()
	{
		return $UserCorrPassWrongMess = "<h2>Ej Inloggad</h2><br><br>
			<p>Felaktigt användarnamn och/eller lösenord</p>
			";
	}

	public function NoInput()
	{
		return $StartMessage = "<h2>Ej Inloggad</h2><br><br>
			";
	}

	public function UsernameWrongAndPassCorr(){

		return $UserWrongPassCorrMess = "<h2>Ej Inloggad</h2><br><br>
			<p>Felaktigt användarnamn och/eller lösenord</p>
			";
	}

	public function UsernameAndPasswordEmpty(){

		return $UsernameAndPasswordEmpty = "<h2>Ej Inloggad</h2><br><br>
			<p>Användarnamn saknas</p>
			";
	}

	public function UserPressedLogout(){

		return $UserPressedLogoutMess = "<h2>Ej Inloggad</h2><br><br>
			<p>Du har nu loggat ut</p>
			";		
	}

	public function getUsername() {
		//Hämta och kontrollera att det finn användarnamn.

		

		if(isset($_POST['username']))
		{
			return $_POST['username'];
		}
		return false;
	}

	public function getPassword(){

		if(isset($_POST['password']))
		{
			return $_POST['password'];
		}
		return false;
	}
	public function getForm(){

	echo "
		<form method='post'>
	Användarnamn: <input type='text' name='username'>
	Lösenord: <input type='password' name='password'>
	Håll mig inloggad: <input type='checkbox' name='checkbox'>
	<input type='submit' name='Login' value='Logga in'>

	</form>";

	}

	public function displayForm($message){

	$this->render("$message
		<form method='post'>
	Användarnamn: <input type='text' name='username'>
	Lösenord: <input type='password' name='password'>
	Håll mig inloggad: <input type='checkbox' name='checkbox'>
	<input type='submit' name='Login' value='Logga in'>

	</form>","");


	}

	public function render($body,$title){




		setlocale(LC_ALL,"swedish");
	$weekday = ucwords((strftime("%A")));
	$day = ucwords((strftime("%d")));
	$month = ucwords((strftime("%B")));
	$year = ucwords((strftime("%Y")));
	$clock = ucwords((strftime("%H:%M:%S")));


	echo "

	<!DOCTYPE html>
	<html>
	<head>
	<meta charset='UTF-8'>
	<title>Labb 2</title>
	</head>
	<body>
		$body<br>
	".$weekday,", den ",$day," ",$month, " år ",$year,". Klockan är [",$clock,"]."."

	</body>

	</html>






			"	;
	}

	public function getRenderdoLogin(){


		setlocale(LC_ALL,"swedish");
	$weekday = ucwords((strftime("%A")));
	$day = ucwords((strftime("%d")));
	$month = ucwords((strftime("%B")));
	$year = ucwords((strftime("%Y")));
	$clock = ucwords((strftime("%H:%M:%S")));


	echo "

	<!DOCTYPE html>
	<html>
	<head>
	<meta charset='UTF-8'>
	<title>Labb 2</title>
	</head>
	<body>
		Ej Inloggad<br>
	".$weekday,", den ",$day," ",$month, " år ",$year,". Klockan är [",$clock,"]."."

	</body>

	</html>






			"	;


	}



	public function DisplayEmpty(){

	 return $this->displayForm($this->UsernameAndPasswordEmpty());
	}

	public function showLoginLogout(){
		return $this->displayForm($this->NoInput());
	}

	public function DisplayEmptyUsername(){

		return $this->displayForm($this->UsernameEmptyPasswordCorr());
	}

	public function DisplaySuccessfulLogin(){

		return $this->render($this->UsernameAndPasswordCorrectMess(),"");
	}

	public function DisplayEmptyPassword(){

		return $this->displayForm($this->UsernameCorrPasswordEmpty());
	}

	public function DisplayCorrUserWrongPass(){

		return $this->displayForm($this->UsernameCorrAndPassWrong());
	}

	public function DisplayWrongUserCorrPass(){

		return $this->displayForm($this->UsernameWrongAndPassCorr());
	}

	public function DisplayAlreadyLoggedin(){

		return $this->render($this->AlreadyLoggedInUser(),"");
	}

	public function DisplayUserPressedLogout(){

		return $this->displayForm($this->UserPressedLogout());
	}

	public function DisplaySuccessLoginCookie(){

		return $this->render($this->CookieLoginMess(),"");
	}

	public function echoHTML($html){

		echo $html;
	}

	public function didUserLogout(){

		if(isset($_POST['Logout']))
		{
			return true;
		}
		return false;
	}

	public function didUserLogin(){

		if(isset($_POST['Login']))
		{
			return true;
		}
		return false;

	}

	public function getCheckboxStatus(){

		if(isset($_POST['checkbox']))
		{
			return true;
		}
		return false;
	}

	public function makeUserCookies($stringUser){

		setcookie( self::$cookieUsername, $stringUser, -1);
	}

	public function makePasswordCookies($stringPass){

		setcookie( self::$cookiePassword, $stringPass, -1);	
	}

	public function loadUserCookies(){

		if(isset($_COOKIE[self::$cookieUsername]))
		{
			$returnstring = $_COOKIE[self::$cookieUsername];
		}
		else {
			$returnstring ="";
		}

		setcookie(self::$cookieUsername,"",time() -1);

		return $returnstring;

	}

	public function loadPassCookies(){

		if(isset($_COOKIE[self::$cookiePassword]))
		{
			$returnstr = $_COOKIE[self::$cookiePassword];
		}
		else{
			$returnstr = "";
		}

		setcookie(self::$cookiePassword,"",time() -1);

		return $returnstr;
	}





}
