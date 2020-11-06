<?php 
    require_once 'config.php';
    require_once 'google-api-php-client-2.4.0/vendor/autoload.php';
    if(!isset($_SESSION['access_token'])){
        header('Location: index.php');
        exit();
    }
    $SESSION['debug'] = false;
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Calendar</title>
    
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
	        <li class="nav-item ">
	          <a class="nav-link" href="home.php">Home
	              </a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link" href="account.php">Account</a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link active" href="calendar.php">Calendar</a>
	          <span class="sr-only">(current)</span>
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
    	<br><br><br>
            <?php 
            /* isCampusBuilding() 
             * takes $string argument and checks for matches with existing hall names 
             * returns boolean */
                function isCampusBuilding ($string){
                    $array = ["OWE", "BEL", "WHI", "ZAG", "RAM", "LIP", "KAR", "PHI", "RRO", "ZEI", "CAR", "HIG", "SHE", "BRO" ];
                    foreach ($array as $building){
                        if (stristr($string, $building) == false){
                            // do nothing
                        }else {
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
                            $array_of_events[$i]->location = substr($event->getLocation(), 0, 3);
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
                $max_iterations = 7;
                while(true){
                    $largest_neg_value = -24.9;
                    foreach($array_of_events as $event){
                        if($SESSION['debug']){
                            echo "Class: " . $event->name . "<br>";
                            echo "Location: " . $event->location . "<br>";
                            echo "Time/Day: " . $event->start_time . "/" . $event->which_day_of_the_wk. "<br><br>";
                        }
                        // if event happens on $today's day of the week,
                        if(stristr($event->which_day_of_the_wk, $this_day)==$this_day || stristr($event->which_day_of_the_wk, "DAILY")=="DAILY" ){
                            // compute the difference 
                            $diff = $now_time - $event->start_time;
                            // if $diff is negative and larger than $largest_neg_value, update the $SESSION['hall_of_class'];
                            if($diff < 0 && $diff > $largest_neg_value){
                                $largest_neg_value = $diff;
                                $_SESSION['hall_of_class'] = $event->location;
                            }
                        }
                    }
                    // if $largest_neg_value is still -24.9, check the tomorrow's events
                    if ($largest_neg_value == -24.9 && $max_iterations > 0){
                        $this_day = getTomorrow($today); // goes back to beginning of while(true) loop
                        $max_iterations--; // Prevents infinite loop in case there are no events in calendar
                                                         // Loop runs at max=7 times.
                    }else {
                        break;
                    }
                }            
            ?>
    	<br>
    </div>
    <!-- /.container -->
</body>

</html>
