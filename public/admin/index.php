<?php
	require_once('../../includes/initialize.php');
	


//echo $session->user_id;

 include_layout_template('admin_header.php'); ?>
	<div id="con">
		<h2>Welcome to Smart Health prediction System</h2>
		<?phpecho output_msg($message);?>
		
		
		
	</div>
<?php include_layout_template('admin_footer.php'); ?>
		
