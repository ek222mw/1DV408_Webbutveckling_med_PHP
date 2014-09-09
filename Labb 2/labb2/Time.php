<?php

class Time{

public function getTime(){

echo(strftime("%B %d %Y, %X %Z",mktime(20,0,0,12,31,98))."<br>");
setlocale(LC_ALL,"hu_HU.UTF8");
echo(strftime("%Y. %B %d. %A. %X %Z"));
	
}


}


?>