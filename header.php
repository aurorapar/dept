<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>CS Deptartment</title>
    <link href="css/style.css" rel="Stylesheet" type="text/css" />  
    <script
          src="https://code.jquery.com/jquery-3.1.1.min.js"
          integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
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
            <li class="news-element schoolColors"><a href="index.php">WSU Home</a></li>
            <li class="news-element schoolColors"><a href="projects.php">Department Projects</a></li>
            <li class="news-element schoolColors"><a href="faculty.php">Faculty</a></li>
            <li class="news-element schoolColors"><a href="opportunities.php">Opportunities</a></li>
        </ul>
        
    </header>
    
    <div id="content" class="nonheader">
         <?php if($_SERVER['REQUEST_URI'] == '/dept/index.php' or $_SERVER['REQUEST_URI'] == '/dept/')
                {
                    include("news.php");
                }
        ?>
         
        
        