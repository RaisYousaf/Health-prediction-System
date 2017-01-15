<?php
require_once('../includes/initialize.php');

	if(!$session->is_logged_in()) { redirect_to("login.php");}
	  $logfile = SITE_ROOT.DS.'logs'.DS.'log.txt';
  
  if($_GET['clear'] == 'true') {
		file_put_contents($logfile, '');
	  // Add the first new log entry
	  log_action('Logs Cleared', "by User ID {$session->user_id}");
    // redirect to this same page so that the URL won't 
    // have "clear=true" anymore
    redirect_to('logfile.php');
  }
 include_layout_template('header.php'); ?>
<div id="main">
<a href="index.php">&laquo; Back</a><br />
<br />

<h2>Log File</h2>

<p><a href="logfile.php?clear=true">Clear log file</a><p>

<?php

  if( file_exists($logfile) && is_readable($logfile) && 
			$handle = fopen($logfile, 'r')) {  // read
			echo "<ul>";
			while(!feof($handle)){
				$entry = fgets($handle);
				if(trim($entry != "")){
					//continue;
					echo "<li>{$entry}</li>";
					
				}
			}
			echo "</ul>";
    fclose($handle);
  } else {
    echo "Could not read from {$logfile}.";
  }

?>
</div>

<?php include_layout_template('footer.php')?>
