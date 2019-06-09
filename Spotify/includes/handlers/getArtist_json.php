<?php
    include("../config.php");

    if(isset($_POST['artistId']) && !empty($_POST['artistId'])){
        $query = mysqli_query($con,"SELECT * FROM artists WHERE id = '{$_POST['artistId']}'");
        $row   = mysqli_fetch_array($query);
        echo json_encode($row);
    }
?>