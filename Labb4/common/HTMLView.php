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
				<body>
						$body
					</body>
				</html>";
		}
	}
?>