<?php 
    $db = new PDO("mysql:dbname=344_project;host=localhost","root");
    $query = "SELECT * FROM `faculty`;";
    $results = $db->query($query);
    
    $days = Array('M', 'T', 'W', 'R', 'F');
    $dayNames = Array('M' => "Monday", 'T' => "Tuesday", 'W' => "Wednesday", 'R' => "Thursday", 'F' => "Friday");

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
                    Preferred Contact: <?= $row['pref_contact_method'] ?><br>
                    <?= $phone ?><br>
                    <?= $row['email'] ?><br>                    
                    <?= $row['building'] ?> <?= $row['room_num'] ?><br>
                    <br>
                </div>
               
                <div class="content-focus-bottom">
                    <h3>Office Hours</h3>
                    <table>
                        <tr>
<?php
        $query2 = "SELECT * FROM `office_hours` WHERE faculty_id = " . $row['faculty_id'] . ' ORDER BY start_time;';
        $results2 = $db->query($query2);
        $queryResults = Array();

        foreach($results2 as $item)
        {
            // PDO objects can only be referenced Once!
            // Get a copy
            array_push($queryResults, $item);
        }   
        
        $splitHours = Array();
        
        foreach($days as $day)
        {
            foreach($queryResults as $officeHours)
            {
               if($officeHours['day'] == $day)
               {
                   if(!array_key_exists($day, $splitHours))
                   {
                        $splitHours[$day] = 0;
?>
                            <th><?= $dayNames[$day] ?></th>
<?php
                   }
                   $splitHours[$day]++;
               }
            }
        }
?>
                        </tr>
<?php
                // This is REALLY REALLY REALLY bad code
                // Functional, but a new DB layout would
                // need to be added to make it better
                // or some better SQL
                $count = max($splitHours) - 1;
                while($count >= 0)
                {
?>
                        <tr>
<?php
                    foreach($days as $day)
                    {
                        $finished = Array();
                        $remove = Array();
                        foreach($queryResults as $officeHours)
                        {
                            if($officeHours['day'] == $day and !in_array($day, $finished))
                            {
                                array_push($finished, $day);
                                array_push($remove, $officeHours);
                                
?>
                            <td><?= readHours($officeHours['start_time']) ?>-<?= readHours($officeHours['end_time']) ?></td>
<?php
                            }
                        }
                        foreach($remove as $item)
                        {
                            if(in_array($item, $queryResults))
                            {
                                $key = array_search($item, $queryResults);
                                unset($queryResults[$key]);
                            }
                        }
                    }
?>
                        </tr>
<?php
                    
                    $count--;
                }
?>
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
            if($hours[0] == 0)
            {
                $hours = explode(0, $hours, 2)[1];
            }
            return $hours;
        }
        else
        {
            return $hoursRead;            
        }        
    }
?>