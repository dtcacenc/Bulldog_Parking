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
	          <a class="nav-link " href="carpool.php"><i>Carpool</i></a>
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
                <li class="nav-item"><a href="account.php" class="nav-link">About</a></li>
                <li class="nav-item"><a href="address.php" class="nav-link">Address</a></li>
              	<li class="nav-item"><a href="status.php" class="active nav-link">Status</a></li>
              </ul>
              <div class="tab-content pt-3">
                <div class="tab-pane active">
                           <form class="form" action="updateStatus.php" method="POST" >
                                <div class="form-group">
                                	<select class="form-control align-middle" id="status" name="status">
                                		<option class="text-muted " value="">select status</option>
                                		<option value="Visitor">Visitor</option>
                                		<option value="Resident">Resident</option>
                                		<option value="Non-Resident">Non-Resident</option>
                                		<option value="Faculty/Staff">Faculty/Staff</option>
                                	</select>         
                                </div>
                             	 <div class="form-group">
                                	<button class="btn btn-primary" type="submit">Update Status</button>
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
    <!-- /.container -->
</body>

</html>