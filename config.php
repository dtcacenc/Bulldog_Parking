<?php
    session_start();
    require_once "google-api-php-client-2.4.0/vendor/autoload.php";
    $gClient = new Google_Client();
    $gClient->setClientId("783182513414-pq4jmbqig9aub9vd03kiqp15kga8os4u.apps.googleusercontent.com");
    $gClient->setClientSecret("vriR1msy0B4std3n5dcp76me");
    $gClient->setApplicationName("Bulldog Parking");
    $gClient->setRedirectUri("http://arden.cs.unca.edu/~dtcacenc/UNCA_Parking/g-callback.php");
    $gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/calendar.readonly");
    
?>