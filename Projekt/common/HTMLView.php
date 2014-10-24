<?php
	
	class HTMLView
	{
		public function echoHTML($body)
		{
			echo "
				<!DOCTYPE html>
				<html>
				<head>
				<title>
				Music-Live Review
				</title>
				<meta charset='utf-8'>
				<link rel='stylesheet' type='text/css' href='./css/main.css' />
				</head>
				<body>
						$body
					</body>
				</html>";
		}
	}
?>