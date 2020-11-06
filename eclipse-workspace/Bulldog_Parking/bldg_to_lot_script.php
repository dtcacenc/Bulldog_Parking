/* Calculate Distance between building and lot  */
<?php 
            /*
                $servername = "138.68.228.126";
                $username = "drawertl_dtcacenc";
                $password = "mysql4you";
                $link = mysqli_connect($servername, $username, $password);
                
                // Check connection
                if($link === false){
                    die("ERROR: Could not connect. " . mysqli_connect_error());
                }
                
                // set up associative array of building => array of lot #'s
               $array = array('hall'=>array('lot_#'=>'hall_to_lot_distance'));
               
                // calculate bldg_to_lot distance
                $sql_lots = "SELECT * FROM drawertl_dtcacencDB.parking_lots";
                $sql_bldg = "SELECT * FROM drawertl_dtcacencDB.buildings";
                if($result_bldg = mysqli_query($link, $sql_bldg)){
                    // print results 
                    while($bldg = mysqli_fetch_array($result_bldg)){
                        // for each building from database, get longitude and latitude
                        list($lon1, $lat1) = explode(", ", $bldg['coordinates']);
                        // append hall name to array
                        $hall = $bldg['building'];
                        array_push($array, $hall);
                        // now, loop through parking lots
                        $result_lot = mysqli_query($link, $sql_lots);
                        while($lot = mysqli_fetch_array($result_lot)){
                            // get lon and lat coordinates of each lot
                            list($lon2, $lat2) = explode(", ", $lot['coordinates']);
                            //calculate distance between given building and lot
                            $earth_radius = 3961; // Earth's radius in miles. Based on latitude 35.595058
                            $dlon = $lon2 - $lon1;
                            $dlat = $lat2 - $lat1;
                            $a = pow((sin($dlat / 2)), 2) + cos($lat1) * cos($lat2) * pow((sin($dlon / 2)), 2);
                            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                            $distance = $earth_radius * $c / 70.4045003184; // division by 70.___  converts to miles
                            $distance= " " . round($distance*100, 0)." "; // rounds and makes a string
                         
                            // append lot number to lots_array
                            $associative_array = array($hall => array($lot['lotID']=>$distance));
                            array_push($array, $associative_array[0]);
                            
                            // print_r($array);
                            // echo "<br><br>";
                            
                            $sql_update_hall_to_lot ="UPDATE IGNORE drawertl_dtcacencDB.hall_to_lot SET p".$lot['lotID'] ."=". $distance."
                                WHERE hall='". $hall . "'";
                            echo "SQL: " . $sql_update_hall_to_lot . "<br>";
                            mysqli_query($link, $sql_update_hall_to_lot);
                        }
                        echo "<br>";
                    }
                    // Free result set
                    mysqli_free_result($result_bldg);
                    mysqli_free_result($result_lot);
                } else{
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                }

                // Close connection
                mysqli_close($link);
            */?>