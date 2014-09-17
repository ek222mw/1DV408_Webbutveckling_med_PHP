<?php

session_start();

class loginModel{


	private  $dbusername = "root";
	private  $server = "127.0.0.1";
	private  $dbpassword = "";
	private  $database = "login";

	private function connectdb(){

		
		 $db_handle = mysql_connect($this->server, $this->dbusername, $this->dbpassword);
		 $db_found = mysql_select_db($this->database, $db_handle);

		 if($db_found){
		 	return $db_handle;
		 }else {
		        print "Error: Unable to find Database";
		        mysql_close($db_handle);
		    }

	}

	public function comparePasswordSucced($username, $password){

		$db_handle = $this->connectdb();
		$sql = "SELECT * FROM login";
		$result = mysql_query($sql);
		     
		while ($db_field = mysql_fetch_assoc($result)) {
		            
		$db_username = $db_field['username'];
		$db_password = $db_field['password'];
		}
		     
		 mysql_close($db_handle);

		 


		 if($username == $db_username && $password == $db_password)
		 {
		 	return true;
		 }

		 return false;




	}

	public function encryptPassword($pw){

		return base64_encode($pw);
	}

	public function decodePassword($pwcrypt){

		return base64_decode($pwcrypt);
	}




	public function comparePasswordWrongPass($username, $password){

		$db_handle = $this->connectdb();
		$sql = "SELECT * FROM login";
		$result = mysql_query($sql);
		     
		while ($db_field = mysql_fetch_assoc($result)) {
		            
		$db_username = $db_field['username'];
		$db_password = $db_field['password'];
		}
		     
		 mysql_close($db_handle);

		 if($username == $db_username && $password !== $db_password)
		 {
		 	return true;
		 }

		 return false;




	}	

	public function comparePasswordWrongUsername($username, $password){

		$db_handle = $this->connectdb();
		$sql = "SELECT * FROM login";
		$result = mysql_query($sql);
		     
		while ($db_field = mysql_fetch_assoc($result)) {
		            
		$db_username = $db_field['username'];
		$db_password = $db_field['password'];
		}
		     
		 mysql_close($db_handle);

		 if($username !== $db_username && $password == $db_password)
		 {
		 	return true;
		 }

		 return false;




	}	

	public function comparePasswordAllWrong($username, $password){

		$db_handle = $this->connectdb();
		$sql = "SELECT * FROM login";
		$result = mysql_query($sql);
		     
		while ($db_field = mysql_fetch_assoc($result)) {
		            
		$db_username = $db_field['username'];
		$db_password = $db_field['password'];
		}
		     
		 mysql_close($db_handle);

		 if($username !== $db_username && $password !== $db_password)
		 {
		 	return true;
		 }

		 return false;




	}	


	public function isLoggedIn()
	{

		if(isset($_SESSION["SessionUsername"])){

		$saveUserSession = $_SESSION["SessionUsername"];
		return true;
		}
		return false;
	}

	public function Logout(){

		
		session_unset($_SESSION["SessionUsername"]);


	}

	public function Login(){

		$_SESSION["SessionUsername"] = true;

	}

	public function setAgent($agent){

		if(isset($_SESSION["SessionAgent"]) == false)
		{
			$_SESSION["SessionAgent"] = $agent;
			return true;
		}
		return false;
	}

	public function compareAgent($agent){
			var_dump($agent, $_SESSION['SessionAgent']);
		if($_SESSION['SessionAgent'] === $agent){
			return true;

		} 
		return false;
	}





	

}