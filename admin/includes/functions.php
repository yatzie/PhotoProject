<?php


//this function will check if all class files are in init.php Underclared object backup function
function classAutoLoader($class) {

	$class = strtolower($class);
	$the_path = INCLUDES_PATH . DS . "/{$class}.php";

	if (file_exists($the_path) && !class_exists($class)){

		require_once($the_path);

	} else {

		die("This file name {$class}.php was not found");

	}

}

spl_autoload_register('classAutoLoader');//build in php function to autoload 

//this method redirect user if not admin
function redirect($location) {

	header("Location: {$location}");

}


?>