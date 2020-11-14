<?php 
    require_once 'config.php';
    require_once 'google-api-php-client-2.4.0/vendor/autoload.php';
    if(!isset($_SESSION['access_token'])){
        header('Location: index.php');
        exit();
    }
    $_SESSION['debug'] = false;    
    
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bulldog Parking </title>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="css/bootstrap.min.css" rel="stylesheet" />
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" type="text/javascript" defer></script>
   	 <script src="js/bootstrap.bundle.js" type="text/javascript" defer></script>
     <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>

    <style>
        #progress {width: 100%;background-color:#f4fdf4;border-radius:8px;}
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
	
	<!-- Processing Calendar Events from Google Calendar -->
	<?php 
            /* isCampusBuilding() 
             * takes $string argument and checks for matches with existing hall names 
             * returns boolean */
                function isCampusBuilding ($string){
                    $array = ["OWE", "BEL", "WHI", "ZAG", "RAM", "LIP", "KAR", "PHI", "RRO", "ZEI", "CAR", "HIG", "SHE", "BRO" ];
                    foreach ($array as $building){
                        // if word not found
                        if (stristr($string, $building) == false){
                            // do nothing
                        }else { //else word is part of array, so return
                            // return only when exact match with string from array
                            if (substr($string, strpos($string, $building), 3) == $building){
                                  return true;
                            }
                          }
                        }
                        // default return false
                        return false;
                   }
            
            /* getTomorrow()
             * takes $today argumnet and returns the next day in the week */
                function getTomorrow($today){
                    $week_days = array("MO", "TU", "WE", "TH", "FR", "SA", "SU");
                    for ($i=0; $i<7; $i++){
                        if(strcmp($today, $week_days[$i]) == 0){
                            return $week_days[($i+1)%6];
                        }
                    }
                }
             
            /* Google Client Init */
                $client = new Google_Client();
                $client->setClientId("783182513414-pq4jmbqig9aub9vd03kiqp15kga8os4u.apps.googleusercontent.com");
                $client->setClientSecret("vriR1msy0B4std3n5dcp76me");
                $client->setAccessToken($_SESSION['access_token']);
                $client->setApplicationName("UNCA_Parking");
                $client->setDeveloperKey("AIzaSyDv3teBqgJfgFRIfQ2Dgj5ayYGoZzxkT-s");
                $service = new Google_Service_Calendar($client);
                $events = $service->events->listEvents('primary');
                
            /* userEvent 
             * object to hold info about each event */
                class userEvent {
                    public $name;
                    public $location;
                    public $which_day_of_the_wk;
                    public $start_time;
                }
            
            /* populate array of userEvent Objects with events from calendar*/
                $array_of_events = array();
                while(true) {
                    $i = 0;
                    foreach ($events->getItems() as $event) {
                        if (isCampusBuilding($event->getLocation())) {
                            $array_of_events[$i] = new userEvent();
                            $array_of_events[$i]->name = $event->getSummary();
                            $array_of_events[$i]->location = $event->getLocation();
                                $index = strpos($event->recurrence[0], "BYDAY=")+6;
                            $array_of_events[$i]->which_day_of_the_wk = substr($event->recurrence[0], $index , 15);
                            $array_of_events[$i]->start_time = str_replace(":", ".", substr($event->start->getDateTime(), 11, 5));
                            $i++;
                        }
                        
                    }
                    // flip through pages if there are more events...
                    $pageToken = $events->getNextPageToken();
                    if ($pageToken) {
                        $optParams = array('pageToken' => $pageToken);
                        $events = $service->events->listEvents('primary', $optParams);
                    } else {break;}
                }
            
            /* Now, check which class is closest by time */
                $today =  strtoupper(substr(date("l"), 0, 2));
                $now_time = date("H.i", time());
                $this_day = $today;
                $max_iterations = 7; // 7 days in a week
                $offset = (7 - $max_iterations) * 24; // this is zero on $today, 24 on tomorrow, 48 the next day...
                $largest_neg_value = -168.0; // -(7 * 24) = -168. Minimum possible value (aka next event is a week from now)
                while(true){                     
                    foreach($array_of_events as $event){
                        if($_SESSION['debug']){
                                echo "Class: " . $event->name . "<br>";
                                echo "Location: " . $event->location . "<br>";
                                echo "Day: ". $event->which_day_of_the_wk. "<br>";
                                echo "Time: " . $event->start_time . "<br><br>";
                        }
                        // if event happens on $this_day of the week, or it's a "daily" event
                        if(stristr($event->which_day_of_the_wk, $this_day)!==false || stristr($event->which_day_of_the_wk, "DAILY")!==false ){
                            // compute the difference 
                            $diff = $now_time - ($event->start_time + $offset);
                            // if $diff is negative AND $diff > $largest_neg_value, update the $SESSION['hall_of_class'];
                            
                            if(($diff < 0) && ($diff > $largest_neg_value)){
                                $largest_neg_value = $diff;
                                $_SESSION['event_object'] = $event;
                            }
                        }
                    }
                    // check next day's events
                    if ($max_iterations > 0){
                        $this_day = getTomorrow($this_day); // goes back to beginning of while(true) loop
                        $max_iterations--; // Prevents infinite loop in case there are no events in calendar
                                                         // Loop runs at max=7 times.
                        $offset = (7 - $max_iterations) * 24;
                    }else {
                        break;
                    }
                }            
            ?>
	
	
	
	
	
	<!-- Page Content -->
    <div class="container">           
    <br>
    <div class = "animated fadeIn">
    
    <!--  Table of Lots  -->
    <div class="container-sm">
    	<div class="row justify-content-sm-left">
    		<div class="col">
        	<?php 
                $servername = "138.68.228.126";
                $username = "drawertl_dtcacenc";
                $password = "mysql4you";
                $link = mysqli_connect($servername, $username, $password);
                
                // Check connection
                if($link === false){
                    die("ERROR: Could not connect. " . mysqli_connect_error());
                }
                
                $hall_from_calendar =  substr($_SESSION['event_object']->location, 0 ,3); // get only first 3 characters
                // Get distance values from hall_to_table for specified hall
                $get_sort_values_SQL = "SELECT * FROM drawertl_dtcacencDB.hall_to_lot WHERE
                                                                hall='" . $hall_from_calendar . "';";
                if($result = mysqli_query($link, $get_sort_values_SQL)){
                    if(mysqli_num_rows($result) > 0){
                        $array = mysqli_fetch_array($result);
                        for($i=0; $i < count($array); $i++){
                            // delete entries that do not contain 'p'
                            if (stristr( key($array), "p") == 0) {
                                unset($array[$i]);
                            }
                        }
                        asort($array); // sort array by value
                        if($_SESSION['debug']){
                            echo '<pre>'; print_r($array); echo '</pre>';
                        }
                    }
                }
                mysqli_free_result($result);
                
                /* Welcome message to user */
                if (strcmp($_SESSION['event_object']->location, "" )== 0){
                    $_SESSION['hidden_attr'] = "hidden"; // hide "Distance" column
                    echo "<p>" . $_SESSION['first_name'].", we were not able to find any classes in your calendar.</p><br>";
                } else{
                    $_SESSION['hidden_attr']=""; // show "Distance" column
                    echo "<p>" . $_SESSION['first_name'].", your next class <i>";
                    echo $_SESSION['event_object']->name ."</i> is at  ". $_SESSION['event_object']->start_time;
                    echo " in " . $_SESSION['event_object']->location . ". Don't be late!";
                    echo "</p><br>";
                }
                
                // Build HTML Table
                $sql = "SELECT * FROM drawertl_dtcacencDB.parking_lots";
                if($result = mysqli_query($link, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        echo "<table id='table' class='table table-hover '>";
                        echo "<tr>";
                        echo "<th ". $_SESSION['hidden_attr'] .">Distance</th>";
                        echo "<th>Lot #</th>";
                        echo "<th>Permit</th>";
                        echo "<th>Availability</th>";
                        echo "<th> </th>";
                        echo "</tr>";
                        // populate table rows
                        while($row = mysqli_fetch_array($result)){
                            // quick thing for sort
                            $dist_to_lot = 32;
                            for($z=0; $z<34; $z++){
                                if(strcmp($row['lotID'], $z) == 0){
                                    $dist_to_lot = $array['p'.$z];
                                }
                            }
                            echo "<a href='https://www.google.com/maps/search/?api=1&query=" .$row['coordinates']. "' >";
                            echo "<tr id='" . $row['lotID'] . "' class='card-header' data-toggle='collapse' data-target='#hide" . $row['lotID'] . "' >";
                            echo "<td ". $_SESSION['hidden_attr'] ." id=" . $dist_to_lot  . ">." .$dist_to_lot. " miles</td>";
                            echo "<td><a href='https://www.google.com/maps/search/?api=1&query=" .$row['coordinates']. "' target='_blank'> P" . $row['lotID'] . "</a></td>";
                            echo "<td>" . $row['type'] . "</td>";
                            echo "<td id='P" . $row['lotID'] . "_capacity'>" . $row['total_capacity'] . " </td>";
                            echo "<td><div id='progress'><div class='progress_bar' id='progress_bar" . $row['lotID'] . "'></div></div></td>";
                            echo "</tr>";
                            echo "</a>";
                            
                            /* Buttons: [...deprecated]
                             echo"<tr >
                                            <td >
                                                <a  class=\"btn btn-secondary\" href='https://www.google.com/maps/search/?api=1&query=" .$row['coordinates']. "'>Google Maps</a>
                                                <a  class=\"btn btn-secondary\" href='http://maps.apple.com/?daddr=" .$row['coordinates']. "'>Apple Maps</a>
                                            </td>
                                       </tr>";
                              */
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
        </div>
        <!--  end table of lots -->
    	</div>
    	<!-- end Row -->
   </div>
   <!--  end Animated FadeIn -->

    <!-- get num of cars from file on server -->
	<?php 
        $total_cars_in_p1 = 0;
        $myfile = fopen("./python-scripts/total_cars_in_p1.txt", "r");
        $total_cars_in_p1 = fgets($myfile);
        fclose($myfile);
	?>
    	
    	<!-- Cars in/out Simulation Script-->
    	<script type="text/javascript" defer>
    		/* Return Random Integer */
    		function getRandomInt(min, max) {
    			  min = Math.ceil(min);
    			  max = Math.floor(max);
    			  return Math.floor(Math.random() * (max - min)) + min; 
    			}
    		
			/* functions for when the site loads */
    		window.onload = function() {
				/* SORT TABLE */
				  var table, rows, switching, i, x, y, shouldSwitch;
				  table = document.getElementById("table");
				  switching = true;
				  while (switching) {
				    switching = false;
				    rows = table.rows;
				    /*Loop through all table rows (except the headers):*/
				    for (i = 1; i < (rows.length - 1); i++) {
				      shouldSwitch = false;
				      /*Get the elem from current row and next row*/
				      x = rows[i].getElementsByTagName("td")[0];
				      y = rows[i + 1].getElementsByTagName("td")[0];
				      //check if the two rows should switch place:
				      if (Number(x.id) > Number(y.id)) {
				        //if so, mark as a switch and break the loop:
				        shouldSwitch = true;
				        break;
				      }
				    }
				    if (shouldSwitch) { // swap
				      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
				      switching = true;
				    }
				  }

				/* CARS POPULATE LOT SIMULATION */
    			var lots = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,33];
    			for(var i = 0; i < lots.length; i++){
    				var row = document.getElementById("P" + lots[i] + "_capacity");
    				var capacity = parseInt(row.textContent);	
    				var randInt = getRandomInt(1, capacity);
    				if (i == 0){
							randInt = <?php echo $total_cars_in_p1;?>
        				}
    				var percentage = randInt/capacity;
    				row.innerHTML = randInt + "/" + row.textContent;
    				
    				/* PROGRESS BAR */
                    var elem = document.getElementById("progress_bar" + lots[i]);
                    elem.style.width = percentage*100 + "%"; // if you want progress bar, change this to => percentage*100 + "%";
                    if(percentage>0.89) { elem.style.backgroundColor = "red";}
                    	else if(percentage>0.75){ elem.style.backgroundColor = "#ffcc66";} 
                  }
        	} 

			
    	</script>
    </div>
    <!-- /.container -->
	  <div class="footer-copyright text-center py-3">
        	<small>Distances based on  
        		<a href="https://cloud.google.com/maps-platform/routes/?utm_source=google&utm_medium=cpc&utm_campaign=FY18-Q2-global-demandgen-paidsearchonnetworkhouseads-cs-maps_contactsal_saf&utm_content=text-ad-none-none-DEV_c-CRE_289050149706-ADGP_Hybrid%20%7C%20AW%20SEM%20%7C%20SKWS%20~%20Distance%20API-KWID_43700035908081180-kwd-514129572874-userloc_9010332&utm_term=KW_%2Bdistance%20%2Bapi-ST_%2Bdistance%20%2Bapi&gclid=CjwKCAiAtK79BRAIEiwA4OskBrklNiFBCatwXlFj6dRsfDp9f-sEQT8o2qi84GIXdIhQKQB_Uo8EQRoCyUYQAvD_BwE" >Google Distance Matrix API © 2020</a>
        	</small>
  		</div>
</body>

</html>
