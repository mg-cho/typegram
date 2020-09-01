<nav id="menu" class="navbar navbar-dark bg-dark navbar-expand-md" >
	<a class="navbar-brand" href="index.php">
		<img src="img/logo-2.png" alt="Typegram logo">
	</a>
	<!-- collapse button -->
	<button class="ml-auto navbar-toggler my-2" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	 </button>

	<!-- main nav -->
	<div id="navbar" class="collapse navbar-collapse ">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item">
				<a id="active" class="home nav-link" href="index.php">Home</a>
			</li>
			<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true):?>
				<li class="nav-item">
					<a class="profile nav-link" href="profile.php">My Profile</a>
				</li>
			<?php endif;?>
			

		</ul>
		<!-- search bar -->
		<form action="search.php" method="GET" class="form-inline text-right my-2 my-lg-0">
			<div id="searchbar" class="ml-auto">
		      	<input class="form-control col-4" name="search" type="search" placeholder="Search for" aria-label="Search">
		      	<select name="search_type" class="form-control col-3">
				 	<option value="users">Users</option>
				 	<option value="mbti_types">MBTI</option>
				 	<option value="enn_types">Enneagram</option>
				</select>
		      	<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
		      	
		  	</div>
	    </form>
	    <!-- login / register -->
	    <ul class="navbar-nav">
	    	<li class="nav-item">

	    		<?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) :?>
	    			<a id="logout" class="nav-link" href="logout.php">Logout</a>
	    		<?php else :?>
	    			<a id="login" class="nav-link" href="login.php">Login</a>
	    		<?php endif;?>

	    	</li>
	    	<li class="nav-item">
	    		<?php if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true) :?>
	    			<a href="register.php" class="btn btn-primary" role="button">Register</a>
	    		<?php else :?>
	    			<a id="profile" class="nav-link" href="profile.php"><?php echo $_SESSION['username']; ?></a>
	    		<?php endif;?>
	    	</li>
	    </ul>
	</div>



	
</nav> <!-- end nav -->