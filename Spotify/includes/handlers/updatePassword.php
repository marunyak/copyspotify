<?php
include("../config.php");

if(!isset($_POST['username'])){
    echo "ERROR: Could not set username";
    exit();
}

if(!isset($_POST['oldPassword']) || empty($_POST['oldPassword']) || !isset($_POST['newPassword1']) 
|| empty($_POST['newPassword1']) || !isset($_POST['newPassword2']) || empty($_POST['newPassword2'])){
    echo "Not all passwords have been set";
    exit();
}

$username     = $_POST['username'];
$oldPassword  = $_POST['oldPassword'];
$newPassword1 = $_POST['newPassword1'];
$newPassword2 = $_POST['newPassword2'];
$oldMd5       = md5($oldPassword);

$passwordCheck = mysqli_query($con, "SELECT * FROM users WHERE username='$username' AND password='$oldMd5'");
if(mysqli_num_rows($passwordCheck) != 1){
    echo "Password is incorrect";
    exit();
}

if($newPassword1 != $newPassword2){
    echo "Your new password do not match";
    exit();
}

if(!preg_match('/[a-zA-Z0-9]/',$newPassword1)){ 
    echo "Your new password must  contain only letters or numbers";
    exit();
}

if(strlen($newPassword1) > 30 || strlen($newPassword1) < 5){
    echo "Your new password must be beetwen 5 and 30 characters";
    exit();
}

$password = md5($newPassword1);
$res = mysqli_query($con,"UPDATE users SET password = '$password' WHERE username = '$username'");
echo "New password was set";
?>