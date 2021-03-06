<?php 
    require_once 'config.php';
    require_once 'google-api-php-client-2.4.0/vendor/autoload.php';
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
    
    // Getting current "about" from the user database 
    $sql = "SELECT about FROM drawertl_dtcacencDB.users 
                         WHERE google_ID=" . $_SESSION['google_ID'] . ";";
    $about = "";
    if($result = mysqli_query($link, $sql)){
        while ($row = $result->fetch_row()) {
            $about=$row[0];
        }
    }
    // Getting current "address" from the user database 
    $sql = "SELECT address FROM drawertl_dtcacencDB.users
                         WHERE google_ID=" . $_SESSION['google_ID'] . ";";
    if($result = mysqli_query($link, $sql)){
        while ($row = $result->fetch_row()) {
            $_SESSION['autocomplete_addr']=$row[0];
        }
    }
    
    // Getting current "address" from the user database
    $sql = "SELECT distance_to_UNCA FROM drawertl_dtcacencDB.users
                         WHERE google_ID=" . $_SESSION['google_ID'] . ";";
    if($result = mysqli_query($link, $sql)){
        while ($row = $result->fetch_row()) {
            $_SESSION['time_to_UNCA']=$row[0];
        }
    }
    // Close connection
    mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Account</title>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="css/bootstrap.min.css" rel="stylesheet" />
	<link href="js/EasyAutocomplete-1.3.5/easy-autocomplete.min.css" rel="stylesheet"/>
	
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" type="text/javascript" defer></script>
   	 <script src="js/bootstrap.bundle.js" type="text/javascript" defer></script>
   	 <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
   	 <script src="js/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.min.js"></script>

    <style>
         .animated {
            background-repeat: no-repeat;
            -webkit-animation-duration: 1.5s;
            animation-duration: 1.5s;
            -webkit-animation-fill-mode: both;
            animation-fill-mode: both;
         }
         
         @-webkit-keyframes fadeIn {
            0% {opacity: 0;}
            100% {opacity: 1;}
         }
         
         @keyframes fadeIn {
            0% {opacity: 0;}
            100% {opacity: 1;}
         }
         
         .fadeIn {
            -webkit-animation-name: fadeIn;
            animation-name: fadeIn;
         }
    </style>
</head>


<body>
	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
	  <div class="container">
	    <a class="navbar-brand" href="index.php">
	          <h2> Bulldog Parking </h2>
	    </a>
	    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
	          <span class="navbar-toggler-icon"></span>
	        </button>
	    <div class="collapse navbar-collapse" id="navbarResponsive">
	      <ul class="navbar-nav ml-auto">
	        <li class="nav-item ">
	          <a class="nav-link" href="home.php">Home
	              </a>
	        </li>
	        <li class="nav-item active">
	          <a class="nav-link" href="account.php">Account</a>
	          <span class="sr-only">(current)</span>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link " href="carpool.php"><i>Carpool (alpha)</i></a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link" href="feedback.php">Feedback</a>
	        </li>
	       	<li class="nav-item">
	          <a class="nav-link" href="logout.php">Logout</a>
	        </li>
	      </ul>
	    </div>
	  </div>
	</nav>
	
	
	<!-- Page Content -->
    <div class="container">
   <div class="row flex-lg-nowrap">
<div class = "animated fadeIn">
  <div class="col">
    <div class="row">
      <div class="col mb-3">
        <div class="card">
          <div class="card-body">
            <div class="e-profile">
              <div class="row">
                <div class="col-12 col-sm-auto mb-3">
                  <div class="mx-auto" style="width: 140px;">
                    <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; background-color: rgb(233, 236, 239);">
                      <img src="<?php echo $_SESSION['picture'];?>" height=95% width=95%/>
                      <span style="color: rgb(166, 168, 170); font: bold 8pt Arial;"></span>
                    </div>
                  </div>
                </div>
                <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                  <div class="text-center text-sm-left mb-2 mb-sm-0">
                    <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap"><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name'];?></h4>
                    <p class="mb-0"><?php echo $_SESSION['email'];?></p>
                    <div class="text-muted"><small></small></div>
                    <div class="mt-2">
                    </div>
                  </div>
                  <div class="text-center text-sm-right">
                    <span class="badge badge-secondary"><?php echo $_SESSION['status'];?></span>
                    <div class="text-muted"><small>Joined on <?php echo $_SESSION['date_joined'];?></small></div>
                  </div>
                </div>
              </div>
              
              
              
              <ul class="nav nav-tabs">
                <li class="nav-item"><a href="account.php" class="active nav-link">About</a></li>
                <li class="nav-item"><a href="address.php" class=" nav-link">Address</a></li>
                <li class="nav-item"><a href="status.php" class=" nav-link">Status</a></li>
              </ul>
              <div class="tab-content pt-3">
                <div class="tab-pane active">
                  <form class="form" action="updateBio.php" method="POST" >
                      <textarea name="about" id="about" class="form-control" rows="2" placeholder="My Bio"><?php echo $about;?></textarea>
                      <div class="form-group">
                      	<br>
                        <button class="btn btn-primary" type="submit">Update Bio</button>
                      </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
  </div>
</div>

    </div>
    <!-- /.container -->
</body>

</html>