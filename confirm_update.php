<?php
	require 'config/config.php';
	$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	if($mysqli->connect_errno){
		echo $mysqli->connect_error;
		exit();
	}

	$isUpdated = false;

	if (!isset($_POST['username']) || empty($_POST['username'])
		|| ($_POST['mbti']===null) || ($_POST['enn']===null) ) {
			$error = "Please fill out all required fields.";
	}
	else{
		$sql = "UPDATE users
				SET username = '" . $_POST['username'] .
				"', mbti_id = " . $_POST['mbti'] . ", enn_id = "
				. $_POST['enn'] . 
				" WHERE id = " . $_POST['user-id'] . ";";

		$results = $mysqli->query($sql);
		if(!$results){
			echo $mysqli->error;
			exit();
		}
		if($mysqli->affected_rows == 1){
			$isUpdated = true;
		}

	}




?>

<!DOCTYPE html>
<html>
<head>
	<title>Confirm Update - Typegram</title>
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
			<h1 class="col-12 mt-4">Edit Confirmation</h1>
		</div>
	</div>

	<div class="container">
		<div class="row mt-4">
			<div class="col-12">

			<?php if ( isset($error) && !empty($error) ) : ?>
				<div class="text-danger">
					<?php echo $error; ?>
				</div>
			<?php endif; ?>


			<?php if ($isUpdated) : ?>
				<div class="text-success">
					<span class="font-italic"><?php echo $_POST['username']; ?></span> was successfully edited.
				</div>
			<?php endif; ?>

			</div> 
		</div>
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="index.php" role="button" class="btn btn-primary">Home</a>
			</div> 
		</div> 
	</div> 

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	<script>
		$("#active").removeAttr('id');
	</script>
</body>
</html>