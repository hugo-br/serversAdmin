<?php
$servername = "localhost";
$dbname = "servers";
$username = ""; // enter db username
$password = ""; // enter password username


try {
 $conn = mysqli_connect($servername, $username, $password, $dbname);
  }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
	die;
    }	
?>