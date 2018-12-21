<?php
// Always start this first
session_start();


// if you got errors on login
if (isset($_SESSION['error'] )) {
	$error = $_SESSION['error'] ;	
} else {
	unset($_SESSION['error']);
	$error = "";
}

// save the last request of username
if (isset($_SESSION['saveUsername'] )) {
	$saveUsername = $_SESSION['saveUsername'] ;	
} else {
	unset($_SESSION['saveUsername']);
	$saveUsername = "";
}


?>


<?php include 'header.php';?>

<div class="jumbotron text-center">
  <h1>SERVERS</h1>
  <p>XYZ inc.</p> 
</div>

<div class="row">
     
	 <div class="container col-lg-4 col-md-3 col-xs-2"></div>

        <div class="container col-lg-4 col-md-6 col-xs-8 text-center">
             <!-- LOGIN FORM -->
               <form action="controls.php" method="post">
			     <input type="hidden" name="action" value="login"/>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
							<input type="text" class="form-control" name="username" placeholder="Username" required="required" maxlength="50" value="<?php echo $saveUsername ?>">
						</div>
					</div>
					
					
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
							<input type="password" class="form-control" name="password" placeholder="Password" required="required" maxlength="50">
						</div>
					</div>
					
					
					<div class="form-group">
						<button type="submit" id="login" class="btn btn-primary btn-block btn-lg">Sign In</button>
					</div>

                      <p class="alert alert-danger" <?php  if( empty($error))echo "style=display:none"?>><strong><?php echo $error ?></strong></p>



					<p class="hint-text"><a href="#">Forgot Password?</a></p>
					
				</form>
				
		</div>	
		
		
		<div class="container col-lg-4 col-md-3 col-xs-2"></div>
		
		<script>

		
		</script>

</div>		

<?php include 'footer.php';?>
