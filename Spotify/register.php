<?php 
	include("includes/config.php");
	include("includes/classes/Account.php");
	include("includes/classes/Constants.php");
	$account = new Account($con);
	include("includes/handlers/register-handler.php");
	include("includes/handlers/login-handler.php");

	function getInputValue($name){
		if(isset($_POST[$name])){
			echo $_POST[$name];
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Spotify</title>
	<meta charset="UTF-8" />
    <link rel="icon" type="image/ico" href="spotify-logo.png"  />
	<link rel="stylesheet" type="text/css" href="assets/css/register.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="assets/js/register.js"></script>
</head>
<body>
	<?php
		if(isset($_POST['registerButton'])){
			echo '<script type="text/javascript">
				$(document).ready(function(){

				$("#loginForm").hide();
				$("#registerForm").show();

				});
			</script>';
		} 
		else{
			echo '<script type="text/javascript">
				$(document).ready(function(){

				$("#loginForm").show();
				$("#registerForm").hide();

				});
			</script>';
		} 
		
	 ?>
<div id="background">
	<div id="loginContainer">
		<div id="inputContainer">
		<form id="loginForm" action="register.php" method="POST">
			<h2>Login to your account</h2>
		<p>
			<?php echo $account->getError(Constants::$loginFailed); ?>
			<label for="loginUsername">Username</label>
			<input type="text" name="loginUsername" type="text" placeholder="e.g Andrey Marunyak" value="<?php getInputValue('loginUsername') ?>" required>
		</p>
		<p>
			<label for="loginPassword">Password</label>
			<input type="password" name="loginPassword" type="password" placeholder="Your password" required>
		</p>
		<button type="submit" name="loginButton">LOG IN</button>

			<div class="hasAccountText">
				<span id="hideLogin">Don't have an account yet? Signup here.</span>
			</div>
		</form>


		<form id="registerForm" action="register.php" method="POST">
			<h2>Create your free account</h2>
		<p>
			<?php echo $account->getError(Constants::$userNameCharacters); ?>
			<?php echo $account->getError(Constants::$usernameTaken); ?>
			<label for="username">Username</label>
			<input type="text" name="username" type="text" placeholder="e.g" value="<?php getInputValue('username') ?>" required>
		</p>
		<p>
			<?php echo $account->getError(Constants::$firstNameCharacters); ?>
			<label for="firstname">First name</label>
			<input type="text" name="firstname" type="text" placeholder="e.g Bart" value="<?php getInputValue('firstname') ?>" required>
		</p>
		<p>
			<?php echo $account->getError(Constants::$lastNameCharacters); ?>
			<label for="lastname">Last name</label>
			<input type="text" name="lastname" type="text" placeholder="e.g Simpson" value="<?php getInputValue('lastname') ?>" required>
		</p>
		<p>
			<?php echo $account->getError(Constants::$emailTaken); ?>
			<?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
			<?php echo $account->getError("Your email is invalid"); ?>
			<label for="email">Email</label>
			<input type="email" name="email" type="email" placeholder="e.g bart@gmail.com" value="<?php getInputValue('email') ?>"required>
		</p>
		<p>
			<label for="email2">Confirm email</label>
			<input type="email" name="email2" type="email" placeholder="e.g bart@gmail.com" value="<?php getInputValue('email2') ?>" required>
		</p>

		<p>
			<?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
			<?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
			<?php echo $account->getError(Constants::$passwordCharacters); ?>
			<label for="password">Password</label>
			<input type="password" name="password" type="password" placeholder="Your password" value="<?php getInputValue('password') ?>" required>
		</p>

		<p>
			<label for="password2">Confirm password</label>
			<input type="password" name="password2" type="password" placeholder="Your password" value="<?php getInputValue('password2') ?>" required>
		</p>
		<button type="submit" name="registerButton">SIGN UP</button>

			<div class="hasAccountText">
				<span id="hideRegister">Already have an account? Log in here.
			</div>
		</form>
		</div>
		<div id="loginText">
			<h1>Get great music, right now</h1>
			<h2>Listen to loads of songs for free</h2>
			<ul>
				<li>Discover music you'll fall in love with</li>
				<li>Create your own playlists</li>
				<li>Follow artists to keep up to date</li>
			</ul>
		</div>
	</div>
</div>
</body>
</html>