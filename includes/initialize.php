<?php

	defined('DS')? null : define("DS",DIRECTORY_SEPARATOR);
	defined('SITE_ROOT')? null : define("SITE_ROOT",DS.'xampp'.DS.'htdocs'.DS.'smart_health');
	defined('LIB_PATH')? null : define("LIB_PATH",SITE_ROOT.DS.'includes'.DS);
	
	require_once(LIB_PATH.DS.'config.php');
	require_once(LIB_PATH.'functions.php');
	require_once(LIB_PATH.'database.php');
	require_once(LIB_PATH.'session.php');
	require_once(LIB_PATH.'pagination.php');
	
	require_once(LIB_PATH.'user.php');
	require_once(LIB_PATH.'illness.php');
	require_once(LIB_PATH.'symptom.php');
	require_once(LIB_PATH.'illness_symptom.php');
	require_once(LIB_PATH.'diagnosis.php');
	require_once(LIB_PATH.'notification.php');
	

?>