<?php



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
<form>
Användarnamn: <input type='text' name='username'>
Lösenord: <input type='text' name='password'>
Håll mig inloggad: <input type='checkbox' name='checkbox'>
<input type='submit' value='Logga in'>

</form>
".$weekday,", den ",$day," ",$month, " år ",$year,". Klockan är [",$clock,"]."."

</body>

</html>






		"	;


	$server = "127.0.0.1";
    $username = "root";
    $password = "";
    $database = "login";
 
    $db_handle = mysql_connect($server, $username, $password);
    $db_found = mysql_select_db($database, $db_handle);
     
    if ($db_found) {
 
        $sql = "SELECT * FROM login";
        $result = mysql_query($sql);
     
        while ($db_field = mysql_fetch_assoc($result)) {
            print "<b>ID</b>: " .$db_field['id']. " ";
            print "<b>Username</b>: " .$db_field['username']. " ";
            print "<b>Password</b>: " .$db_field['password']. "<br/>";
        }
     
        mysql_close($db_handle);
    } else {
        print "Error: Unable to find Database";
        mysql_close($db_handle);
    }








?>
