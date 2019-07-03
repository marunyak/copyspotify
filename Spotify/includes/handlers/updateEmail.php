<?php 
include("../config.php");

if(!isset($_POST['username'])){
    echo "ERROR: Could not set username";
    exit();
}

if(isset($_POST['email']) && !empty($_POST['email'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        echo "Email is invalid";
        exit();
    }

    $emailCheck = mysqli_query($con,"SELECT email FROM users  WHERE username = '$username' AND email = '$email'");
    if(mysqli_num_rows($emailCheck) > 0){
        echo "Email is already use";
    }

    $updateEmail = mysqli_query($con,"UPDATE users SET email='$email' WHERE username = '$username' AND email != '$email'");
    echo "Email is updated!";
}
else {
    echo "You must provide an email";
}
?>