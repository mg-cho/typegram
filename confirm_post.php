<?php 
	require 'config/config.php';

	$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	if($mysqli->connect_errno){
		echo $mysqli->connect_error;
		exit();
	}

	if(!isset($_POST['post']) || empty($_POST['post'])){
		header("Location: index.php");
	}
	else{
		$prep = $mysqli->prepare("INSERT INTO posts(content,user_id,ts) VALUES(?,?,?);");
		$date = date('Y-m-d H:i:s');
		$prep->bind_param("sis",$_POST['post'],$_SESSION['user_id'],$date);
		$executed = $prep->execute();
		if(!$executed){
			echo $mysqli->error;
		}
		$prep->close();

	}



	$mysqli->close();
	header("Location: index.php");




?>

<!DOCTYPE html>
<html>
<head>
	<title>Confirm - Typegram</title>
	<link rel="shortcut icon" type="image/png" href="img/logo-4.png"/>
	
</head>
<body>



</body>
</html>