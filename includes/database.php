<?php
class Database{
	private $is_connected = false;
	public $connection;
	private static $last_query;
	
	function __construct(){
		if(!$this->is_connected){
			$this->connect();
			$this->magic_quotes_active = get_magic_quotes_gpc();
			$this->real_escape_string_exists = function_exists( "mysql_real_escape_string" );
		}
	}
	
	public function connect(){
		$this->connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS);
		if($this->connection){
			$selected_db = mysqli_select_db($this->connection, DB_NAME);
			if(!$selected_db)
				die('Database selection failed'. mysqli_error($this->connection));
			else
				$this->is_connected = true;
			
		}
		else
			die('Database connection failed: '. mysqli_error($this->connection));
	}
	
	public function disconnect(){
		mysqli_close($this->connection);
		unset($this->connection);
		$this->is_connected = false;
	}
	
	public function query($query){
		$last_query = $query;
		$result = mysqli_query($this->connection, $query);
		$this->confirm_query($result);
		return $result;
	}
	
	private function confirm_query($res){
		if(!$res)
			die('Database query failed: '. mysqli_error($this->connection));
	}
	
	public function fetch_array($result){
		$result =  mysqli_fetch_array($result);
		return $result;
	}
	
	public function num_rows($result){
			$result = mysqli_num_rows($result);
			return $result;
		}
		
	public function affected_rows(){
		$result = mysqli_affected_rows($this->connection);
		return $result;
	}
	
	public function insert_id() {
		// get the last id inserted over the current db connection
		return mysqli_insert_id($this->connection);
	}
	
	public function escape_value( $value ) {
		if( $this->real_escape_string_exists ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $this->magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysqli_real_escape_string( $this->connection, $value );
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if( !$this->magic_quotes_active ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}
	
}

$database = new Database();


?>