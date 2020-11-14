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
	          <a class="nav-link active" href="carpool.php"><i>Carpool (alpha)</i></a>
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
    	<h5><i> Looking for carpoolers...</i></h5>
    	<?php 
        	$client = new \GuzzleHttp\Client();
        	/* ETA() 
        	 * takes http client object and 2 addresses
        	 * makes request to Google Distance Matrix API
        	 * 
        	 * returns the time it takes to travel from addr1 to addr2
        	 * */
        	function ETA($client, $addr1, $addr2){
        	    $url_base = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=";
        	    $a = $addr1 . "&destinations=";
        	    $c = "&key=AIzaSyDGWyTjn7CiwzGc1UeirymO3H-6HIk2F4w";
        	    $url = $url_base . $a .$addr2. $c;
        	    $response = $client->get($url);
        	    if ($response->getStatusCode() == 200){
        	        $json_array = json_decode($response->getBody(), true);
        	        $info = $json_array['rows'];
        	        foreach($info as $i){
        	            foreach($i['elements'] as $elem){
        	                return $elem['duration']['value'];
        	            }
        	        }
        	    }
        	}
    	
    	    $servername = "138.68.228.126";
    	    $username = "drawertl_dtcacenc";
    	    $password = "mysql4you";
    	    $link = mysqli_connect($servername, $username, $password);
    	    
    	    // Check connection
    	    if($link === false){
    	        die("ERROR: Could not connect. " . mysqli_connect_error());
    	    }
    	    $sql = "SELECT google_ID, first_name, address, distance_to_UNCA, email FROM drawertl_dtcacencDB.users;";
    	    $users = array();
    	    if($result = mysqli_query($link, $sql)){
    	        while($row = mysqli_fetch_array($result)){
    	            $ETA = ETA($client,$_SESSION['autocomplete_addr'], $row['address']);
    	            array_push($users, array("name"=>$row['first_name'], "google_ID"=>$row['google_ID'], "address"=>$row['address'],"time_to_UNCA"=>$row['distance_to_UNCA'], "ETA_between_users"=>$ETA, "email"=>$row['email']));
    	        }
    	    }
    	    mysqli_free_result($result);

            echo"<br>";
    	    echo "<table id='table' class='table table-hover'>";
    	    echo "<tr><td><b>Name</td><td><b>Time Added</td></tr>";
    	    foreach($users as $user){
    	        $time_added = ($user['ETA_between_users'] + $user['time_to_UNCA'] ) - $_SESSION['time_to_UNCA'];
    	        if($time_added > 0){
    	            $minutes = floor($time_added/60);
    	            $seconds = $time_added - ($minutes*60);
    	            $mail_to = "mailto:" . $user['email']. "?Subject=Mind Carpooling?";
    	            if($minutes == 0)
                        echo "<tr><td><a href='" . $mail_to ."'>" . $user['name']. "</a></td><td>" . $seconds. "s</td></tr>";
    	             else
    	                       echo "<tr><td><a href='" . $mail_to ."'>" . $user['name']. "</a></td><td>" . $minutes . "m ". $seconds. "s</td></tr>";
    	        }
    	    }
    	    echo "</table>";
    	    
    	
    	?>
    </div>
    <!-- /.container -->
    
</body>
</html>
