<?php
class Session{
	public $user_id;
	private $logged_in = false;
	public $message;
	
	function __construct(){
		session_start();
		$this->check_login();
		$this->check_message();
		if(!$this->is_logged_in()){
			//redirect_to('login.php');
		}
	}
	
	public function login($user){
		if(isset($user)){
		
			$this->user_id  = $user;
			$_SESSION['user_id']=  serialize($this->user_id);
			
			$this->login_in = true;
		}
		
	}
	
	public function user_id(){
		return unserialize($_SESSION['user_id']);
	}
	
	public function logout(){
		unset($_SESSION['user_id']);
		unset($this->user_id);
		$this->logged_in = false;
	}
	
	private function check_login(){
		if(isset($_SESSION['user_id'])){
			$this->user_id = unserialize($_SESSION['user_id']);

			$this->logged_in = true;
			return true;
		}
			
		else{
			unset($this->user_id);
			$this->logged_in = false;
		}
	}
	
	public function is_logged_in(){
		return $this->logged_in;
	}
	
	public function message($msg="") {
	  if(!empty($msg)) {
	    // then this is "set message"
	    // make sure you understand why $this->message=$msg wouldn't work
	    $_SESSION['message'] = $msg;
	  } else {
	    // then this is "get message"
			return $this->message;
	  }
	}
	
	private function check_message() {
		// Is there a message stored in the session?
		if(isset($_SESSION['message'])) {
			// Add it as an attribute and erase the stored version
      $this->message = $_SESSION['message'];
      unset($_SESSION['message']);
    } else {
      $this->message = "";
    }
	}


}

$session = new session();
$user_id = $session->user_id();
$message = $session->message();
?>