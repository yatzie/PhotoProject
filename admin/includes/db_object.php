<?php
/********************************************************************************************************
Db_object class is a parent class that will have methods used by other child classes like user as example
and we replace self with static in order to access static methods through parent class
********************************************************************************************************/


class Db_object {

	protected static $db_table = "users";
	public $errors = array();//array that will hold our custom errors
	public $upload_errors_array = array( //array that holds php build-in error messages for file manipulations

		UPLOAD_ERR_OK        	=> "There is no error",
		UPLOAD_ERR_INI_SIZE		=> "The uploaded file exceeds the upload_max_filesize directive in php.ini.",
		UPLOAD_ERR_FORM_SIZE	=> "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.",
		UPLOAD_ERR_PARTIAL		=> "The uploaded file was only partially uploaded.",
		UPLOAD_ERR_NO_FILE		=> "No file was uploaded.",
		UPLOAD_ERR_NO_TMP_DIR	=> "Missing a temporary folder. Introduced in PHP 5.0.3.",
		UPLOAD_ERR_CANT_WRITE	=> "Failed to write file to disk. Introduced in PHP 5.1.0.",
		UPLOAD_ERR_EXTENSION	=> "A PHP extension stopped the file upload."

	);

	//This method is passing $_FILES['uploaded_file'] as an argument
	public function set_file($file) {

		//checks if file was uploaded
		if (empty($file) || !$file || !is_array($file)) {

			$this->errors[] = "There was no file uploaded here";

			return false;

		} elseif ($file['error'] !=0) {

			$this->errors[] = $this->upload_errors_array[$file['error']];//assigning php build-in errors to our custom error variable

			return false;

		} else {

			//submiting our data to an object's properties
			$this->user_image = basename($file['name']);//returns the user_image from a path
			$this->tmp_path = $file['tmp_name'];
			$this->type = $file['type'];
			$this->size = $file['size'];
			$this->photo_date = date("F j, Y, g:i a");

		}

	}

	//this method will select and return all info from $db_table database
	public static function find_all() {

		return static::find_by_query("SELECT * FROM " . static::$db_table . " ");

	}

	//this method will search by id and returns it if it exists
	public static function find_by_id($id) {

		global $database;

		$the_result_array = static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE id = $id LIMIT 1");

		return !empty($the_result_array) ? array_shift($the_result_array) : false;//if found grab first item of that array otherwise return false

	}

	//this method recieves any query method and executes it and returns array that contains objects with assign properties
	public static function find_by_query($sql) {

		global $database;

		$result_set = $database->query($sql);
		$the_object_array = array();//initialising empty array

		while($row = mysqli_fetch_array($result_set)) { //gets data from database and assigns to variable $row

			$the_object_array[] = static::instantiation($row);

		}

		return $the_object_array;

	}

	//this method instantiate the object and assigns recieved data to object's properties and returns it after checking if recieved properties from 
	//database matches object properties in a method below
	public static function instantiation ($the_record) {

		$calling_class = get_called_class();//to instatiate child class

		$the_object = new $calling_class;

		foreach ($the_record as $the_attribute => $value) {
			
			if ($the_object->has_the_attribute($the_attribute)) { //checks if object attributes matches recieved atributes by calling method below

				$the_object->$the_attribute = $value;

			}

		}

        return $the_object;

	}

	//this method checks if object's attributes matches recieved atributes and returns it
	private function has_the_attribute($the_attribute) {

		$object_properties = get_object_vars($this); //gets all object attributes from child class

		return array_key_exists($the_attribute, $object_properties); //returns if matching attributes exists

	}

	//every time this method is called it will get all object's properties
	protected function properties() {

		$properties = array();

		foreach (static::$db_table_fields as  $db_field) {//only use property that inside array $db_table_fields

			if(property_exists($this, $db_field)) {

				$properties[$db_field] = $this->$db_field;

			}
			
		}

		return $properties;

	}

	//this method will use escape_string method to clean properties for abstracted methods such as create()
	// and update() through properties method
	protected function clean_properties() {

		global $database;

		$clean_properties = array();

		foreach ($this->properties() as $key => $value) {
			
			$clean_properties[$key] = $database->escape_string($value);

		}

		return $clean_properties;

	}

	//this method checks if data exists then it will call update method, if not exist then create method
	public function save() {

		return isset($this->id) ? $this->update() : $this->create();

	}

	//this method creates new data in database through insert query
	public function create() {

		global $database;

		$properties = $this->clean_properties();//array that holds objects properies

		$sql = "INSERT INTO " . static::$db_table . "(" . implode(",", array_keys($properties)) . ")";//separating array keys with comma
		$sql .= "VALUES ('" . implode("','", array_values($properties)) . "')";

		if ($database->query($sql)) {

			$this->id = $database->the_insert_id();

			return true;

		} else {

			return false;

		}

	}

	//this method updates existing data in database through update query
	public function update() {

		global $database;

		$properties = $this->clean_properties();//array that holds objects properies

		$properties_pairs = array();

		//to make key values with '=' operator exml: username=
		foreach ($properties as $key => $value) {
			
			$properties_pairs[] = "{$key}='{$value}'";

		}

		$sql = "UPDATE " . static::$db_table . " SET ";
		$sql .= implode(", ", $properties_pairs);
		$sql .= " WHERE id= " . $database->escape_string($this->id);

		$database->query($sql);

		return (mysqli_affected_rows($database->connection) == 1) ? true : false;//if data exists return true othervise false

	}

	//this method deletes existing data in database through delete query
	public function delete() {

		global $database;

		$sql = "DELETE FROM " . static::$db_table . " ";
		$sql .= "WHERE id= " . $database->escape_string($this->id);
		$sql .= " LIMIT 1";

		$database->query($sql);

		return (mysqli_affected_rows($database->connection) == 1) ? true : false;

	}

	//this methode will count all pictures, users and comments stored in database
	public static function count_all() {

		global $database;

		$sql = "SELECT COUNT(*) FROM " . static::$db_table;
		$result_set = $database->query($sql);
		$row = mysqli_fetch_array($result_set);

		return array_shift($row);

	}

}


?>