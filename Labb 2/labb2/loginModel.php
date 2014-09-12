<?php

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

	public function comparePassword($username, $password){

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

	public function isLoggedIn()
	{
		if(isset($_SESSION["SessionUsername"])){

		$saveUserSession = $_SESSION["SessionUsername"];
		return true;
		}
		return false;
	}

	public function Logout(){

		
		unset($saveUserSession);


	}

	public function Login(){

		$saveUserSession = true;
	}

	

}