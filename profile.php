<?php
	require 'config/config.php';
	$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	if($mysqli->connect_errno){
		echo $mysqli->connect_error;
		exit();
	}

	//get combo desc
	$sql = "SELECT * FROM combos 
			WHERE mbti_id = " .$_SESSION['mbti_id'] .
			" AND enn_id = " . $_SESSION['enn_id'] . ";";
	
	$results=$mysqli->query($sql);

	if(!$results){
		echo $mysqli->error;
		exit();
	}
		
	$combo_results = $results->fetch_assoc();

	//get mbti type,name & desc
	$sql = "SELECT * FROM mbti_types
			WHERE id = " . $_SESSION['mbti_id'] . ";";
	$results=$mysqli->query($sql);
	if(!$results){
			echo "AAS";
		echo $mysqli->error;
		exit();
	}
	$mbti_results = $results->fetch_assoc();

	//get enn id & desc
	$sql = "SELECT * FROM enn_types
			WHERE id = " . $_SESSION['enn_id'] . ";";
	$results=$mysqli->query($sql);
	if(!$results){
		echo $mysqli->error;
		exit();
	}
	$enn_results = $results->fetch_assoc();
	
	//get the user's posts
	$sql = "SELECT * FROM posts 
			WHERE user_id = " . $_SESSION['user_id'] . 
			" ORDER BY ts DESC;";
	$post_results=$mysqli->query($sql);
	if(!$post_results){
		echo $mysqli->error;
		exit();
	}

	$mysqli->close();


?>

<!DOCTYPE html>
<html>
<head>
	<title>Profile - Typegram</title>
	<link rel="shortcut icon" type="image/png" href="img/logo-4.png"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="nav.css" rel="stylesheet">
	<link href="main.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
	<!-- link to Bootstrap CSS file -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<style>
		#head4{
			background-color: #32021F;
			color:white;
			padding:2%;
			border-radius:10px;
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
			<div class="col-12">
				<h2><?php echo $_SESSION['username']. "'s Profile";?></h2>
				<p><?php echo "<em> " . $combo_results['combo_desc'] . "</em>";?></p>

			</div>

		</div> <!-- end profile header row -->

		<div class="row mt-4">
			<!-- mbti col -->
			<div class="col-md-6 col-sm-12 pr-4">
				<h3><?php echo $mbti_results['type'] . ", the " . $mbti_results['name'];?></h3>
				<p><?php echo $mbti_results['short_desc'];?></p>
			</div>
			<!-- enn col -->
			<div class="col-md-6 col-sm-12">
				<h3><?php echo $enn_results['id'] . ", the " . $enn_results['name'];?></h3>
				<p><?php echo $enn_results['short_desc'];?></p>
			</div>
		</div> <!-- end mbti + enneagram row -->

		<div class="row">
			<div class="col-12">
				<h4 id="head4" class="text-center mb-4">My Posts 
					<a href="#" id="toggle" class="toggle-hide ml-3 btn-sm btn btn-light" role="button">hide</a>
				</h4>
				<div id="post-container">
					<?php while($row = $post_results->fetch_assoc()) :?>
						<div class="post-content container p-4 mb-4">
							<h4><?php echo $_SESSION['username'];?></h4>
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
					<?php endwhile;?>
				</div> <!-- end post-container -->

			</div> <!-- end posts col -->

		</div> <!-- end posts row -->

	</div>

	

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	<script>
		$("#active").removeAttr('id');
		$(".profile").attr('id','active');

		$("#toggle").on("click",function(){
			//if the user wants to hide the posts
			if($("#toggle").hasClass("toggle-hide") ){
				$("#toggle").removeClass("toggle-hide").addClass("toggle-show");
				$("#toggle").html("show");
				$("#post-container").addClass("d-none");
			}
			else{
				$("#toggle").removeClass("toggle-show").addClass("toggle-hide");
				$("#toggle").html("hide");
				$("#post-container").removeClass("d-none");
			}
		});
			
		
	</script>
</body>
</html>