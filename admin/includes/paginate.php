<?php 
/*****************************************************************************************************
Paginate class is a class that stores page information inside propertis for the purpose of displaying
predifiened amount of photos per page
*****************************************************************************************************/


class Paginate {

	public $current_page;
	public $items_per_page;
	public $items_total_count;

	//this cunstructor sets recieved data as an objects properties
	public function __construct ($page = 1, $items_per_page = 4, $items_total_count = 0) {

		$this->current_page = (int)$page;
		$this->items_per_page = (int)$items_per_page;
		$this->items_total_count = (int)$items_total_count;

	}

	//this method returns next page
	public function next() {

		return $this->current_page + 1;

	}

	//this method returns previous page
	public function previous() {

		return $this->current_page - 1;

	}

	//this method takes $items_total_count and devides by $items_per_page
	public function page_total() {

		return ceil($this->items_total_count / $this->items_per_page);

	}

	//this method checks if we have previous page
	public function has_previous() {

		return $this->previous() >= 1 ? true : false;

	}

	//this method checks if we have next page
	public function has_next() {

		return $this->next() <= $this->page_total() ? true : false;

	}

	//this method returns offset
	public function offset() {

		return ($this->current_page - 1) * $this->items_per_page;

	}

}







 ?>