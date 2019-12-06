

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Calendar</title>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.5.0/mapbox-gl.css' rel='stylesheet' />
    
    <!-- License Plate Recognition JS: lodash.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.4/lodash.min.js" type="text/javascript" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" type="text/javascript" defer></script>
    <script src="js/bootstrap.bundle.js" type="text/javascript" defer></script>
    <script src="js/utils.js" type="text/javascript" defer></script>
    <script src="js/client.js" type="text/javascript" defer></script>
    <script src="js/server.js" type="text/javascript" defer></script>
    <script src="js/OpenALPRAdapter.js" type="text/javascript" defer></script>
    <script src="js/OpenALPRDemo.js" type="text/javascript" defer></script>
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.5.0/mapbox-gl.js'></script>

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
	          <a class="nav-link" href="index.php">Home
	              </a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link" href="account.php">Account</a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link" href="about.php">About</a>

	        </li>
	        <li class="nav-item">
	          <a class="nav-link active" href="calendar.php">Calendar</a>
	          <span class="sr-only">(current)</span>
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
    <br>
       <div class="col col-md-4">
    	 Once signed in, the user will be able to see his or her calendar. The "Sync Calendar" button will allow the program to look through the schedule and, based on the first class of the day, recommend where to park.
    	</div>
    	<br>
        <div class="col col-md-4" >
    		<iframe src="https://calendar.google.com/calendar/embed?src=nonresident.unca%40gmail.com&ctz=America%2FNew_York" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
      	</div> 
    	<br>
    	<div class="col">
             <div class="btn-group" role="group" aria-label="Basic example">
                  <button type="button" class="btn btn-secondary" id="sync"> Sync Calendar </button>
        	</div>
    	</div>
    	<br>
    </div>
    <!-- /.container -->
</body>

</html>
