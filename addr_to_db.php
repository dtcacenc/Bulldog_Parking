<?php
require_once 'config.php';
if(!isset($_SESSION['access_token'])){
    header('Location: index.php');
    exit();
}
$_SESSION['debug'] = false;

/* CALCULATE DISTANCE FROM UNCA TO USER */
$client = new \GuzzleHttp\Client();
$distance_to_UNCA = 0;
$unca_addr = "1 University Heights, Asheville, NC 28804";
$user_addr = $_POST['autocomplete'];
$url_base = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=";
$a = $unca_addr . "&destinations=";
$b = $user_addr;
$c = "&key=AIzaSyDGWyTjn7CiwzGc1UeirymO3H-6HIk2F4w";
$url = $url_base . $a . $b . $c;
$response = $client->get($url);

if ($response->getStatusCode() == 200){
    $json_array = json_decode($response->getBody(), true);
    $origin_addr = $json_array['origin_addresses'];
    $dest_addr = $json_array['destination_addresses'];
    $info = $json_array['rows'];
    if($_SESSION['debug']){
        foreach($origin_addr as $addr){
            echo "______Origin: ";
            //echo $origin;
            echo $addr;
            echo "<br>";
        }
        
        foreach( $dest_addr as $addr){
            echo "Destination: ";
            //echo $dest;
            echo $addr;
            echo "<br>";
        }
    }
    
    foreach($info as $i){
        foreach($i['elements'] as $elem){
            if($_SESSION['debug']){
                //echo $elem['distance']['text'] . "<br>";
                echo "___Duration: ";
                echo $elem['duration']['text'] . " / " . $elem['duration']['value'] ."<br>";
            }
            $distance_to_UNCA =  $elem['duration']['value'];
        }
    }
}

// Establish Link with Database
$servername = "138.68.228.126";
$username = "drawertl_dtcacenc";
$password = "mysql4you";
$link = mysqli_connect($servername, $username, $password);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


/* Update $_SESSION user address */
$_SESSION['autocomplete_addr'] = $_POST['autocomplete'];
$user1_addr = mysqli_escape_string($link, $_POST['autocomplete']);

// Update the new address provided by current user into table
$sql = "UPDATE drawertl_dtcacencDB.users
                SET address='" . $user1_addr . "', distance_to_UNCA=" . $distance_to_UNCA ."
                    WHERE google_ID=".$_SESSION['google_ID'] . ";";
if(!($result = mysqli_query($link, $sql))){
    echo "Failed to connect to MySQL: " . $result -> connect_error;
}


// Close connection
mysqli_close($link);
// Redirect
header('Location: address.php');
exit();
?>


