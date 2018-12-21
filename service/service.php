<?php
ini_set("soap.wsdl_cache_enabled", "0"); // disabling WSDL cache
//require('connection.php');  
require('encrypted.php');  

class ServerLookupService {
	
  private $apiKey = '123456';
  
    private $message = array(
            'invalidUser' => 'The username is invalid',
			'invalidPass' => 'The password is wrong',

  );

  
  public function APIValidate($auth){
    if($auth->apiKey != $this->apiKey){
        throw new SoapFault("Server", "Incorrect key");
    }
  }
  

  
  // check if an user exists
  function checkUser($user, $psw) {
	 require('connection.php');  
	 $sql = "SELECT `username`, `id`, `pw` FROM `users` WHERE `username` = '".$user."'";
     $result = mysqli_query($conn, $sql);
     if (mysqli_num_rows($result) >= 1) {
		 $row = mysqli_fetch_assoc($result); 
		   $id =  $row["id"];
		   $username = $row["username"];
		   $hash = $row["pw"];
		   
		   // check password
		  $password = new encrypt(); 
		  $res =  $password->decrytp($psw, $hash);
		 
		 if ( $res == true) {
			 return true;
		 } else {
		    return $this->message['invalidPass'];
		 }
       }
     else {
	      return $this->message['invalidUser'];
	 }
		 
	 mysqli_close($conn); 
  }
  
  
  //insertUser 
  // INSERT INTO `users` (`id`, `username`, `pw`, `mp`) VALUES (NULL, 'test', '$2y$09$tutLVMl3qXBQVzRDOKK6ZeaHhX9M48LBAXkJ2Pf8ryyc9NjT9CXo.', '');
  
  
// return all servers name 
  function getAllServers(){
	  require('connection.php');  
	  $sql = "SELECT * FROM `server`";
	  $result = mysqli_query($conn, $sql);
	  $serveurs = array();
    if (mysqli_num_rows($result) > 0) {
    // output data of each row
      while($row = mysqli_fetch_assoc($result)) {
		 $serveurs[] = $row;
       }
	   
	   return json_encode($serveurs);
     } else {
       return "0 results";
     }

	  mysqli_close($conn);
  }  
  
  
// return all servers name 
  function setOneServer($name, $location, $type){
	  require('connection.php');  
	  $sql = "INSERT INTO `server` (`id`, `name`, `location`, `type`) VALUES (NULL, '".$name."', '".$location."', '".$type."');";
	  
	if (mysqli_query($conn, $sql)) {
      return "Server named ( ".$name." ) has been created successfully.";
    } else {
      return "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

	  mysqli_close($conn);
  }


  function editServer($id, $name, $location, $type) {
	  require('connection.php');  
	  $sql = "UPDATE `server` SET `name` = '".$name."', `location` = '".$location."', `type` = '".$type."' WHERE `server`.`id` = ".$id;
	  
	if (mysqli_query($conn, $sql)) {
      return "Server ".$name." has been edited";
    } else {
      return "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

	
	  mysqli_close($conn);
	  
	  return "It has been edit";
  }  
  

}	 


//$server = new SoapServer("http://localhost/soa/service/web-service.wsdl");
$server = new SoapServer("web-service.wsdl");
$server->setClass("ServerLookupService");
$server->handle();

?>