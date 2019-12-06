

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bulldog Parking</title>
    
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
    
    
    
    <style>
        #progress {width: 100px;background-color:#f4fdf4;border-radius:8px;}
        .progress_bar {width: 1%;height: 16px;background-color: #4CAF50;border-radius:8px;}
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
	        <li class="nav-item active">
	          <a class="nav-link" href="#">Home
	                <span class="sr-only">(current)</span>
	              </a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link" href="account.php">Account</a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link" href="about.php">About</a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link" href="calendar.php">Calendar</a>
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
     <p>*clicking on a row zooms in on that parking lot*</p>
    <div class = "animated fadeIn">
    <!--  Table of Lots  -->
    	<div class="row justify-content-md-left">
    		<div class="col col-md-4">
    		<script>
    		console.log('accessing avl.cs.unca.edu database...');
    		console.log('creating table for the car lots using parking_lots DB...');
    		</script>
        	<?php 
                $servername = "avl.cs.unca.edu";
                $username = "dtcacenc";
                $password = "sql4you";
                $link = mysqli_connect($servername, $username, $password);
                
                // Check connection
                if($link === false){
                    die("ERROR: Could not connect. " . mysqli_connect_error());
                }
                
                // Attempt select query execution
                $sql = "SELECT * FROM dtcacencDB.parking_lots";
                if($result = mysqli_query($link, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        echo "<table id='table' class='table table-hover'>";
                        echo "<tr>";
                        echo "<th>Lot #</th>";
                        echo "<th>Permission</th>";
                        echo "<th>Capacity</th>";
                        echo "<th> </th>";
                        echo "</tr>";
                        while($row = mysqli_fetch_array($result)){
                            echo "<tr id='" . $row['lotID'] . "'>";
                            echo "<td> P" . $row['lotID'] . "</td>";
                            echo "<td>" . $row['type'] . "</td>";
                            echo "<td id='P" . $row['lotID'] . "_capacity'>" . $row['total_capacity'] . " </td>";
                            echo "<td><div id='progress'><div class='progress_bar' id='progress_bar" . $row['lotID'] . "'></div></div></td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                        // Free result set
                        mysqli_free_result($result);
                    } else{
                        echo "No records matching your query were found.";
                    }
                } else{
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                }
                
                // Close connection
                mysqli_close($link);
            ?>
            </div>
            <!--  end table of lots -->
            <div class="col col-md-1">
            </div>

            <!-- MapBox Map -->
           <div class="col col-md-7"><br>
           <!-- Carpool / Drive Button -->
              <div class="btn-group" role="group" aria-label="Basic example">
                  <button type="button" class="btn btn-secondary" href="carpool.php" id="carpool"> Carpool </button>
                  <button type="button" class="btn btn-secondary" href="drive.php" id="drive"> Drive </button>
        	</div>
        	<br>
            <div  id='map' style='width: 640px; height: 480px;'>
            	<script src="js/MapBox.js" type="text/javascript" defer></script>
            </div>
           </div>
           <!-- end MapBox Map -->
           <br>
           
    	</div>
    	<!-- end Row -->
   </div>
   <!--  end Animated FadeIn -->
    	
    	
    	<!-- Cars in/out Simulation Script-->
    	<script type="text/javascript" defer>
    		/* Return Random Integer */
    		function getRandomInt(min, max) {
    			  min = Math.ceil(min);
    			  max = Math.floor(max);
    			  return Math.floor(Math.random() * (max - min)) + min; 
    			}
    		
    		/* Cars in/out of Random Lots */
    		window.onload = function() {
    			var lots = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,24,25,26,27,28,29,30,31,33];
    			for(var i = 0; i < 31; i++){
    				var row = document.getElementById("P" + lots[i] + "_capacity");
    				var capacity = parseInt(row.textContent);	
    				var randInt = getRandomInt(1, capacity);
    				var percentage = randInt/capacity;
    				row.innerHTML = randInt + "/" + row.textContent;
    				
    				//Progress Bar in Table
                    var elem = document.getElementById("progress_bar" + lots[i]);
                    elem.style.width = percentage*100 + "%";
                    if(percentage>0.89){ elem.style.backgroundColor = "red";}
                    	else if(percentage>0.75){ elem.style.backgroundColor = "#ffcc66";}
                  }
        	}
    	</script>
    
   
    	<!-- File Upload for License Plate Recognition -->
    	  <br>
    	  <br>
    	  <div>
    	  <h2>License Plate Recognition (using external software at the moment)</h2>
    	    <input type="file" id="file-upload-input" class="">
    	  </div>
    	  <div>
    	    <img id="uploadedImage" src="" class="">
    	  </div>
    	  <div id="messages"></div>
    	  
    </div>
    <!-- /.container -->
</body>

</html>
