<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
        include("includes/config.php");
        include("includes/classes/User.php");  
        include("includes/classes/Artist.php");  
        include("includes/classes/Album.php"); 
        include("includes/classes/Song.php");
        include("includes/classes/Playlist.php");

        if(isset($_GET['username']) && !empty($_GET['username'])){
            $userLoggedIn = new User($con, $_GET['username']);
        }
        else {
            echo "username varible is not pass into this page, please on a JS";
        }
    }
    else {
        include("header.php");
        include("footer.php");

        $url = $_SERVER['REQUEST_URI'];
        echo "<script>openPage('$url')</script>";
        exit();
    }
?>