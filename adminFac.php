<?php
	include('header.php');
    
    
    $response = '';    
    
    $profName = '';
    $img = '';
    $phone = '';
    $phoneOut = '';
    $email = '';
    $location = '';
    $contact = '';
    $degree = '';
    $university = '';
    $notes = '';
    $room = '';
    
    // This value would be brought over from a authentication page
    $_POST['profId'] = 1111;
    
    if(!isset($_POST['profId']))
    {
        print 'Error: no teacher selected<br />';
    }

    else
    {
        $profId = $_POST['profId'];
        
        $days = Array('M', 'T', 'W', 'R', 'F');
        $dayNames = Array('M' => "Monday", 'T' => "Tuesday", 'W' => "Wednesday", 'R' => "Thursday", 'F' => "Friday");
        
        $db = new PDO("mysql:dbname=344_project;host=localhost","root");
        
        $query =  "SELECT * FROM `faculty` WHERE faculty_id = '" . $profId . "';";
        $queryReturn = $db->query($query);
        
        
        foreach($queryReturn as $row)
        {        
            $profName = $row['name'];
            $img = str_replace(' ', '', $profName);
            $phone = $row['phone_num'];
            $phoneOut = substr_replace($phone, "-", 3, 0);
            $phoneOut = substr_replace($phoneOut, "-", 7, 0);
            $email = $row['email'];
            $contact = $row['pref_contact_method'];
            $location = $row['building'] . ' ' . $row['room_num'];
            $room = $row['room_num'];
            $building = $row['building'];
            $profId = $row['faculty_id'];
            $degree = $row['degree'];
            $university = $row['alma_mater'];
            $notes = $row['notes'];
        }
        
        $response = '
                    </div>
                    <div class="facItem schoolColors">
                        <h2>Current Display</h2>
                        <img class="facimage" src="http://localhost/dept/images/'. $img .'.jpg" alt="'. $profName .'\'s picture">

                        <div class="content-focus-right content-focus-right-fac"> 
                            <h3><a>'. $profName .'</a></h3>
                            <br>
                            '. $degree .', '. $university .'
                        </div>
                        <div class="content-focus-bottom hours-table">                        
                '. $phoneOut .'<br>
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
                
                // Get the time with a SQL Statement JOIN, WHERE day=$day !
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
            </div>';
    }

    
    $response = $response . '
        </div>
        <div class="content-focus schoolColors" style="display: block">
            <form id="updateForm">
                <div style="float:left">
                
                    <input type="hidden" name="oldname" value="">

                    <label >Name:</label><br>
                    <input id="name" type="text" name="personname" value="' . $profName . '"><br><br>
                
                
                    <label >E-Mail:</label><br>
                    <input id="email" type="email" name="personemail" value="' . $email . '"><br><br>
                    
                    
                    <label>Phone Number:</label><br>
                    No hyphens or spaces<br>
                    <input id="phonenum" name="phone" type="tel" pattern="^\d{3}-\d{4}$" maxlength=10 value="' . $phone . '"><br><br>
                    
                    <label>Building</label><br>
                    <input id="building" name="building" type="text" value="' . $building . '"><br><br>
                    
                    <label>Office Number</label><br>
                    <input id="officenum" name="officenum" type="text" maxlength=6 value="' . $room . '"><br><br>
                </div>
                
                <div class="content-focus-right notes">
                    <label>Notes</label><br>
                    <textarea name="notes" style="width:100%; height:150px">' . $notes . '</textarea>
                </div>
            

                <h3 style="clear:left">Office Hours</h3>
                <h4 style="clear:left">This resets ALL office hours of the day you change. Make sure to include all times for that day!</h4>
                <table>
                <tr>';

    $days = Array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');
    foreach($days as $day)
    {
        $response = $response . '
        <th>' . $day . '</th>';
    }
    $response = $response . '
    </tr>
    <tr>';
    foreach($days as $day)
    { 
        $dayLetter = $day[0];
        $query = "SELECT start_time FROM `office_hours` WHERE faculty_id = '" . $profId . "' AND day = '" . $dayLetter . "';";
        $queryResult = $db->query($query);
        $startTimes = Array();
        
        foreach($queryResult as $row)
        {
            array_push($startTimes, $row['start_time']);
        }
        
        $query = "SELECT end_time FROM `office_hours` WHERE faculty_id = '" . $profId . "' AND day = '" . $dayLetter . "';";
        $queryResult = $db->query($query);
        $endTimes = Array();
        
        foreach($queryResult as $row)
        {
            array_push($endTimes, $row['end_time']);
        }
                
        $response = $response . '
        <td>';
        for($count=1;$count<=3; $count++)
        {
            $response = $response . '
            <div id="' . $day . $count . '">
            
            <label>Start Time</label><br><select id="start' . $day . $count . '" name="start' . $day . $count . '">
            <option label=" " value="null "> </option>';
            
            $retrieved = false;
            if(isset($startTimes[$count - 1]))
            {
                $retrieved = $startTimes[$count - 1];
            }
            
            
            $time=7;
            while($time <= 17) // 5 PM                
            {	
                if(dbTime($time) . ":00:00" == $retrieved)
                {
                    $response = $response . '
                    <option selected value="' . dbTime($time) . ':00:00">' . convertTime($time) . '</option>';
                }
                else
                {
                    $response = $response . '
                    <option value="' . dbTime($time) . ':00:00">' . convertTime($time) . '</option>';
                }                
                
                if(dbTime($time) . ":30:00" == $retrieved)
                {
                    $response = $response . '
                    <option selected value="' . dbTime($time) . ':30:00">' . str_replace(":00", ":30", convertTime($time)) . '</option>';
                }
                else
                {
                    $response = $response . '
                    <option value="' . dbTime($time) . ':30:00">' . str_replace(":00", ":30", convertTime($time)) . '</option>';
                }                
                
                $time++;
            }
            
            
            
            
            $response = $response . '
            </select>
            <br><br>
            <label>End Time</label><br><select id="end' . $day . $count . '" name="end' . $day . $count . '">
            <option label=" " value="null"> </option>';
        
        
            
            $retrieved = false;
            if(isset($endTimes[$count - 1]))
            {
                $retrieved = $endTimes[$count - 1];
            }
        
            
            $time=7;
            while($time <= 17) // 5 PM                
            {	
                if(dbTime($time) . ":00:00" == $retrieved)
                {
                    $response = $response . '
                    <option selected value="' . dbTime($time) . ':00:00">' . convertTime($time) . '</option>';
                }
                else
                {
                    $response = $response . '
                    <option value="' . dbTime($time) . ':00:00">' . convertTime($time) . '</option>';
                }                
                
                if(dbTime($time) . ":30:00" == $retrieved)
                {
                    $response = $response . '
                    <option selected value="' . dbTime($time) . ':30:00">' . str_replace(":00", ":30", convertTime($time)) . '</option>';
                }
                else
                {
                    $response = $response . '
                    <option value="' . dbTime($time) . ':30:00">' . str_replace(":00", ":30", convertTime($time)) . '</option>';
                }
                $time++;
            }
        
            $response = $response . '
            </select><br><br>';
            
            if($count<3)
            {
                $response = $response . '
                <button type="button" id="button'. $day . $count . '">Add Time</button>';
            }
            
            if($count>1)
            {
                $response = $response . '
                <button type="button" id="clear'. $day . $count . '">Remove time</button>';
            }
            
            $response = $response . '
            </div>
            <br>';
    
        }//end of for loop
        
        $response = $response . '
        </td>';
    }
        
    $response = $response . '
    </table>
    <button id="update">Submit</button>
    </form>';
    
    
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
    
    function convertTime($time)
    {
        
        if($time > 12)
        {
            $time = ($time - 12) . ":00 PM";
        }
        else
        {
            if($time == 12)
            {
                $time = "12:00 PM";
            }
            else
            {
                $time = $time . ":00 AM";
            }
        }
        return $time;
    }
    
    function dbTime($time)
    {
        if(strlen($time) < 2)
        {
            $time = '0' . $time ;
        }        
        return $time;
    }    
    
    include("footer.php");
?>