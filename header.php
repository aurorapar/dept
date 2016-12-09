<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>CS Deptartment</title>
    <link href="css/style.css" rel="Stylesheet" type="text/css" />  
    <script
      src="https://code.jquery.com/jquery-3.1.1.js"
      integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA="
      crossorigin="anonymous"></script>
    <script src="js/facultyMod.js"></script>
    <script src="js/adminJsForm.js"></script>
</head>

<body>
    <header>
        
        <div id="banner" class="schoolColors">
            <div id="banner-content">
                Computer Science Department
            </div>
        </div>
        
        <ul id="header-list">
            <li class="news-element schoolColors"><a href="http://www.winona.edu/">WSU Home</a></li>
            <li class="news-element schoolColors"><a href="index.php">CS Deptartment</a></li>
            <li class="news-element schoolColors"><a href="index.php">Department Projects</a></li>
            <li class="news-element schoolColors"><a href="faculty.php">Faculty</a></li>
            <li class="news-element schoolColors"><a href="index.php">Opportunities</a></li>
        </ul>
        
    </header>
    
    <div id="content" class="nonheader">
         <?php 
                include("connection.php");
                if(basename($_SERVER['PHP_SELF']) == 'index.php')
                {
                    include("news.php");
                }
                
        ?>
        <?php if(basename($_SERVER['PHP_SELF']) != 'faculty.php')
                {
?>                    <div class="content-focus schoolColors">
<?php
                    
                }
        ?>
            
         
        
        