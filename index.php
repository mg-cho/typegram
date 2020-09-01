<?php
	require 'config/config.php';
	//get first 20 rows
	$mysqli=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	if($mysqli->connect_errno){
		echo $mysqli->connect_error;
		exit();
	}

	$sql = "SELECT content,username,ts FROM posts 
			LEFT JOIN users
				ON posts.user_id = users.id
			ORDER BY ts DESC
			LIMIT 8;";
	$results=$mysqli->query($sql);
	if(!$results){
		echo $mysqli->connect_error;
		exit();
	}
	
	if(isset($_SESSION['mbti_id']) && isset($_SESSION['enn_id'])){
		//get mbti and enneagram
		$mbti = "SELECT type,name FROM mbti_types
				WHERE id = " . $_SESSION['mbti_id'] . ";";
		$mresults = $mysqli->query($mbti);
		if(!$mresults){
			echo $mysqli->connect_error;
			exit();
		}
		$mrow=$mresults->fetch_assoc();

		$enn = "SELECT id,name FROM enn_types
				WHERE id = " . $_SESSION['enn_id'] . ";";
		$eresults = $mysqli->query($enn);
		if(!$eresults){
			echo $mysqli->connect_error;
			exit();
		}
		$erow=$eresults->fetch_assoc();
	}

	$mysqli->close();



?>

<!DOCTYPE html>
<html>
<head>
	<title>Home - Typegram</title>
	<link rel="shortcut icon" type="image/png" href="img/logo-4.png"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="nav.css" rel="stylesheet">
	<link href="main.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
	<!-- link to Bootstrap CSS file -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<style>

		#recent{
			padding-left:0px;
		}
		h4{
			margin:0px;
		}
		#wrapper{
			border-radius:10px;
			background-color:white;
		}
		#sidebar{
			border-radius:10px;
		}
		.sidebar-img{
			width:80%;
		}
		#link{
			color:#8FCB9B;
		}
		.jumbotron{
			border-radius: 10px;
		}
		.btn-primary{
			background-color:#A2C7E5;
			border-color:#A2C7E5;
		}
		.btn-primary:hover{
			background-color:#A2C7E5;
			color:black;
			text-decoration:none;
		}
		body .post-content{
			color:#32021F;
			background-color:#A2C7E5;
			border-radius:10px;
		}

	</style>
</head>
<body>
	<?php require 'nav.php';?>

	<div class="container mt-4 mb-4">
		<div class="row">
			<div class="col-md-9 col-sm-12">
				<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true) :?>
					<form class="pr-4 pl-4 pt-4 pb-2" id="make-post" method="POST" action="confirm_post.php">
						<div class="form-group">
							<label for="text-post">Make a post:</label>
	    					<textarea class="form-control mb-2" id="text-post" name="post" rows="3"></textarea>
	    					<button type="submit" class="btn btn-success">Post</button>
							<a href="index.php" role="button" class="btn btn-light">Cancel</a>
							<small id="text-error" class="invalid-feedback text-danger">Write something!</small>

						</div>
					</form>
				<?php else :?>
					<div class="jumbotron text-center bg-dark">
						<h2 class="display-4">Welcome to Typegram!</h2>
						<p>Your way to keep track of your personality types, and make friends while you do it.</p>
						<br>
						<a href="register.php" class="btn-lg btn-primary" role="button">Sign up now!</a>
					</div>

				<?php endif;?>
				<div id="recent" class="container mt-4 ">
					<h3>Recent posts:</h3>
				</div>
				<div id="wrapper" class="container p-4">
					<?php while($row=$results->fetch_assoc()) :?>
						<div class="post-content container p-4">
							<h4><?php 
									if(!isset($row['username']) || empty($row['username']) ){
										echo "[deleted user]";
									}
									else{
										echo $row['username'];	
									}	
								?>
								
							</h4>
							<div><?php echo $row['content'];?></div>
							<small>Posted on:
								<?php 
									$time = new DateTime();
									$time->setTimestamp(strtotime($row['ts']));
									$time->setTimezone(new DateTimeZone('America/Los_Angeles'));
									echo $time->format('m/d/Y') . " at " . $time->format('g:ia');
								?>
									
								</small>

						</div>
						<br>
					<?php endwhile;?>
				</div>

				
			</div>
			<!-- <div class="col-1"></div> -->
			<div class="col-md-3 col-sm-12 mt-md-0 mt-sm-4 mb-sm-4 text-center">
				<div id="sidebar" class="container p-4 bg-dark">

					
					<p>Use the searchbar to search for users and check your compatibilities!</p>
					<p>You can also search the different MBTI and Enneagram types.</p>

					<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) :?>
						<h5><?php echo "Your MBTI: <br>" . $mrow['type'] . ", the " . $mrow['name'];?></h5>
						<h5><?php echo "Your Enneagram: <br>" . $erow['id'] . ", the " . $erow['name'];?></h5>
					<?php else:?>
						<h5>Already have an account? Login <a href="login.php" id="link">here</a>!</h5>

					<?php endif;?>
					<img src="img/logo-4.png" class=" sidebar-img img-fluid">

						
				</div>
				
				
			</div>

		</div>
		
	</div>

	<!-- <footer class="page-footer bg-dark p-4 text-center text-white">&copy;2020 Maia Cho</footer> -->

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	<script>
		$("#make-post").on("submit",function(event){
			//if textarea blank, display error message
			if($("#text-post").val().trim().length == 0){
				$("#text-error").removeClass("invalid-feedback");
				event.preventDefault();
			}
			else if($("#text-post").val().trim().length > 500){
				$("#text-error").html("Post length cannot be over 500 characters.");
				$("#text-error").removeClass("invalid-feedback");
				event.preventDefault();
			}
			else{
				$("#text-error").addClass("invalid-feedback");
			}

		});

	</script>
</body>
</html>