<?php    
    
    include("connection.php");
    
    $data = $_POST['data'];
    parse_str($data, $data);
    
    foreach($data as $dataVar)
    {
        $key = array_search($dataVar, $data);
        $dataVar = trim($dataVar, " \t\n\r\0\x0B");
        if($key != 'notes')
        {
            $dataVar = htmlspecialchars( strip_tags($dataVar) );
        }
        $data[$key] = $dataVar;
    }
    
    //=========================================================================================================
    
    $days = Array('M', 'T', 'W', 'R', 'F');
    $dayNames = Array('M' => "Monday", 'T' => "Tuesday", 'W' => "Wednesday", 'R' => "Thursday", 'F' => "Friday");
    
    $profName = $data['oldname'];
        
    $profId = '';   
    $query =  "SELECT * FROM `faculty` WHERE name = '" . $profName . "';";
    $queryReturn = $db->query($query);
        
    $img = str_replace(' ', '', $profName);
    $phone = '';
    $email = '';
    $location = '';
    $room = '';
    $building = '';
    $contact = '';
    $degree = '';
    $university = '';
    $notes = '';
    
    foreach($queryReturn as $row)
    {            
        $phone = substr_replace($row['phone_num'], "-", 3, 0);
        $phone = substr_replace($phone, "-", 7, 0);
        $email = $row['email'];
        $contact = $row['pref_contact_method'];
        $location = $row['building'] . ' ' . $row['room_num'];
        $building = $row['building'];
        $profId = $row['faculty_id'];
        $degree = $row['degree'];
        $university = $row['alma_mater'];
        $notes = $row['notes'];
    }
    
    //===================================================================================================
    // Ultimately, a properly formatted DB would make this easy because we could just 
    // iterate over the DATA array, and then the ID would be the field in the DB
    // Hardcoding is bad :'(    
    
    // Maybe not, since we're checking if each variable is differnet. Maybe use
    // two different arrays and iterate over them?
    
    $errors = '<div id="content-focus schoolColors">';

    
    if($data['personname'] != $profName)
    {
        $profName = $data['personname'];
        $query =  "UPDATE `faculty` SET name = '" . $data['personname'] . "' WHERE name = '" . $data['oldname'] . "'";
        $queryReturn = $db->query($query);
    }
    
    // Use new name from here on out
    if($data['personemail'] != $email)
    {
        $email = $data['personemail'];
        $query =  "UPDATE `faculty` SET email = '" . $data['personemail'] . "' WHERE name = '" . $data['personname'] . "'";
        $queryReturn = $db->query($query);
    }
    
    if($data['phone'] != $phone)
    {
        $phone = $data['phone'];
        $query =  "UPDATE `faculty` SET phone_num = '" . $data['phone'] . "' WHERE name = '" . $data['personname'] . "'";
        $queryReturn = $db->query($query);
        
        $phone = substr_replace($data['phone'], "-", 3, 0);
        $phone = substr_replace($phone, "-", 7, 0);
    }
    
    if($data['notes'] != $notes)
    {
        $notes = $data['notes'];
        $query =  "UPDATE `faculty` SET notes = '" . $data['notes'] . "' WHERE name = '" . $data['personname'] . "'";
        $queryReturn = $db->query($query);
    }
    
    if($data['officenum'] != $room)
    {
        $room = $data['officenum'];
        $query =  "UPDATE `faculty` SET room_num = '" . $data['officenum'] . "' WHERE name = '" . $data['personname'] . "'";
        $queryReturn = $db->query($query);
    }
    
    if($data['building'] != $building)
    {
        $building = $data['building'];
        $query =  "UPDATE `faculty` SET building = '" . $data['building'] . "' WHERE name = '" . $data['personname'] . "'";
        $queryReturn = $db->query($query);
        $location = $building . " " . $room;
    }
    
    //  INSERT INTO `office_hours` (`faculty_id`, `day`, `start_time`, `end_time`) VALUES
    //  (2222, 'W', '08:00:00', '09:00:00'),
    
    foreach($days as $day)
    {
        for($i = 1; $i <= 3; $i++)
        {            
            if(!isset($data['start' . $dayNames[$day] . $i]))
            {
                $data['start' . $dayNames[$day] . $i] = "null";
            }
            if(!isset($data['end' . $dayNames[$day] . $i]))
            {
                $data['end' . $dayNames[$day] . $i] = "null";
            }
            
            if($data['start' . $dayNames[$day] . $i] != "null" and $data['start' . $dayNames[$day] . $i] == $data['end' . $dayNames[$day] . $i])
            {
                $errors = $errors . "You tried to set a start time and end time as the same thing for " . $dayNames[$day] . ".";
                print $errors;
                exit();
            }
              
            if($data['start' . $dayNames[$day] . $i] != "null" and $data['end' . $dayNames[$day] . $i] == "null")
            {
                $errors = $errors . "You tried to set a start time but didn't set an end time for " . $dayNames[$day] . ".";
                print $errors;
                exit();
            }
            
            if($data['start' . $dayNames[$day] . $i] == "null" and  $data['end' . $dayNames[$day] . $i] != "null")
            {
                $errors = $errors . "You tried to set an end time but didn't set a start time for " . $dayNames[$day] . ".";
                print $errors;
                exit();
            }
            
            if($data['start' . $dayNames[$day] . $i] > $data['end' . $dayNames[$day] . $i])
            {
                $errors = $errors . "You tried to set a start time that was later than the end time for " . $dayNames[$day] . ".";
                print $errors;
                exit();
            }
            
            if($i > 1)
            {                
                //Check if start time of second/third slot is earlier/same as earlier slot
                if($data['start' . $dayNames[$day] . ($i - 1)] == 'null' and  ($data['end' . $dayNames[$day] . $i] != 'null' or $data['start' . $dayNames[$day] . $i] != 'null'))
                {  
                    //$errors = $errors . $data['start' . $dayNames[$day] . ($i - 1)];
                    $errors = $errors . "You tried to set time slot " . $i . "before the previous time slot was set on " . $dayNames[$day] . ".";
                    print $errors;
                    exit();
                }   
                

                if($data['end' . $dayNames[$day] . ($i - 1)] > $data['start' . $dayNames[$day] . $i])
                {
                    $errors = $errors . "You tried to set time slot " . $i . " began before the end of the previous time slot for " . $dayNames[$day] . ".";
                    print $errors;
                    exit();
                }                
            }    
        }
        
        $query = "SELECT start_time, end_time FROM `office_hours` WHERE faculty_id = '" . $profId . "' AND day = '" . $day . "' ORDER BY start_time;";
        $queryResult = $db->query($query);
        
        $startTimes = Array();
        $endTimes = Array();
        $dayIndex = 0;
        foreach($queryResult as $row)
        {
            if(count($row) > 0)
            {
                foreach($row as $item)
                {
                    $key = array_search($item, $row);
                    if($key == 'start_time')
                    {
                        array_push($startTimes, $row[$key]);
                    }
                    if($key == 'end_time')
                    {
                        array_push($endTimes, $row[$key]);
                    }
                }
            }
        }

        $count = 0;
        $update = false;
        for($i = 1; $i <= 3; $i++)
        {
            $start = $data['start' . $dayNames[$day] . $i];
            if($start != "null" and !(in_array($start, $startTimes)))
            {
                $count++;
                $update = true;
                break;
            }
        }
        
        if($count != count($startTimes))
        {
            $update = true;
        }
        
        if($update)
        {
            $query = "DELETE FROM `office_hours` WHERE faculty_id = '" . $profId . "' AND day = '" . $day . "';";
            $queryResult = $db->query($query);
            
            for($i = 1; $i <= 3; $i++)
            {
                $start = $data['start' . $dayNames[$day] . $i];
                $end = $data['end' . $dayNames[$day] . $i];
                if($start == "null")
                {
                    break;
                }
                $query = "INSERT INTO `office_hours` (`faculty_id`, `day`, `start_time`, `end_time`) VALUES
                        (" . $profId . ", '" . $day . "', '" . $start . "', '" . $end . "')";
                $queryResult = $db->query($query);
            }
        }        
        
        // "DELETE FROM `office_hours` WHERE faculty_id = '" . $profId . "' AND day = '" . $day . "';";
        
    }
    
    //===================================================================================================
    
    $response = '
                    <h2>Current Display</h2>
                    <img class="facimage" src="./images/'. $img .'.jpg" alt="'. $profName .'\'s picture">

                    <div class="content-focus-right content-focus-right-fac"> 
                        <h3><a>'. $profName .'</a></h3>
                        <br>
                        '. $degree .', '. $university .'
                    </div>
                    <div class="content-focus-bottom hours-table">                        
            '. $phone .'<br>
            '. $email .'<br>
            Preferred Communication: '. $contact . '<br>
            '. $location . '<br><br>
            <div class="notes-display">'. $notes . '</div><br><br>
        
            <h3>Office Hours</h3>
            <table>                
                <tr>';
    
    $query = "SELECT * FROM `office_hours` WHERE faculty_id = " . $profId . ' ORDER BY start_time;';
    $results = $db->query($query);
    
    if(gettype($results) == 'boolean')
    {
        //print strlen($profId);
        exit();
    }
    else
    {
    
        $queryResults = Array();
        
        foreach($results as $item)
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
                        $response = $response . '
                        <th>' . $dayNames[$day] . '</th>';
                   }
                   $splitHours[$day]++;
               }
            }
        }
                    $response = $response . '
                    </tr>';
                // This is REALLY REALLY REALLY bad code
                // Functional, but a new DB layout would
                // need to be added to make it better
                // or some better SQL
                
                // Get the time with a SQL Statement JOIN, WHERE day=$day !
        if(count($splitHours) < 1)
        {
            $response = $response . "</table>No hours posted.</div></div></div>";
            print $response;
            exit();
        }
        $count = max($splitHours) - 1;
        while($count >= 0)
        {
            $response = $response . '
                    <tr>';
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
                        
                        $response = $response . '
                        <td>'. readHours($officeHours['start_time']) . '-' . readHours($officeHours['end_time']) . '</td>';
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
            $response = $response . '
            </tr>';                    
            $count--;
        }
        $response = $response . '
                </table>
            </div>                    

        </div>
        
        </div>';
        
        print $response;
    }    
    
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