<?php include("includes/includedFiles.php");?>
<div class="enityInfo">
    <div class="centerSection">
        <div class="userInfo">
            <h1><?php echo $userLoggedIn->getFirstAndLastName();?></h1>
        </div>
    </div>
</div>

<div class="buttonItems">
    <button class="button">USER DETAILS</button>
    <button class="button">LOGOUT</button>
</div>