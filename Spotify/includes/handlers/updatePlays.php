<?php
    include("../config.php");

    if(isset($_POST['songId']) && !empty($_POST['songId'])){
        mysqli_query($con,"UPDATE songs SET plays = plays + 1 WHERE id = '{$_POST['songId']}'");
    }
?>