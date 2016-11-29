
<table border="1">
    <tr>
        <th></th>
        <?php
            $days = Array('Mon', 'Tue', 'Wed', 'Thu', 'Fri');
            foreach($days as $day)
            {
                print "<th>$day</th>";
            }
        ?>
        
    </tr>
    <br>
    <?php
        
        $hours = Array();
        for($x = 7; $x <= 12; $x++)
        {
            array_push($hours, $x . ':00');
            array_push($hours, $x . ':30');
        }
        for($x = 1; $x <= 5; $x++)
        {
            array_push($hours, $x . ':00');
            array_push($hours, $x . ':30');
        }
        foreach($hours as $hour)
        {
            print "\n<tr>\n    <td>$hour</td>";
            foreach($days as $day)
            {
                print "\n    <td id=\"" . $day . str_replace(":", '', $hour) . "\"></td>";
            }
            print "\n</tr>";
        }
        print "<p>" . count($days) . "</p>";
    ?>
</table>
    