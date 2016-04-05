<?php
/***********************************************************************************************************************
Database class is responsible to establishing connection to our database and displaying error message if it fails, 
manipulation with sql queryies and diplaying error message, also will prevent sql injection by adding escape character.
***********************************************************************************************************************/

//including file that has constants needed for database class
require_once("new_config.php");


class Database {

	public $connection;

	//constuctor method for database connection (create connection as soon as database object is created)
	function __construct() {

		$this->open_db_connection();

	}

	//method to enable connection to database
	public function open_db_connection () {

		$this->connection = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

		if ($this->connection->connect_errno) {
			die("Database connection failed" . $this->connection->connect_errno);
		}

	}

	//method that will recieve sql query and sends it to mysql database
	public function query($sql) {

		$result = $this->connection->query($sql);

		$this -> confirm_query($result);

		return $result;

	}

	//method that will display error if query failed to work
	private function confirm_query($result) {

		if (!$result) {
			die("DB query failed" . $this->connection->error);
		}

	}

	//this method adds an escape character, the backslash, to prevent SQL injection attacks
	public function escape_string($string) {

		$escaped_string = $this->connection->real_escape_string($string);

		return $escaped_string;

	}

	//this method returns last id of the user when it was created
	public function the_insert_id() {

		return mysqli_insert_id($this->connection);

	}

}

//creating database object
$database = new Database();


?>