<?php
/******************************************************************************************
Session class is responsible is responsible for loging and loging out the user, validating, 
controlling admin access and keeping track of views.
******************************************************************************************/



class Session {

	private $signed_in = false;//property that acts like a boolean (true or false)
	public $user_id;
	public $message;
	public $count;//used to store visitor counts
	public $loged_in_user = "";

	//constructor, every time class instatiated it will start the session and calls check_the_login method
	function __construct() {

		session_start();
		$this->visitor_count();
		$this->check_the_login();
		$this->check_message();

	}

	//this method checks to make sure message is set
	private function check_message() {

		if(isset($_SESSION['message'])) {

			$this->message = $_SESSION['message'];
			unset($_SESSION['message']);

		} else {

			$this->message = "";

		}

	}

	//this method output messages for the user
	public function message($msg="") {

		if(!empty($msg)) {

			$_SESSION['message'] = $msg;

		} else {

			return $this->message;

		}

	}

	//this methode will count and display visitors by using session variables
	public function visitor_count() {

		if(isset($_SESSION['count'])) {

			return $this->count = $_SESSION['count']++;

		} else {

			return $_SESSION['count'] = 1;

		}

	}

	//method checks if user exists then it applyes recieved data to Session's class property
	public function check_the_login() {

		if(isset($_SESSION['user_id'])) {

			$this->user_id = $_SESSION['user_id'];
			$this->loged_in_user = $_SESSION['username'];
			$this->signed_in = true;

		} else {

			unset($this->user_id);//if not found destroyes variable
			unset($this->loged_in_user);
			$this->signed_in = false;

		}

	}

	//getter method that gets private value from Session class to be used to check if user loged in or not
	public function is_signed_in() {

		return $this->signed_in;

	}

	//this method gets data from database and if it's exists it will assign user id to both User class and Session class
	public function log_in($user) {

		if($user) {

			$this->user_id = $_SESSION['user_id'] = $user->id;
			$this->loged_in_user = $_SESSION['username'] = $user->username;
			$this->signed_in = true;

		}

	}

	//this method log user out by destroying variables
	public function log_out() {

		unset($_SESSION['user_id']);
		unset($this->user_id);
		unset($_SESSION['username']);
		unset($this->loged_in_user);
		$this->signed_in = false;

	}

}

$session = new Session();
$message = $session->message();



?>