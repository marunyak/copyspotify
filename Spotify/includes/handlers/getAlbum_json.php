<?php
    include("../config.php");

    if(isset($_POST['albumId']) && !empty($_POST['albumId'])){
        $query = mysqli_query($con,"SELECT * FROM albums WHERE id = '{$_POST['albumId']}'");
        $row   = mysqli_fetch_array($query);
        echo json_encode($row);
    }
?>