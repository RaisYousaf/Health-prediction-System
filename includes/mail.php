<?php
	require_once(LIB_PATH.DS.'database.php');
	 
	class Mail {
		protected static $table_name = "mails";
		protected static $db_fields = array("id", "sender","receiver","status","created","subject","body","attachment","starred");
		public $id;
		//public $user_id;
		public $created;
		public $subject;
		public $body;
		public $sender;
		public $receiver;
		public $attachment;
		public $status;
		public $starred;
		
		
		/*
		public function make($photo_id, $body, $author){
			if(!empty($photo_id) && !empty($author) && !empty($body)){
				$comment = new Comment();
				$comment->photograph_id = (int)$photo_id;
				$comment->created 		= strftime("%Y-%m-%d %H:%M:%S", time());
				$comment->author		= $author;
				$comment->body 			= $body;
				
				return $comment;
			}
			else
				return false;
			
		}*/
	
		public static function find_mails_on($receiver_id=0){
			$query = "SELECT * FROM ".self::$table_name.
			" WHERE receiver = '{$receiver_id}'".
			"ORDER BY created ASC";
			
			return self::find_by_sql($query);
		}
		
		
		function __construct(){
			$this->created = strftime("%Y-%m-%d %H:%M:%S", time());
			
		}
		public static function send($to, $subject, $body, $attachment, $from){
			
			
		}
		
		public static function find_by_id_for($mail_id=0, $user_id=0){
			if($mail_id != 0){
				global $database;
				$query = "SELECT * FROM ".self::$table_name." WHERE id = '".$database->escape_value($mail_id)."'".
				" AND receiver = '".$database->escape_value($user_id)."'";
				$result_array = self::find_by_sql($query);
				
				return !empty($result_array)?array_shift($result_array) : false;
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
		
		public static function count_all(){
			global $database;
			$query = "SELECT COUNT(*) FROM ".self::$table_name;
			$result = $database->query($query);
			$row = $database->fetch_array($result);
			return array_shift($row);
		}
		
		public static function find_all(){
			$query = "SELECT * FROM ". self::$table_name;
			return $result = self::find_by_sql($query);
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
		
		public function save(){
			return isset($this->id)? $this->update() : $this->create();
		}
		
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