<?php

    if(!isset($_POST['profName']))
    {
        print 'Error: no teacher selected<br />';
    }
    else
    {
        $days = Array('M', 'T', 'W', 'R', 'F');
        $dayNames = Array('M' => "Monday", 'T' => "Tuesday", 'W' => "Wednesday", 'R' => "Thursday", 'F' => "Friday");
        
        $profName = $_POST['profName'];
        $profId = '';        
        
        $db = new PDO("mysql:dbname=344_project;host=localhost","root");
        
        $query =  "SELECT * FROM `faculty` WHERE name = '" . $profName . "';";
        $queryReturn = $db->query($query);
        
        $phone = '';
        $email = '';
        $location = '';
        $contact = '';
        $notes = '';
        foreach($queryReturn as $row)
        {            
            $phone = substr_replace($row['phone_num'], "-", 3, 0);
            $phone = substr_replace($phone, "-", 7, 0);
            $email = $row['email'];
            $contact = $row['pref_contact_method'];
            $location = $row['building'] . ' ' . $row['room_num'];
            $profId = $row['faculty_id'];
            $notes = $row['notes'];
        }
        
        $response = '
                '. $phone .'<br>
                '. $row['email'] .'<br>
                Preferred Communication: '. $contact . '<br>
                '. $location . '<br><br>
                <div class="notes-display">'. $notes . '</div><br><br>
            
                <h3>Office Hours</h3>
                <table>                
                    <tr>';
        
        
                
        

        
        
        $query = "SELECT * FROM `office_hours` WHERE faculty_id = " . $profId . ' ORDER BY start_time;';
        $results = $db->query($query);
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
                
                // 
                //  SELECT start_time FROM `office_hours` WHERE faculty_id = '1111' AND day = 'T' ORDER BY start_time;
                // 
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
            <!--
            <div class="logo">
                <img src="img/wsulogo.png" alt="wsu logo">
            </div>
            -->
        </div>';
    }

    print $response;
    
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