<?php
    require_once "config.php";
    if(isset($_SESSION['access_token'])){
        $gClient->setAccessToken($_SESSION['access_token']);
    } else if(isset($_GET['code'])) {
        $token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
        $_SESSION['access_token'] = $token;
    } else {
        //redirect to login page
        header('Location: index.php');
        exit();
    }
    $_SESSION['debug'] = false;
    
    
    $oAuth = new Google_Service_Oauth2($gClient);
    $userData = $oAuth->userinfo_v2_me->get();
    
    // Setting global session vars for PHP
    $_SESSION['google_ID'] = $userData['id'];
    $_SESSION['email'] = $userData['email'];
    $_SESSION['first_name'] = $userData['given_name'];
    $_SESSION['last_name'] = $userData['family_name'];
    $_SESSION['picture'] = $userData['picture'];
    
    
    /* Register User with the MySQL Database */
    // Login Credentials
    $servername = "138.68.228.126";
    $username = "drawertl_dtcacenc";
    $password = "mysql4you";
    $db = "drawertl_dtcacencDB";
    $link = mysqli_connect($servername, $username, $password, $db);
    
    // Check connection
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    
    $input_google_ID =   $_SESSION['google_ID'];
    $input_first_name = $_SESSION['first_name'];
    $input_last_name =  $_SESSION['last_name'];
    $input_email = $_SESSION['email'];
    $date = date("m.d.Y");
    // Add New User to the Users Table
    $sql = "INSERT IGNORE INTO drawertl_dtcacencDB.users (google_ID, first_name, last_name, email)
              VALUES ('$input_google_ID','$input_first_name', '$input_last_name', '$input_email')";
  
    $result = mysqli_query($link, $sql);
    if(!($result)){
        die("ERROR: Could not able to execute $sql. " . mysqli_error($link));
    }
    
    // Set $_SESSION['status'] = "status" from the user database
    $sql = "SELECT status FROM drawertl_dtcacencDB.users
                     WHERE google_ID='" . $_SESSION['google_ID'] . "' ";
    if($result = mysqli_query($link, $sql)){
        while ($row = $result->fetch_row()) {
            $_SESSION['status'] =$row[0];
        }
    }
        // Set date_joined in database if not yet set
        $sql = "SELECT date_joined FROM drawertl_dtcacencDB.users
                     WHERE google_ID='" . $_SESSION['google_ID'] . "' ";
        if($result = mysqli_query($link, $sql)){
            while ($row = $result->fetch_row()) {
                if($row[0] == NULL){
                    mysqli_query($link, "UPDATE drawertl_dtcacencDB.users SET date_joined = '".  $date ."'
                                                        WHERE google_ID='" . $_SESSION['google_ID']. "'");
                    $result = mysqli_query($link, $sql);
                    $row = $result->fetch_row();
                }
                $_SESSION['date_joined'] =$row[0];
            }
            /* free result set */
            $result->close();
        }
        // Close connection
    mysqli_close($link);

    // Redirect to account page
    header('Location: account.php');
    exit();
   
?>