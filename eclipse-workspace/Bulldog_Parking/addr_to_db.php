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


/* Calculate Distance Between Current User and All Other Users*/
$_SESSION['autocomplete_addr'] = $_POST['autocomplete'];
$user1_addr = mysqli_escape_string($link, $_POST['autocomplete']);
$user1_email = mysqli_escape_string($link, $_SESSION['email']);

// Update the new address provided by current user into table
$sql = "UPDATE drawertl_dtcacencDB.users
                SET address='" . $user1_addr . "', distance_to_UNCA=" . $distance_to_UNCA ."
                    WHERE google_ID=".$_SESSION['google_ID'] . ";";
if(!($result = mysqli_query($link, $sql))){
    echo "Failed to connect to MySQL: " . $result -> connect_error;
}

// Select all addresses+emails from user table
$sql = "SELECT address, email  FROM drawertl_dtcacencDB.users;";

$user2_addr = "";
$user_to_user_distance = 0;
if($result = mysqli_query($link, $sql)){
    while ($row = $result->fetch_row()) {
        $user2_addr = $row[0];
        $user2_email = $row[1];

        // build URL request
        $url_base = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=";
        $a = $user1_addr . "&destinations=";
        $b = $user2_addr;
        $c = "&key=AIzaSyDGWyTjn7CiwzGc1UeirymO3H-6HIk2F4w";
        $url = $url_base . $a . $b . $c;
        $response = $client->get($url);
        
        // handle response
        if ($response->getStatusCode() == 200){
            $json_array = json_decode($response->getBody(), true);
            $origin_addr = $json_array['origin_addresses'];
            $dest_addr = $json_array['destination_addresses'];
            $info = $json_array['rows'];
            if($_SESSION['debug']){
                foreach($origin_addr as $addr){
                    echo "<br>___Origin: ";
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
                        echo "Duration: ";
                        echo $elem['duration']['text'] . " / " . $elem['duration']['value'] ."<br>";
                    }
                    $user_to_user_distance = $elem['duration']['value'];
                    $id = $user1_email . $user2_email; 
                    $reverse_id= $user2_email . $user1_email;
                    // Populate Table
                    $sql_stmt = "INSERT INTO drawertl_dtcacencDB.user_to_user_distance(id, reverse_id, distance)
                            VALUES ('".$id."', '". $reverse_id. "', ".$user_to_user_distance.");";
                    if(!($r = mysqli_query($link, $sql_stmt))){
                        echo "Error." . mysqli_error($link);
                    }
                }
            }
        }
    }
}


// Close connection
mysqli_close($link);
// Redirect
header('Location: address.php');
exit();
?>


