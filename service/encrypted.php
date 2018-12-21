<?php
class encrypt {
	
 private $options = [
    'cost' => 9,
 ];
 
 
  public function encrypPwd($pwd){
	return password_hash($pwd, PASSWORD_BCRYPT, $this->options); 
 }
 
  public function decrytp($pwd, $hash){
	if (password_verify($pwd, $hash)) { 
    return true; 
    } else { 
    return false; 
   } 
 }
}

?>