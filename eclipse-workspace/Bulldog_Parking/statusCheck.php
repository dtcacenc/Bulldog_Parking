<?php 
    require_once 'config.php';
    if(!isset($_SESSION['access_token'])){
        header('Location: index.php');
        exit();
    }
    $SESSION['debug'] = false;
    
   
    // Establishing Link with Database
    $servername = "avl.cs.unca.edu";
    $username = "dtcacenc";
    $password = "sql4you";
    $link = mysqli_connect($servername, $username, $password);
    
    // Checking connection
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    
    $sql = "SELECT * FROM dtcacencDB.users WHERE google_ID='" . $_SESSION['google_ID']. "' AND status='0'";
    /*
    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
            // if the status is null,
            // ask user to specify his or her status
             * 
             */
            echo '
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <title>Bulldog Parking</title>
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
                <div class="container">
                <br><br>
                 <form action="updateStatus.php" method="POST">
                        <label for="status" class="col-md-6 col-form-label text-md-left">
                        ' . $_SESSION['first_name']
                        . ', please select what status describes you best.</label>
                        <div class="col-md-6 align-middle">
                        	<select class="form-control align-middle" id="status" name="status">
                        		<option value="">select status</option>
                        		<option value="Visitor">Visitor</option>
                        		<option value="Resident">Resident</option>
                        		<option value="Non-Resident">Non-Resident</option>
                        		<option value="Faculty/Staff">Faculty/Staff</option>
                        	</select>         
                          <br>               
                         <button type="submit" value="submit" class="btn btn-primary">Submit
                         </button> 
                        </div>
                   </form>
                </div>
                </body>
                
                </html>
            ';
            exit();
        /*}
    } 
    */
   
        $sql = "SELECT * FROM dtcacencDB.users WHERE google_ID='" . $_SESSION['google_ID']. "'";
        if($result = mysqli_query($link, $sql)){
            if(mysqli_num_rows($result) > 0){
                // Redirect to Home page
                header('Location: home.php');
                exit();
            }
        }

?>