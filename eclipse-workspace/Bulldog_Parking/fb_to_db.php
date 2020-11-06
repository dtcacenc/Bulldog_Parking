<?php
require_once 'config.php';
if(!isset($_SESSION['access_token'])){
    header('Location: index.php');
    exit();
}
$_SESSION['debug'] = false;


// Establishing Link with Database
$servername = "138.68.228.126";
$username = "drawertl_dtcacenc";
$password = "mysql4you";
$link = mysqli_connect($servername, $username, $password);

// Checking connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Insert into table 
$name = mysqli_escape_string($link, $_SESSION['first_name']);
$email = mysqli_escape_string($link, $_SESSION['email']);
$message = mysqli_escape_string($link, $_POST['message']);
$ease =  mysqli_escape_string($link, $_POST['ease']);
$recommend = mysqli_escape_string($link, $_POST['recommend']);

$sql = "INSERT INTO drawertl_dtcacencDB.feedback (name, email, message, ease, recommend) VALUES ('" . $name . "', '" . $email . "', '" .$message."', '". $ease ."', '". $recommend . "');";

if($result = mysqli_query($link, $sql)){
    // Close connection
    mysqli_close($link);
} else {
    echo "Error." . mysqli_error($link);
    // Close connection
    mysqli_close($link);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Feedback</title>
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
	          <a class="nav-link" href="index.php">Home
	                <span class="sr-only">(current)</span>
	              </a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link " href="account.php">Account</a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link " href="about.php">About</a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link " href="calendar.php">Calendar</a>
	        </li>
	        	        <li class="nav-item active">
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
        <div class="row">
    <h3>Thank you! Your feedback has been recorded.</h3>
    <br></br>
    <a href="home.php">Take me home!</a>
</div>
    </div>
    <!-- /.container -->
</body>

</html>
