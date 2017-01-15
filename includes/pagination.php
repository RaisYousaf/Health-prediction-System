<?php
	class Pagination {
		public $per_page;
		public $total_count;
		public $current_page;
		
		function __construct($per_page = 20, $current_page = 1, $total_count = 0){
			$this->per_page 	= (int)$per_page;
			$this->total_count 	= (int)$total_count;
			$this->current_page = (int)$current_page;
		}
		
	public function offset(){
		$offset = ($this->current_page - 1)* $this->per_page;
		//if($offset-1 > $this->total_pages())
			//$offset = $this->total_pages() - 1;
		return $offset;
	}
		
		public function total_pages(){
			return ceil($this->total_count/$this->per_page);
		}
		
		public function next_page(){
			return $this->current_page + 1;
		}
		
		public function previous_page(){
			return $this->current_page - 1;
		}
		
		public function has_next_page(){
			return $this->next_page() <= $this->total_pages()? true : false;
		}
		
		public function has_previous_page(){
			return $this->previous_page() >= 1 ? true : false;
		}
	}
?>