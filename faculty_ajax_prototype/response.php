<?php 
$teacher = $_POST["teacher"];
$db = new PDO("mysql:dbname=344_project;host=localhost","root");
$query = "SELECT * FROM `faculty` WHERE name = '" . $teacher . "';";
$results = $db->query($query);
?>

<p>
<?php
	foreach($results as $row){
?>
	<li><?= $row['name'] ?></li>
	<li><?= $row['phone_num'] ?></li>
	<li><?= $row['email'] ?></li>
	<li><?= $row['hours_day'] ?></li>
	<li><?= $row['hours_start'] ?></li>
	<li><?= $row['hours_end'] ?></li>
	<li><?= $row['pref_contact_method'] ?></li>
	<li><?= $row['room_num'] ?></li>
	<li><?= $row['building'] ?></li>
	<?php } ?>
<p>