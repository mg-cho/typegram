<?php
	require 'config/config.php';
	//redirect if the user is not logged in
	if(!isset($_SESSION['permission_id']) || empty($_SESSION['permission_id'])){
		echo "<script> alert('Must register / login before using the search function!'); 
		window.location.href='login.php'; </script>";
	}
	else{

		//store recent search in session (if not null)
		if(isset($_GET['search']) && !empty($_GET['search'])){
			//if this is the first search of the session, create the searches array
			if(!isset($_SESSION['searches'])||empty($_SESSION['searches']) ){
				$searchObj = array("term" => $_GET['search'], "type" =>$_GET['search_type']);
				$searches = array($searchObj);

				$jsonsearch = json_encode($searches);

				$_SESSION['searches'] = $jsonsearch;

				//test if worked
				// $phpsearch = json_decode($_SESSION['searches'], true);

				// echo "<hr> search term ". $phpsearch[sizeof($phpsearch) - 1]["term"] . " added to history!";

			}
			else{
				$phpsearch = json_decode($_SESSION['searches']);
				$searchObj = array("term"=>$_GET['search'],"type"=>$_GET['search_type']);
				array_push($phpsearch,$searchObj);
				$jsonsearch = json_encode($phpsearch);
				$_SESSION['searches'] = $jsonsearch;
				
			}

		}

		//do the search
		$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
		if($mysqli->connect_errno){
			echo $mysqli->connect_error;
			exit();
		}
		//user search
		if($_GET['search_type'] == "users"){
			$sql = "SELECT users.id AS id,username,mbti_types.type AS mbti_type,mbti_types.short_desc AS mbti_desc,
					enn_types.id AS enn_type, enn_types.short_desc AS enn_desc,mbti_types.id AS mbti_id, enncomp   
					FROM users  
					LEFT JOIN mbti_types
						ON users.mbti_id = mbti_types.id
					LEFT JOIN enn_types 
						ON users.enn_id = enn_types.id 
					LEFT JOIN enncomp
						ON users.enn_id = enncomp.enn_id 
					WHERE username LIKE '" . $_GET['search']
					. "%' AND enn_id2 = " . $_SESSION['enn_id'] 
					." ORDER BY username ASC;";
			// echo "<hr>" . $sql . "<hr>";
		}
		//mbti search
		else if($_GET['search_type'] == "mbti_types"){
			$sql = "SELECT * FROM mbti_types
					WHERE type LIKE '%" . $_GET['search']
					. "%';";

		}
		//enneagram search
		else{
			$sql = "SELECT * FROM enn_types
					WHERE id LIKE '%" . $_GET['search']
					. "%';";
		}

		$results = $mysqli->query($sql);
		if(!$results){
			echo $mysqli->error;
			exit();
		}

		$mysqli->close();

	}



?>

<!DOCTYPE html>
<html>
<head>
	<title>Search - Typegram</title>
	<meta charset="UTF-8">
	<link rel="shortcut icon" type="image/png" href="img/logo-4.png"/>
	<link href="nav.css" rel="stylesheet">
	<link href="main.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
	<!-- link to Bootstrap CSS file -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
	<?php require 'nav.php';?>

	<div class="container" id="search-container">
		<div class="row">
			<h2 class="col mt-4">Search Results:</h2>
		</div>
		<div class="row">
			<div class="col">Most recently searched terms: 
			<?php 
				if(isset($_SESSION['searches']) && !empty($_SESSION['searches'])) {
					$recents = json_decode($_SESSION['searches'],true);
					$i = 1;
					$c = 0;
					while((sizeof($recents) - $i)>=0 && $c!=3){
						echo "<strong> " .$i .") ". $recents[(sizeof($recents) - $i)]["term"] . " (" . 
						$recents[(sizeof($recents) - $i)]["type"] . ") </strong>";
						++$c;
						++$i;
					}
				}

			?>
			</div>
		</div>
		<div class="row">
			<div class="mx-auto text-center">
				<!-- render user search results -->
				<?php if($_GET['search_type'] == "users") :?> 
					<table class="table table-dark table-hover table-responsive mt-4">
						<thead>
							<tr>
								<?php if($_SESSION['permission_id'] == 2) :?>

									<th></th>

								<?php endif;?>
								<th>Username</th>
								<th>MBTI</th>
								<th>Description</th>
								<th>Enneagram</th>
								<th>Description</th>
								<th>Comp.</th>
							</tr>
						</thead>
						<tbody>
							<?php while($row=$results->fetch_assoc()) :?>
								<tr class="text-center">
									<?php if($_SESSION['permission_id'] == 2) :?>

										<td><a onclick="return confirm('Are you sure you want to delete this user account?');"
											href="delete.php?user_id=<?php echo $row['id'];?>&username=<?php echo $row['username'];?>" 
											class="btn btn-outline-danger">Delete</a>

											<a href="update.php?user_id=<?php echo $row['id'];?>&username=<?php echo $row['username'];?>&
												mbti_id=<?php echo $row['mbti_id'];?>&enn_id=<?php echo $row['enn_type'];?>"
												class="mt-2 btn btn-warning">Update</a>

										</td>

									<?php endif;?>
									<td><?php echo $row['username'];?></td>
									<td><?php echo $row['mbti_type'];?></td>
									<td><small><?php echo $row['mbti_desc'];?></small></td>
									<td><?php echo $row['enn_type'];?></td>
									<td><small><?php echo $row['enn_desc'];?></small></td>
									<td><a href="<?php echo $row['enncomp'];?>">link</a></td>

								</tr>

							<?php endwhile;?>
						</tbody>
					</table>


				<!-- render mbti search results -->
				<?php elseif($_GET['search_type'] == "mbti_types") :?>
					<?php while ($row=$results->fetch_assoc()) :?>
						<div class="mt-4 mb-4">
							<h3><?php echo $row['type'];?></h3>
							<h4><?php echo "The " . $row['name'];?></h4>
							<div class="col-8 mx-auto">
								<?php echo $row['short_desc'];?>
							</div>
						</div>

					<?php endwhile;?>
				

				<!-- render enneagram search results -->
				<?php else :?>
					<?php while ($row = $results->fetch_assoc()) :?>
						<div class="mt-4 mb-4">
							<h3><?php echo $row['id'];?></h3>
							<h4><?php echo "The " . $row['name'];?></h4>
							<div class="col-8 mx-auto">
								<?php echo $row['short_desc'];?>
							</div>
						</div>
					<?php endwhile;?>

				<?php endif;?>	


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