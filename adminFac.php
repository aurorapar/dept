<?php
	include('header.php');
?>
</div>
<div class="content-focus schoolColors">
	<div style="float:left">
		<ul>
			<li>
				<label >Name:</label><br>
				<input type="text" name="personname" placeholder="Your Name" required><br><br>
			</li>
			<li>
				<label >E-Mail:</label><br>
				<input type="email" name="personemail" placeholder="YourEmail@winona.edu" required><br><br>
			</li>
			<li>
			<label>Phone Number:</label><br>
			<input id="phonenum" type="tel" pattern="^\d{3}-\d{4}$" maxlength=9><br><br>
			</li>
			<li>
			<label>Office Number</label><br>
			<input id="officnum" type="text" maxlength=6><br><br>
        </ul>
    </div>
        
        <div class="content-focus-right notes">
            <li><label>Notes</label><br>
            <textarea name="notes" style="width:100%; height:150px"></textarea>
        </div>
			

	<h3 style="clear:left">Office Hours</h3>
    <h4 style="clear:left">This resets ALL office hours of the day you change. Make sure to include all times for that day!</h4>
    <table>
    <tr>
<?php
    $days = Array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');
    foreach($days as $day)
    {
?>
        <th><?= $day?></th>
<?php
    }
?>
    </tr>
    <tr>
<?php
    foreach($days as $day)
    { 
?>
        <td>
<?php
	  for($count=1;$count<=3; $count++)
	  {
 ?>
        <div id="<?= $day ?><?= $count ?>" >
<?php
		
?>
		<label>Start Time</label><br><select id="start<?= $day?><?=$count?>" name="start<?= $day?><?=$count?>">
		<option label=" " value="null "> </option>
<?php
	$mil_time=7;
	$am=7;
        $pm=1;
        while($am <= 11)
			
        {	
?>
            <option value="start<?= $mil_time ?>:00"><?= $am ?>:00 AM </option>
			<option value="start<?= $mil_time ?>:30"><?= $am ?>:30 AM </option>
<?php
            $am++;
	    $mil_time++;
        }
?>
		<option value="start<?= $mil_time ?>:00">12:00 PM </option>
		<option value="start<?= $mil_time ?>:30">12:30 PM </option>
<?php
	 $mil_time++;
	while($pm<=6)
	{
?>
		 <option value="start<?= $mil_time ?>:00"><?= $pm ?>:00 PM </option>
		<option value="start<?= $mil_time ?>:30"><?= $pm ?>:30 PM </option>
<?php
		$pm++;
	 	$mil_time++;
	}
?>
	</select>
	<br>
	<label>End Time</label><br><select id="end<?= $day ?><?= $count ?>" name="end<?= $day ?><?= $count ?>">
	<option label=" " value="null"> </option>
<?php
		$am=7;
        $pm=1;
        while($am <= 11)	
        {	
?>
            <option value="end<?= $am ?>"><?= $am ?>:00 AM </option>
			<option value="end<?= $am ?>:30"><?= $am ?>:30 AM </option>
<?php
            $am++;
        }
?>
		<option value="end12">12:00 PM </option>
		<option value="end12:30">12:30 PM </option>
<?php
	while($pm<=6)
	{
?>
		<option value="end<?= $pm ?>"><?= $pm ?>:00 PM </option>
		<option value="start<?= $pm ?>:30"><?= $pm ?>:30 PM </option>
<?php
		$pm++;	
		
	}
?>
	 </select><br>
<?php
	if($count<3)
    {
?>
        <button type="button" id="button<?= $day ?><?= $count ?>">Add Time</button>
<?php
    }
	if($count>1){
?>
		<button type="button" id="clear<?= $day?><?=$count?>">Remove time</button>
<?php
	}
?>
    </div>
    <br>
<?php
	  }//end of for loop
?>  
    </td>
<?php
    }
?>
</table>
<button id="submit">Submit</button>
	
</div>

<?php
    include("footer.php");
?>
