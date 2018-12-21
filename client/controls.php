<?php

// check if the request come from the same origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    $address = 'http://' . $_SERVER['SERVER_NAME'];
    if (strpos($address, $_SERVER['HTTP_ORIGIN']) !== 0) {
        exit(json_encode([
            'error' => 'Invalid Origin header: ' . $_SERVER['HTTP_ORIGIN']
        ]));
    }
} else {
    exit(json_encode(['error' => 'No Origin header']));
}

session_start();

require('../service/encrypted.php');
$action =  $_POST['action'];
$apiKey = "123456"; // validate api for do a service request
//$url = 'http://localhost/soa/service/web-service.wsdl';
$url = '../service/web-service.wsdl';
ini_set("soap.wsdl_cache_enabled", "0"); // disabling WSDL cache

class requestLookupAuth 
{ 
    public $apiKey; 
    public function __construct($key) 
    { 
        $this->apiKey = $key; 
    } 
} 


switch($action){
	
	 case "login":
      login($apiKey, $url);
	 break;
	 
	 case "logout":
	   echo "here";
        logout();
	 break;

	 
	 case "servers":
	 if (!empty($_POST['token'])) {
        if (hash_equals($_SESSION['token'], $_POST['token'])) {
	      getAllServers($apiKey, $url);
		} else {
          // Mistach between session token and post token
		  session_destroy();				
		}
	 } else {
          // no token destroy session
		  session_destroy();			 
	 }
	 break;
	 
	 case "edit":
	 if (!empty($_POST['token'])) {
        if (hash_equals($_SESSION['token'], $_POST['token'])) {
	      editServers($apiKey, $url);
		} else {
          // Mistach between session token and post token
		  session_destroy();				
		}
	 } else {
          // no token destroy session
		  session_destroy();			 
	 }
	 break;	 
	  
	  
	 case "add":
	 if (!empty($_POST['token'])) {
        if (hash_equals($_SESSION['token'], $_POST['token'])) {
	      addServer($apiKey, $url);
		} else {
          // Mistach between session token and post token
		  session_destroy();				
		}
	 } else {
          // no token destroy session
		  session_destroy();			 
	 }
	 break;	 	  
}






// ************************************ //	
// *********    FUNCTIONS    ********** //
// ************************************ //	


// login 
function login($apiKey, $url) {
	
	// check if username and password
    if(empty($_POST['username']) || empty($_POST['password'])){
	   $_SESSION['error'] = "You must provide valid username and password";
       $_SESSION['saveUsername'] = $_POST['username'];
	   header("Location: login.php");
       die("Redirecting to login.php");
    }
	
  // username and password sent from form 
   $_SESSION['saveUsername'] = $_POST['username'];
   $myusername= $_POST['username']; 
   $mypassword= $_POST['password']; 	
   $myusername = stripslashes($myusername);
   $mypassword = stripslashes($mypassword);
   
   // Do the request to the service
   $auth  = new requestLookupAuth($apiKey); 
   $header = new SoapHeader($url, "APIValidate", $auth, false);  
   $client = new SoapClient($url); 
   $array = array(
            'user' => $myusername,
			'pwd' =>   $mypassword
   );
   
     try {
         // check if user exist and password is valid 
		$result = $client->__soapCall("checkUser", $array, NULL, $header);  
		 
		 if($result == 1){
             $_SESSION['error'] = '';
			 $_SESSION['user'] = $myusername; 
			 // set up session Token
			  if (function_exists('mcrypt_create_iv')) {
                  $_SESSION['token'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
               } else {
                 $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
               }
	         header("Location: index.php");
             die("Redirecting to index.php");			 
		 } else {
	        $_SESSION['error'] = $result;	 
	        header("Location: login.php");
            die("Redirecting to login.php");	
		 }
		 
		 	 
	 }  catch (SoapFault $exception) {
          $_SESSION['error'] = 'An error happens please retry later'.$exception->faultstring;
          $_SESSION['saveUsername'] = $_POST['username'];
	      header("Location: login.php");
          die("Redirecting to login.php");		  
          echo 'Exception Thrown: '.$exception->faultstring.'<br><br>';  
     }
}


function logout(){
	      session_unset();
          session_destroy();
	      header("Location: login.php");
          die("Redirecting to login.php");	
          exit();
}


function getAllServers($apiKey, $url) {
		 
	// Do the request to the service
     $auth  =  new requestLookupAuth($apiKey); 
     $header = new SoapHeader($url, "APIValidate", $auth, false);  
     $client = new SoapClient($url); 
   
     // call the webservice
     try {
		  $result = $client->__soapCall("getAllServers", array(''), NULL, $header);  
	      echo $result; 
	 }  catch (SoapFault $exception) {	  
          echo 'Exception Thrown: '.$exception->faultstring.'<br><br>';  
     }
}


 function editServers($apiKey, $url) {  	
  
    $id = $_POST['serverId'];
    $name = $_POST['serverName'];
    $location = $_POST['serverLocation'];
	$type = $_POST['serverType'];
 
    $array = array(
        'id' => $id,
		'name' => $name,
		'location' => $location,
		'type' => $type
     );
  
  	 // Do the request to the service
     $auth  =  new requestLookupAuth($apiKey); 
     $header = new SoapHeader($url, "APIValidate", $auth, false);  
     $client = new SoapClient($url); 
   
     // call the webservice
     try {
		  $result = $client->__soapCall("editServer", $array, NULL, $header);  
	    echo $result; 
	 }  catch (SoapFault $exception) {	  
          echo 'Exception Thrown: '.$exception->faultstring.'<br><br>';  
     }    
 }
 
 
 
 function addServer($apiKey, $url) {  	
  
    $name = $_POST['serverName'];
    $location = $_POST['serverLocation'];
	$type = $_POST['serverType'];
 
    $array = array(
		'name' => $name,
		'location' => $location,
		'type' => $type
     );
  
  	 // Do the request to the service
     $auth  =  new requestLookupAuth($apiKey); 
     $header = new SoapHeader($url, "APIValidate", $auth, false);  
     $client = new SoapClient($url); 
   
     // call the webservice
     try {
		  $result = $client->__soapCall("setOneServer", $array, NULL, $header);  
	    echo $result; 
	 }  catch (SoapFault $exception) {	  
          echo 'Exception Thrown: '.$exception->faultstring.'<br><br>';  
     }    
 }


?>