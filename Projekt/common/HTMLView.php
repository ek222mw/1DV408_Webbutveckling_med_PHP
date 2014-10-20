<?php
	
	class HTMLView
	{
		public function echoHTML($body)
		{
			echo "
				<!DOCTYPE html>
				<html>
				<head>
				<meta charset='iso-8859-1'>
				<link rel='stylesheet' type='text/css' href='./css/main.css' />
				</head>
				<body>
						$body
					</body>
				</html>";
		}
	}
?>