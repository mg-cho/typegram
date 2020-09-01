<?php
	require 'config/config.php';

	//if no one's logged in, log them in!
	if(!isset($_SESSION['logged_in']) || !$_SESSION["logged_in"]){
		
		//if user has submitted login form
		if(isset($_POST['email']) && isset($_POST['password'])){
			//if they submitted but left blank
			if(empty($_POST['email']) || empty($_POST['password'])){
				$error = "Please enter email and password.";
			}
			//they submitted email and password
			else{
				$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
				if($mysqli->connect_errno) {
					echo $mysqli->connect_error;
					exit();
				}

				$pass = hash("sha256",$_POST['password']);

				$sql = "SELECT * FROM users WHERE email = '" 
				. $_POST['email'] . "' AND password = '" 
				. $pass . "';";

				$results = $mysqli->query($sql);

				if(!$results){
					echo $mysqli->error;
					exit();
				}
				//if we get one result back, query was correct
				if($results->num_rows == 1){
					$row = $results->fetch_assoc();
					//restart session
					session_destroy();
					session_start();
					$_SESSION['user_id'] = $row['id'];
					$_SESSION['username'] = $row['username'];
					$_SESSION['mbti_id'] = $row['mbti_id'];
					$_SESSION['enn_id'] = $row['enn_id'];
					$_SESSION['logged_in'] = true;
					$_SESSION['permission_id'] = $row['permission_id'];

					//redirect
					header("Location: index.php");
				}
				//if no matches found
				else{
					$error = "Invalid email or password.";
				}
			} //end the correct submission case
		}//end the has-submitted case
	}
	//if someone is logged in, redirect them to home
	else{
		header("Location: index.php");
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login - Typegram</title>
	<link rel="shortcut icon" type="image/png" href="img/logo-4.png"/>
	<link href="nav.css" rel="stylesheet">
	<link href="main.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
	<!-- link to Bootstrap CSS file -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

</head>
<body>
	<?php require 'nav.php';?>

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4 text-center">Login</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">
		
		<form action="login.php" method="POST">
			<div class="form-group row">
				<label for="email-id" class="col-3 col-form-label text-right">Email:</label>
				<div class="col-7">
					<input type="email" class="form-control" id="email-id" name="email">
				</div>
			</div> 

			<div class="form-group row">
				<label for="password-id" class="col-3 col-form-label text-right">Password:</label>
				<div class="col-7">
					<input type="password" class="form-control" id="password-id" name="password">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<div class="col-3"></div>
				<div class="col-7">
					<?php if(isset($error) && !empty($error)) :?>
						<div class="text-danger">
							<?php echo $error;?>
						</div>

					<?php endif;?>

				</div>

			</div>

			<div class="form-group row">
				<div class="col-3"></div>
				<div class="col-7 ">
					<button type="submit" class="btn btn-primary">Login</button>
					<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-light">Cancel</a>
				</div>
			</div> <!-- .form-group -->

		</form>



	</div>
	

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	<script>
		$("#active").removeAttr('id');
	</script>
</body>
</html>