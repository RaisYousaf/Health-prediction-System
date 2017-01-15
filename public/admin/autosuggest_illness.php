<?php
//header('content-type: application/json');
	$result_array = array();
	$conn =  mysqli_connect("localhost","root","","smart_health_predictor");
	$query = "SELECT * FROM illness where name LIKE '%" .$_GET['word']."%'";
	$result = mysqli_query($conn, $query);
	while($row = mysqli_fetch_array($result)){
		$new_array = array("symptom" => $row['name'],"s_id" => $row['s_id']);
		array_push($result_array,$new_array);
	}
	
	
	if(empty($result_array))
		$array = false;
	$array = $result_array;
	
	//$array  = array('microsoft','micromax', 'miniclip','michael jackson','million','milky way');
	//$input  = urldecode($_GET['word']); //Get input word/phrase (decode in case of spaces etc.)
	//$length = strlen($input);           //Get length of input word
	// $min    = $length - 1;              //Length of word - 1
	// $max    = $length + 1;              //Length of word + 1

	//$returned = preg_grep('/^(['.$input.']{'.$length.'}.*)$/i', $array); //Find matches in $array and return as array
	//$returned = array_values($returned);                                //Re-index from 0

	echo json_encode($array); //Returm json string to ajax call

?>