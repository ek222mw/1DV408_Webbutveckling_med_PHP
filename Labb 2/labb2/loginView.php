<?php


class loginView{

	public function UsernameAndPasswordCorrectMess(){

		return $UserPassCorrMess = "
				<h2>Admin är Inloggad</h2><br><br>
				<p>Inloggningen lyckades</p>
				<input type='submit' name='Logout' value='Logga ut'>
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

return "
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

public function DisplayEmpty(){

 return $this->displayForm($this->UsernameAndPasswordEmpty());
}

public function showLoginLogout(){
	return $this->getForm();
}

public function DisplayEmptyUsername(){

	return $this->displayForm($this->UsernameEmptyPasswordCorr());
}

public function DisplaySuccessfulLogin(){

	return $this->render($this->UsernameAndPasswordCorrectMess(),"");
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
}
