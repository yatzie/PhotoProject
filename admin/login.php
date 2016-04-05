<?php require_once("includes/header.php"); ?>

<?php


//checks if user is loged in othervise redirect to index page
if($session->is_signed_in()) {

	redirect("index.php");

}

//checks user's submitted log in and password to meke sure it matches database one

if(isset($_POST['submit'])) {

	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	$loged_in_user = trim($_POST['username']);

	//method to check database user
	$user_found = User::verify_user($username, $password, $loged_in_user);

	if($user_found) {

		$session->log_in($user_found);
		redirect("index.php");

	} else {

		$the_message = "Your password or username is incorrect";

	}

} else {

	$username = "";
	$password = "";
	$the_message = "";
	$loged_in_user = "";

}



?>


<!-- Loging form -->
<div class="col-md-4 col-md-offset-3">

	<h4 class="bg-danger"><?php echo $the_message; ?></h4>
		
	<form id="login-id" action="" method="post">
		
		<div class="form-group">
			<label for="username">Username</label>
			<input type="text" class="form-control" name="username" value="<?php echo htmlentities($username); ?>" >
		</div>

		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" class="form-control" name="password" value="<?php echo htmlentities($password); ?>">			
		</div>

		<div class="form-group">
			<input id="login_submit" type="submit" name="submit" value="Submit" class="btn btn-primary">
		</div>

		<!-- <div class="form-group">
			<a href="register_form.php">register</a>
		</div> -->
		
		<div class="form-group">
			<a href="../index.php">go back</a>
		</div>


	</form>

</div>