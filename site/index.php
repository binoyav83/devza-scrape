<?php
	session_start();
	include 'bootstrap.php';
	$errorMessage = ''; 
	if (isset($_POST['username']) && isset($_POST['password'])) {
		//print_r($_POST);
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		if ($username == SITE_USERNAME && $password == SITE_PASS) {
 			$_SESSION['user'] = $username;
 			header('Location: profile.php');
 			exit;
		}
		else {
			$errorMessage = 'Invalid username/password';
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>K2S</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	<link rel="stylesheet" href="css/app.css">
</head>
<body>
	<div class="wrapper fadeInDown">
  	<div id="formContent">
  		<?php if ($errorMessage): ?>
  			<div class="alert alert-danger"><?php echo $errorMessage; ?></div>
		<?php endif; ?>
		<form method="post">
	  		<div class="form-group">
 			    <label for="username">User Name</label>
			    <input type="text" id="username" class="form-control" name="username" placeholder="User Name" required>
			     
	  		</div>
	  		<div class="form-group">
			    <label for="password">Password</label>
			    <input type="password" name="password" class="form-control" id="password">
			</div>
			
	 		<button type="submit" name="btn" class="btn btn-primary">Sign In</button>
		</form>	
	</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

</body>
</html>