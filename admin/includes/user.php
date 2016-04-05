<?php
/*****************************************************************************************************
User class is a child class of Db_object class that stores user information inside propertis for CRUD
manipulations
*****************************************************************************************************/


class User extends Db_object {

	protected static $db_table = "users";//table name
	protected static $db_table_fields = array('username', 'password', 'first_name', 'last_name', 'user_image');//table field names
	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;
	public $user_image;
	public $upload_directory = "images";//directory that will hold user's pictures
	public $image_placeholder = "http://placehold.it/400x400&text=image";//will hold a place holder image if user doesn't provide one



	//this method saves user's data and user's image
	public function upload_photo() {

		if (!empty($this->errors)) {

			return false;

		}

		if (empty($this->user_image) || empty($this->tmp_path)) {

			$this->errors[] = "the file was not available";

			return false;

		}

		//setting target path where images will be stored
		$target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;

		//checks if file was already uploaded
		if (file_exists($target_path)) {

			$this->errors[] = "the file {$this->user_image} already exists";

			return false;

		}

		//this build-in function in php that moves file from $tmp_path to $target_path
		if (move_uploaded_file($this->tmp_path, $target_path)) {

				unset($this->tmp_path);//clean temp path after moving

				return true;

		} else {//if can not move display error

			$this->errors[] = "check file directory permission";

			return false;

		}

	}

	//this method recives user username and password to match info stored in database and returns true or false
	public static function verify_user($username, $password) {

		global $database;

		$username = $database->escape_string($username);
		$password = $database->escape_string($password);

		$sql = "SELECT * FROM " . self::$db_table . " WHERE ";
		$sql .= "username = '{$username}' ";
		$sql .= "AND password = '{$password}' ";
		$sql .= "LIMIT 1";

		$the_result_array = self::find_by_query($sql);

		return !empty($the_result_array) ? array_shift($the_result_array) : false;

	}

	//This method will display an image and if it doesn't exists will display image stored in $image_placeholder variable
	public function image_path_and_placeholder() {
		return empty($this->user_image) ? $this->image_placeholder : $this->upload_directory . DS . $this->user_image;

	}

	//this method deletes images from database and from images folder
	public function delete_photo() {

		if ($this->delete()) {

			$target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;

			return unlink($target_path) ? true : false;//unlink will physacaly delete file

		} else {

			return false;

		}

	}

	//this method gets user_image and user_id from ajax and saves it
	public function ajax_save_user_image($user_image, $user_id) {

		global $database;

		$user_image = $database->escape_string($user_image);
		$user_id = $database->escape_string($user_id);

		$this->user_image = $user_image;
		$this->id = $user_id;

		$sql = "UPDATE " . self::$db_table . " SET user_image = '{$this->user_image}' ";
		$sql .= " WHERE id = {$this->id} ";

		$update_image = $database->query($sql);

		echo $this->image_path_and_placeholder();

	}



}


?>