

<?php
    include("header.php");  
?>

<div class="fac schoolColors">
    
<?php
    
    $db = new PDO("mysql:dbname=344_project;host=localhost","root");
    $query = "SELECT * FROM `faculty`;";
    $results = $db->query($query);
    
	foreach($results as $row)
    {
        $img = str_replace(' ', '', $row['name']);
        
        $phone = substr_replace($row['phone_num'], "-", 3, 0);
        $phone = substr_replace($phone, "-", 7, 0);
?>
    <div class="facItem schoolColors">
            <img class="facimage" src="http://localhost/dept/images/<?= $img ?>.jpg" alt="<?= $row['name'] ?>'s picture">

            <div class="content-focus-right content-focus-right-fac"> 
                <h3><a><?= $row['name'] ?></a></h3>
                <br>
                <?= $row['degree']?>, <?= $row['alma_mater'] ?>
            </div>
            <div class="content-focus-bottom hours-table">
            </div>
    </div>
<?php
    };
    include("footer.php");
?>