<!DOCTYPE html>
<html lang="en">
	<head>

	</head>
	<body>
		<header>
			<h1>Office Hours - Confirmation Page</h1>
		</header>
		<main>
		
		<?php
		
		$db = new PDO("mysql:dbname=344_project;host=localhost", "root");
		
		$name = $_POST["personname"];
		$email = $_POST["personemail"];
		
		
		foreach ($_POST as $variable)
		{
			if(strlen(startsWith($variable, "start")) > 0)
			{
				$start_time = explode("start", $variable)[1]; 	
				echo $start_time;
				//echo $variable;
			}
			
		}
		
		foreach ($_POST as $variable)
		{
			if(strlen(startsWith($variable, "end")) > 0)
			{
				$end_time = explode("end", $variable)[1]; 	
				echo $end_time;
				
			}
		}
		
		/*this is very close to working...
		$db->query("INSERT INTO `office_hours` (`faculty_id`, `day`, `start_time`, `end_time`) VALUES
			('7777','R','$start_time','$end_time')");
		*/
		
		
		
		
		/***this works to pull data from the DB and print
		$rows = $db->query("SELECT * FROM `faculty`;");
		
		foreach ($rows as $row) {
			
		print $row["name"];
		}
		*/
		
		print "Your office hours have been updated.";
		
		
		?>
		
		<?php
		
		function startsWith($haystack, $needle)
		{
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
		}
		
		
		?>
		
			
			
		</main>
	</body>
</html>