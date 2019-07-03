<?php 
    include("includes/includedFiles.php");
?>
<div class="userDetails">
    <div class="container borderButtom">
        <h2>EMAIL</h2>
        <input type="text" class="email" name="email" placeholder="Email address..." value="<?php echo $userLoggedIn->getEmail();?>">
        <span class="message"></span>
        <button class="button" onclick="updateEmail('email')">SAVE</button>
    </div>

    <div class="container">
        <h2>PASSWORD</h2>
        <input type="password" class="password Oldpassword" name="Oldpassword" placeholder="Current password">
        <input type="password" class="password Newpassword1" name="Newpassword1" placeholder="New password">
        <input type="password" class="password Newpassword2" name="Newpassword2" placeholder="Confirm password">
        <span class="message"></span>
        <button class="button" onclick="updatePassword('Oldpassword','Newpassword1','Newpassword2')">SAVE</button>
    </div>
</div>