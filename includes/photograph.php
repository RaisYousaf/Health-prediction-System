<?php
	require_once(LIB_PATH.DS.'database.php');
	class Photograph {
		protected static $table_name = "photographs";
		protected static $db_fields = array("id","filename","type","size","caption");
		public $id;
		public $filename;
		public $type;
		public $size;
		public $caption;
		//public $comments;
		
		private $temp_path;
		protected $upload_dir = "images";
		public $errors = array();
		
		public $upload_error = array(
			UPLOAD_ERR_OK 			=> "No errors.",
			UPLOAD_ERR_INI_SIZE  	=> "Larger than upload_max_filesize.",
			UPLOAD_ERR_FORM_SIZE 	=> "Larger than form MAX_FILE_SIZE.",
			UPLOAD_ERR_PARTIAL 		=> "Partial upload.",
			UPLOAD_ERR_NO_FILE 		=> "No file.",
			UPLOAD_ERR_NO_TMP_DIR 	=> "No temporary directory.",
			UPLOAD_ERR_CANT_WRITE 	=> "Can't write to disk.",
			UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
		);
		
		public function attach_file($file){
			if(!$file || empty($file) || !is_array($file)) {
				// error: nothing uploaded or wrong argument usage
				$this->errors[] = "No file was uploaded.";
				return false;
			} elseif($file['error'] != 0) {
				// error: report what PHP says went wrong
				$this->errors[] = $this->upload_errors[$file['error']];
				return false;
			} else {
				$this->filename 	= basename($file['name']);
				$this->temp_path 	= $file['tmp_name'];
				$this->type 		= $file['type'];
				$this->size 		= $file['size'];
				return true;
			}
		}
		
		public function save(){
			if(isset($this->id)){
				$this->update();
			}
			else{
				if(!empty($errors)){
					return false;
				}
				if(strlen($this->caption) > 255){
					$this->error[] = "The caption can only be 255 characters long.";
					return false;
				}
				if(empty($this->filename) || empty($this->temp_path)){
					$this->error[] = "The file location was not available.";
					return false;
				}
				//Determine target path
				$target_path = SITE_ROOT.DS.'public'.DS.$this->upload_dir.DS.$this->filename;
				if(file_exists($target_path)){
					$this->errors[] = "The file {$this->filename} already exists.";
					return false;
				}
				if(move_uploaded_file($this->temp_path, $target_path))
					if($this->create()){
						unset($this->temp_path);
						return true;
					}
						
				else{
					$this->errors[] = "The file upload failed, i dont know why";
					return false;
				}
			}
		}
		
		public function image_path() {
			return $this->upload_dir."/".$this->filename;
		}
		
		public function size_as_text() {
			if($this->size < 1024) {
				return "{$this->size} bytes";
			} elseif($this->size < 1048576) {
				$size_kb = round($this->size/1024);
				return "{$size_kb} KB";
			} else {
				$size_mb = round($this->size/1048576, 1);
				return "{$size_mb} MB";
			}
		}
		
		public function comments(){
			return Comment::find_comments_on($this->id);
		}
		
		public function destroy(){
			if($this->delete()){
				$target_path = SITE_ROOT.DS.'public'.DS.$this->image_path();
				return unlink($target_path)? true : false;
			}
			else{
				return false;
			}
		}
		
		//common database object methods
		public static function find_by_sql($query){
			global $database;
			$result = $database->query($query);
			$object_array = array();
			//echo $result;
			while($row = $database->fetch_array($result)){
				$object_array[] = self::instantiate($row);
			}
			return $object_array;
		}
	
		public static function find_by_id($id = 0){
			if($id != 0){
				global $database;
				$query = "SELECT * FROM ".self::$table_name." WHERE id = '".$database->escape_value($id)."'";
				$result_array = self::find_by_sql($query);
				
				return !empty($result_array)?array_shift($result_array) : false;
			}
		}
		
		public static function find_all(){
			$query = "SELECT * FROM ". self::$table_name;
			return $result = self::find_by_sql($query);
		}
		
		public static function count_all(){
			global $database;
			$query = "SELECT COUNT(*) FROM ".self::$table_name;
			$result = $database->query($query);
			$row = $database->fetch_array($result);
			return array_shift($row);
		}
		
		protected function attributes(){
			//return an array of attribute names and their values
			$attributes = array();
			foreach(self::$db_fields as $field){
				if(property_exists($this, $field))
					$attributes[$field] = $this->$field;
			}
			
			return $attributes;
		}
		
		protected function sanitized_attributes(){
			global $database;
			$attributes = $this->attributes();
			$clean_attributes = array();
			
			foreach($attributes as $key => $value){
				$clean_attributes[$key] = $database->escape_value($value);
				
			}
			return $clean_attributes;
		}
			
		public function create(){
			//escaping all value to prevent sql injection
			global $database;
			$attributes = $this->sanitized_attributes();
			$query = "INSERT INTO ".self::$table_name." (";
			$query .=join(",",array_keys($attributes));
			
			$query .= ") VALUES('";
			$query .=join("','",array_values($attributes));
			$query .="')";
			if($database->query($query)){
				$database->insert_id();
				return true;
			}
			else
				return false;
		}
		
		public function update(){
			//escaping all value to prevent sql injection
			global $database;
			$attributes = $this->sanitized_attributes();
			$attribute_pairs = array();
			foreach($attributes as $key => $value){
				$attribute_pairs[] = "{$key} = '{$value}'";
			}
			$query = "UPDATE ".self::$table_name." SET ";
			$query .= join(",",$attribute_pairs);
			//$query .= "'";
			$query .= " WHERE id = '".$database->escape_value($this->id)."'";
			$database->query($query);
			return ($database->affected_rows() == 1) ? true : false;
		}	
		
		//public function save(){
		//	return isset($this->id)? $this->update() : $this->create();
		//}
		
		public function delete(){
			global $database;
			$query = "DELETE FROM ".self::$table_name;
			$query .= " WHERE id = '".$database->escape_value($this->id)."' LIMIT 1";
			$database->query($query);
			return ($database->affected_rows() == 1) ? true : false;
		}
				
		private static function instantiate($record) {
			$object = new self;
			
			// More dynamic, short-form approach:
			foreach($record as $attribute=>$value){
			  if($object->has_attribute($attribute)) {
				$object->$attribute = $value;
			  }
			}
			return $object;
		}
	
		private function has_attribute($attribute) {
		  // get_object_vars returns an associative array with all attributes 
		  // (incl. private ones!) as the keys and their current values as the value
		  $object_vars = get_object_vars($this);
		  // We don't care about the value, we just want to know if the key exists
		  // Will return true or false
		  return array_key_exists($attribute, $object_vars);
		}
		
	}
	
	
?>