<?php
require_once 'config.php';
if(!isset($_SESSION['access_token'])){
    header('Location: index.php');
    exit();
}
$_SESSION['debug'] = false;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Carpool</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="css/bootstrap.min.css" rel="stylesheet" />
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" type="text/javascript" defer></script>
   	 <script src="js/bootstrap.bundle.js" type="text/javascript" defer></script>
   	 
</head>


<body>
	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
	  <div class="container">
	    <a class="navbar-brand" href="index.php">
	          <h2> Bulldog Parking</h2>
	    </a>
	    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
	          <span class="navbar-toggler-icon"></span>
	        </button>
	    <div class="collapse navbar-collapse" id="navbarResponsive">
	      <ul class="navbar-nav ml-auto">
	        <li class="nav-item">
	          <a class="nav-link" href="index.php">Home</a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link " href="account.php">Account</a>
	        </li>
	   <li class="nav-item">
	          <a class="nav-link active" href="carpool.php"><i>Carpool</i></a>
	          <span class="sr-only">(current)</span>
	        </li>
			<li class="nav-item">
	          <a class="nav-link " href="feedback.php">Feedback</a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link" href="logout.php">Logout</a>
	        </li>
	      </ul>
	    </div>
	  </div>
	</nav>
	
	<br>
	<!-- Container -->
    <div class="container">   
    	<h5><i> Looking for potential matches...</i></h5>
    	<?php 
           // $diff = (this_user->other_user->to_UNCA) - (this_user->to_UNCA) 
    	   
    	   // if $diff > 0 && $diff < THRESHOLD
    	   
    	   // print
    	   
    	
    	
    	?>
    </div>
    <!-- /.container -->
    
</body>
</html>