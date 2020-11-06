<?php
require_once 'config.php';
if(!isset($_SESSION['access_token'])){
    header('Location: index.php');
    exit();
}
$SESSION['debug'] = false;


// Establishing Link with Database
$servername = "138.68.228.126";
$username = "drawertl_dtcacenc";
$password = "mysql4you";
$link = mysqli_connect($servername, $username, $password);

// Checking connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Updating table with new status given by user
$_SESSION['status'] = $_POST['status'];
$sql = "UPDATE drawertl_dtcacencDB.users SET status='". $_SESSION['status'] . "'
                                WHERE google_ID='" . $_SESSION['google_ID']. "' ";
mysqli_query($link, $sql);

// Close connection
mysqli_close($link);

//Redirect to Home page
header('Location: status.php');
exit();
?>