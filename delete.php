<?php 
	require 'config/config.php';
	$isDeleted = false;

	if(!isset($_GET['user_id']) || !isset($_GET['username']) || empty($_GET['user_id']) || empty($_GET['username'])){
		$error = "Invalid user.";
	}
	else{
		$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
		if($mysqli->connect_errno){
			echo $mysqli->connect_error;
			exit();
		}
		$sql = "DELETE FROM users WHERE id = " . $_GET['user_id'] . ";";
		$results=$mysqli->query($sql);
		if(!$results){
			echo $mysqli->connect_error;
			exit();
		}  
		if($mysqli->affected_rows == 1){
			$isDeleted = true;
		}

	}
	$mysqli->close();


?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<title>Delete - Typegram</title>
	<link rel="shortcut icon" type="image/png" href="img/logo-4.png"/>
	<link href="nav.css" rel="stylesheet">
	<link href="main.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
	<!-- link to Bootstrap CSS file -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<style>
		.btn-primary{
			background-color:#A2C7E5;
			border-color:#A2C7E5;
		}
		.btn-primary:hover{
			background-color:#A2C7E5;
			color:black;
			text-decoration:none;
		}
	</style>
</head>
<body>
	<?php require 'nav.php';?>
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">

				<?php if ( isset($error) && !empty($error)):?>
					<div class="text-danger"><?php echo $error;?></div>
				<?php endif; ?>
				<?php if ($isDeleted):?>
					<div class="text-success"><span class="font-italic"><?php echo $_GET['username']; ?></span> was successfully deleted.</div>
				<?php endif; ?>

			</div> 
		</div> 
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="index.php" role="button" class="btn btn-primary">Back to Home</a>
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