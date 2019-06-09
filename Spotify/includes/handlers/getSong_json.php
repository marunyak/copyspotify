<?php
    include("../config.php");

    if(isset($_POST['songId']) && !empty($_POST['songId'])){
        $query = mysqli_query($con,"SELECT * FROM songs WHERE id = '{$_POST['songId']}'");
        $row   = mysqli_fetch_array($query);
        echo json_encode($row);
    }
?>