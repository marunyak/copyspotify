<?php
    include("../config.php");

    if(isset($_POST['name']) && !empty($_POST['name'])){
        $name = $_POST['name'];
        $username = $_POST['username'];
        $date = date("Y-m-d H:i:s");
        $query = mysqli_query($con, "INSERT INTO playlists SET name =  '$name', owner = '$username', dateCreated = '$date'");
    }
    else {
        echo "Name or username parameters not added";
    }
?>