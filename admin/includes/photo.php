<?php
/********************************************************************************************************
The Photo class is a child class of Db_object that iherits all it's methods and properties but also has a 
photo specific methods that are resposible for storing and deleting photos in our database inside photo 
table, checks for errors when moving images from temp folder to images folder, stores images specific 
properties and responsible for dynamic image path.
********************************************************************************************************/



class Photo extends Db_object {

	protected static $db_table = "photos";//table name
	protected static $db_table_fields = array('id', 'title', 'caption', 'description', 'filename', 'alternate_text', 'type', 'size', 'photo_date', 'photo_username');//table field names
	public $id;
	public $title;
	public $caption;
	public $description;
	public $filename;
	public $alternate_text;
	public $type;
	public $size;
	public $photo_date;
	public $photo_username = "";

	public $tmp_path;//temperary path where php keeps images
	public $upload_directory = "images";//our images folder

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
			$this->filename = basename($file['name']);//returns the filename from a path
			$this->tmp_path = $file['tmp_name'];
			$this->type = $file['type'];
			$this->size = $file['size'];
			$this->photo_date = date("F j, Y, g:i a");

		}

	}

	//this is dynamic image path method
	public function picture_path() {
		return $this->upload_directory . DS . $this->filename;

	}

	//this method saves photo file info
	public function save() {

		//if photo id exists then just update
		if ($this->id) {

			$this->update();

		} else {//checks for errors

			if (!empty($this->errors)) {

				return false;

			}

			if (empty($this->filename) || empty($this->tmp_path)) {

				$this->errors[] = "the file was not available";

				return false;

			}

			//setting target path where images will be stored
			$target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->filename;

			//checks if file was already uploaded
			if (file_exists($target_path)) {

				$this->errors[] = "the file {$this->filename} already exists";

				return false;

			}

			//this build-in function in php that moves file from $tmp_path to $target_path
			if (move_uploaded_file($this->tmp_path, $target_path)) {

				if ($this->create()) {

					unset($this->tmp_path);//clean temp path after moving

					return true;

				}

			} else {//if can not move display error

				$this->errors[] = "check file directory permission";

				return false;

			}

		}

	}

	//this method deletes images from database and from images folder
	public function delete_photo() {

		if ($this->delete()) {

			$target_path = SITE_ROOT . DS . 'admin' . DS . $this->picture_path();

			return unlink($target_path) ? true : false;//unlink will physacaly delete file

		} else {

			return false;

		}

	}

	//this method takes data from server and will be used to send it to ajax for displaying photo info
	public static function display_sidebar_data($photo_id) {

		$photo = Photo::find_by_id($photo_id);

		$output = "<a class='thumbnail' href='#'><img width='100' src='{$photo->picture_path()}' ></a> ";
		$output .= "<p>{$photo->filename}</p>";
		$output .= "<p>{$photo->type}</p>";
		$output .= "<p>{$photo->size}</p>";

		echo $output; 

	}

}


?>