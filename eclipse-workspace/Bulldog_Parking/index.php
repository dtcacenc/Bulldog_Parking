<?php
require_once 'config.php';
require_once 'google-api-php-client-2.4.0/vendor/autoload.php';

if(isset($_SESSION['access_token'])){
    header('Location: home.php');
    exit();
}
$_SESSION['debug'] = false;
$loginURL=$gClient->createAuthUrl();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bulldog Parking</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- Google Sign-in Meta Tag -->
   <!--   <meta name="google-signin-client_id" content="783182513414-pq4jmbqig9aub9vd03kiqp15kga8os4u.apps.googleusercontent.com">
    -->
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/signin.css" rel="stylesheet" />
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" type="text/javascript" defer></script>

 	 <!-- Google Platform API  -->
    <script src="https://apis.google.com/js/platform.js" async defer></script>
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
	      </ul>
	    </div>
	  </div>
	</nav>
	
	<!-- Container -->
    <div class="container">     
     <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">
            <h5 class="card-title text-center">Sign In</h5>
            <form class="form-signin">
              <div class="form-label-group">
                 <hr class="my-4">
              <button class="btn btn-lg btn-google btn-block text-uppercase" onclick="window.location.assign('<?php  echo $loginURL; ?>')"> Sign in with Google</button>            	
                <input  type="password" style="visibility:hidden;" id="inputPassword" class="form-control" required>
       		  </div>
            </form>
          </div>
        </div>
      </div>
    </div>
		  
    </div>
    <!-- /.container -->
</body>

</html>
