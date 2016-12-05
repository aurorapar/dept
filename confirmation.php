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
		$days = Array('M', 'T', 'W', 'R', 'F');
		$name = $_POST["personname"];
		$email = $_POST["personemail"];
		
		extract($_POST);
		$count=0;
		$arraynum=0;
		foreach ($_POST as $variable)
		{
			
			if(strlen(startsWith($variable, "start")) > 0)
			{
				
				$start_time = explode("start", $variable)[1];
			    $theDay= $days[$arraynum];
				echo $start_time;
				//echo $variable;
			}
			if(strlen(startsWith($variable, "end")) > 0)
			{
				$end_time = explode("end", $variable)[1]; 
					
				echo $end_time;
				
			}
			if(isset($start_time)&&isset($end_time))
			{
			
			$db->query("INSERT INTO `office_hours` (`faculty_id`, `day`, `start_time`, `end_time`) VALUES
			('9934','$theDay','$start_time','$end_time')");
			$start_time=null;
			$end_time=null;
			}
			$count=$count+1;
		
			if($count>=6)
			{  $arraynum= $arraynum+1;
			
				$count=0;
			}
		}
	
		
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