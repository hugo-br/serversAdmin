<?php
// Always start this first
session_start();

// check if session is endytified
 if(empty($_SESSION['user']) && empty($_SESSION['token'])) {
        // If they are not, redirect them to the login page.
        header("Location: login.php");
        die("Redirecting to login.php");
    }
?>

<?php include 'header.php';?>
     
	 
	<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token'] ?>"/>

	 
	 <!-- header -->
     <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="">
                <a class="navbar-brand" href="#" style="color:white;">
				Server
                </a>
            </div>
			
			<!-- Logout -->
			<div style="display: inline; float: right;">
			  <form action="controls.php" method="POST">
			  <input name="action" type="hidden" value="logout">
			  <button type="submit" class="btn btn-success navbar-btn ">
			      <span class="glyphicon glyphicon-off"  color=""></span> Log Out 
			  </button>
			   </form>
			</div>
			
        </div>
    </nav>


  <div id="singlePage" ng-app="myApp">
  
	<!-- Main div -->
	<div ng-view class="container-fluid">
	</div>
 </div>
 
<script src="js/main.js"></script>
	



<?php include 'footer.php';?>

