<?php

	function redirect_to($page=null){
		if($page != null)
			header("Location: {$page}");
		exit();
	}

	function output_msg($message = ""){
		if(!empty($message))
			return "<p class\"message\">{$message}</p>";
		else
			return "";
	}
	
	function include_layout_template($template=""){
		include(SITE_ROOT.DS.'public'.DS.'layouts'.DS.$template);
	}
	
	/*function __autoload($class_name){
		$class_name = strtolower($class_name);
		$path = "../include/{$class_name}.php";
		if (file_exists($path))
			require_once($path);
		else
			die("The file {$class_name}.php could not be found.");
				
		
	}*/

	function log_action($action, $message=""){
		$file = SITE_ROOT.DS.'logs'.DS.'log.txt';
		$handle = fopen($file, a);
		if($handle){
			$timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
			$content = $timestamp." | ".$action.": ".$message."\n";
			fwrite($handle, $content);
		}
		fclose($handle);
	}

	function datetime_to_text($datetime=""){
		$datetime = strtotime($datetime);
		return strftime("%B %d, %Y at %I:%M %p", $datetime);
	}
	
	
?>