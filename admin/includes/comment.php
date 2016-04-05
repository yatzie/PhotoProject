<?php
/*****************************************************************************************************
Comment class is a child class of Db_object class that stores user's comments inside propertis for
displaying all comments or specific comments for that picture and use CRUD methods from parent class
*****************************************************************************************************/


class Comment extends Db_object {

	protected static $db_table = "comments";//table name
	protected static $db_table_fields = array('id', 'photo_id', 'author', 'body', 'comment_date');//table field names
	public $id;
	public $photo_id;
	public $author;
	public $body;
	public $comment_date;

	//this method will self instatiate
	public static function create_comment($photo_id, $author="John", $body="", $comment_date="") {

		if(!empty($photo_id) && !empty($author) && !empty($body)) {

			$comment = new Comment();

			$comment->photo_id = (int)$photo_id;
			$comment->author = $author;
			$comment->body = $body;
			$comment->comment_date = $comment_date = date("F j, Y, g:i a");

			return $comment;

		} else {

			return false;

		}

	}

	//this method will find a comment by photo id
	public static function find_the_comments($photo_id=0) {

		global $database;

		$sql = "SELECT * FROM " . self::$db_table;
		$sql.= " WHERE photo_id = " . $database->escape_string($photo_id);
		$sql.= " ORDER BY photo_id ASC";

		return self::find_by_query($sql);

	}

}


?>