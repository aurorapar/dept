<?php 
    $db = new PDO("mysql:dbname=344_project;host=localhost","root");
    $query = "SELECT * FROM `faculty`;";
    $results = $db->query($query);
    
    $day = Array('M', 'T', 'W', 'R', 'F');
    $days = Array('M' => "Monday", 'T' => "Tuesday", 'W' => "Wednesday", 'R' => "Thursday", 'F' => "Friday");

	foreach($results as $row)
    {
        $img = str_replace(' ', '', $row['name']);
        
        $phone = substr_replace($row['phone_num'], "-", 3, 0);
        $phone = substr_replace($phone, "-", 7, 0);
        
        
?>

    <div class="facItem schoolColors">
        <img class="facimage" src="http://localhost/dept/images/<?= $img ?>.jpg" alt="<?= $row['name'] ?>'s picture">

                <div class="content-focus-right fr-fac"> 
                    <h2><?= $row['name'] ?></h3>
                    Phone Number: <?= $phone ?><br>
                    Email: <?= $row['email'] ?><br>
                    Preferred Contact Method: <?= $row['pref_contact_method'] ?><br>
                    Office: <?= $row['room_num'] ?><br>
                    Building: <?= $row['building'] ?><br>
                </div>
               
                <div class="content-focus-bottom">
                    <h3>Office Hours</h3>
                    <table>
                        <tr><td></td>                        
<?php
        $query2 = "SELECT * FROM `office_hours` WHERE faculty_id = " . $row['faculty_id'] . ';';
        $results2 = $db->query($query2);
        
        /*
        foreach($results2 as $item)
        {
            print_r($item);
        }
        */
        
        $startTime = Array();
        $endTime = Array();
        foreach($day as $curDay)
        {
            $startTime[$curDay] = '';
            $endTime[$curDay] = '';
?>
                        <th><?= $days[$curDay]; ?></th>
<?php
        }
?>
                        </tr>
                        <tr><td>Start Time</td>
<?php
        foreach($results2 as $officeHours)
        {
            $startTime[$officeHours['day']] = $officeHours['start_time'];
            $endTime[$officeHours['day']] = $officeHours['end_time'];
        }
        foreach($day as $curDay)
        {
?>
                        <td><?= readHours($startTime[$curDay]) ?> </td>
<?php
        }
?>
                        </tr>
                        <tr><td>End Time</td>
<?php
        foreach($day as $curDay)
        {
?>
                        <td><?= readHours($endTime[$curDay]) ?> </td>
<?php
        }
?>
                        </tr>

                </table>
                    
                </div>
    </div>


<?php 
    };     
    
    function readHours($hoursRead)
    {
        if(strlen($hoursRead) > 0)
        {
            $hours = $hoursRead[0] . $hoursRead[1];        
            
            if($hours > 12)
            {
                $hours = $hours - 12 . ":" . $hoursRead[3] . $hoursRead[4] . " PM";
            }
            else
            {
                $hours = $hours . ":" . $hoursRead[3] . $hoursRead[4] . " AM";
            }        
            return $hours;
        }
        else
        {
            return $hoursRead;            
        }        
    }
?>