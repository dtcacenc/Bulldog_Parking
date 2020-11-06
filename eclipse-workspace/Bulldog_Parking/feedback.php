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
    <title>Feedback</title>
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
	          <a class="nav-link" href="index.php">Home
	                <span class="sr-only">(current)</span>
	              </a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link " href="account.php">Account</a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link " href="carpool.php"><i>Carpool</i></a>
	        </li>
	        	        <li class="nav-item active">
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
        <div class="row">
    <h2>Rate This App</h2>
    <br><br><br>
    <table width="100%" border="0">
      <div class="col-md-9 col-md-offset-0">
        <tr><td width="77%">
        <div class="">
          <form class="form-horizontal" action="fb_to_db.php" method="post">
          <fieldset>
    		
            <!-- Ease of Use -->
            <div class="form-label-group">
              <label class="col-md-3 control-label" for="name"><h5>Ease of Use</h5></label>
              <div class="col-md-9">
   				 <p>Kinda Confusing ... 
              		<input type="radio" id="ease1" name="ease" value="1" />
              		<input type="radio" id="ease2" name="ease" value="2" />
              		<input type="radio" id="ease3" name="ease" value="3" />
              		<input type="radio" id="ease4" name="ease" value="4" />
                    <input type="radio" id="ease5" name="ease" value="5" />
                    ... Very Intuitive!</p>
              </div>
            </div>
            <br>
            
               <!-- Likely to Recommend? -->
            <div class="form-label-group">
              <label class="col-md-3 control-label" for="name"><h5>Likely to Recommend?</h5></label>
              <div class="col-md-9">
              <p>Not really, no...
              		<input type="radio" id="recommend1" name="recommend" value="1" />
              		<input type="radio" id="recommend2" name="recommend" value="2" />
              		<input type="radio" id="recommend3" name="recommend" value="3" />
              		<input type="radio" id="recommend4" name="recommend" value="4" />
                    <input type="radio" id="recommend5" name="recommend" value="5" />
			Extremely Likely!</p>
              </div>
            </div>
    <br>
            <!-- Message body -->
            <div class="form-label-group">
              <label class="col-md-3 control-label" for="message"><h5>Feedback</h5></label>
              <div class="col-md-9">
                <textarea class="form-control" id="message" name="message" placeholder="i,e, constructive criticism or errors you've encountered, as well as features you'd like to see added in future versions. " rows="5"></textarea>
              </div>
            </div>

            <!-- Form actions -->
            <div class="form-group">
              <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-primary btn-md">Submit</button>
                <button type="reset" class="btn btn-default btn-md">Clear</button>
              </div>
            </div>
          </fieldset>
          </form>
        </div>
    </div>
    </td>
    </tr>
    </table>
</div>
    </div>
    <!-- /.container -->
</body>

</html>
