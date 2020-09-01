<?php
	require 'config/config.php';
	$mysqli=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	if($mysqli->connect_errno){
		echo $mysqli->connect_error;
		exit();
	}

	//mbti
	$sql = "SELECT id,type FROM mbti_types;";
	$mbti_results = $mysqli->query($sql);
	if($mbti_results == false){
		echo $mysqli->error;
		exit();
	}
	
	

	//enneagram
	$sql = "SELECT id FROM enn_types;";
	$enn_results = $mysqli->query($sql);
	if($enn_results == false){
		echo $mysqli->error;
		exit();
	}



	$mysqli->close();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Register - Typegram</title>
	<link rel="shortcut icon" type="image/png" href="img/logo-4.png"/>
	<link href="nav.css" rel="stylesheet">
	<link href="main.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
	<!-- link to Bootstrap CSS file -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

</head>
<body>
	<?php require 'nav.php';?>

	<div id="content">
		<h1 class="text-center">Register!</h1>
		<br>
		<form id="registration" action="confirm_registration.php" method="POST">

			<!-- email -->
			<div class="form-group row">
				<label for="email-id" class="col-sm-3 col-form-label text-sm-right">Email: <span class="text-danger">*</span></label>
				<div class="col-7">
					<input type="email" class="form-control" id="email-id" name="email">
					<small id="email-error" class="invalid-feedback text-danger">Email is required.</small>
				</div>
			</div> 

			<!-- username -->
			<div class="form-group row">
				<label for="username-id" class="col-sm-3 col-form-label text-sm-right">Username: <span class="text-danger">*</span></label>
				<div class="col-7">
					<input type="text" class="form-control" id="username-id" name="username">
					<small id="username-error" class="invalid-feedback text-danger">Username is required.</small>
				</div>
			</div> 
		
			<!-- password -->
			<div class="form-group row">
				<label for="password-id" class="col-sm-3 col-form-label text-sm-right">Password: <span class="text-danger">*</span></label>
				<div class="col-7">
					<input type="password" class="form-control" id="password-id" name="password">
					<small id="password-error" class="invalid-feedback text-danger">Password is required.</small>
				</div>
			</div>

			<!-- mbti dropdown -->
			<div class="form-group row">
				<label for="mbti-id" class="col-sm-3 col-form-label text-sm-right">Your MBTI Type: <span class="text-danger">*</span></label>
				<div class="col-7">
					<select name="mbti" id="mbti-id" class="form-control">
						<option value="" selected disabled>-- Choose One! --</option>
						<?php while($row=$mbti_results->fetch_assoc()) :?>
							<option value="<?php echo $row['id'];?>">
								<?php echo $row['type'];?>
							</option>
						<?php endwhile;?>

					</select>
					<small id="mbti-error" class="invalid-feedback text-danger">MBTI type is required.</small>
				</div>
			</div>

			<!-- enneagram dropdown -->
			<div class="form-group row">
				<label for="enn-id" class="col-sm-3 col-form-label text-sm-right">Your Enneagram: <span class="text-danger">*</span></label>
				<div class="col-7">
					<select name="enn" id="enn-id" class="form-control">
						<option value="" selected disabled>-- Choose One! --</option>
						<?php while($row=$enn_results->fetch_assoc()) :?>
							<option value="<?php echo $row['id'];?>">
								<?php echo $row['id'];?>
							</option>
						<?php endwhile;?>
					</select>
					<small id="enn-error" class="invalid-feedback text-danger">Enneagram is required.</small>
				</div>
			</div>



			<!-- submit -->
			<div class="form-group row">
				<div class="ml-auto col-sm-9">
					<span class="text-danger font-italic">* Required</span>
				</div>
			</div> 

			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-7 mt-2">
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="reset" class="btn btn-light">Reset</button>
				</div>
			</div> 


		</form>
	</div>

	

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	<script>
		$("#registration").on("submit", function(event){

			if($("#email-id").val().trim().length == 0){
				$("#email-error").html("Email is required.");
				$("#email-error").removeClass("invalid-feedback");
				event.preventDefault();
				
			}
			else if($("#email-id").val().trim().length > 64){
				$("#email-error").html("Email can be max. 64 characters.");
				$("#email-error").removeClass("invalid-feedback");
				event.preventDefault();
			}
			else{
				$("#email-error").addClass("invalid-feedback");
				
			}

			if($("#username-id").val().trim().length == 0){
				$("#username-error").html("Username is required.");
				$("#username-error").removeClass("invalid-feedback");
				event.preventDefault();
			}
			else if($("#username-id").val().trim().length > 32){
				$("#username-error").html("Username can be max. 32 characters.");
				$("#username-error").removeClass("invalid-feedback");
				event.preventDefault();
			}
			else{
				$("#username-error").addClass("invalid-feedback");
				
			}

			if($("#password-id").val().trim().length == 0){
				$("#password-error").html("Password is required.");
				$("#password-error").removeClass("invalid-feedback");
				event.preventDefault();
			}
			else if($("password-id").val().length > 32){
				$("#password-error").html("Password can be max. 32 characters.");
				$("#password-error").removeClass("invalid-feedback");
				event.preventDefault();
			}
			else{
				$("#password-error").addClass("invalid-feedback");
				
			}

			if($("#mbti-id").val() === null){
				$("#mbti-error").removeClass("invalid-feedback");
				event.preventDefault();
			}
			else{
				$("#mbti-error").addClass("invalid-feedback");
				
			}

			if($("#enn-id").val() === null){
				$("#enn-error").removeClass("invalid-feedback");
				event.preventDefault();
			}
			else{
				$("#enn-error").addClass("invalid-feedback");

			}


		});


	</script>
</body>
</html>