<?php
	require_once('../includes/initialize.php');
	


//echo $session->user_id;

 include_layout_template('header.php'); ?>
	<div id="main">
		<div class="form-title-row">
            <h1>Welcome to Smart Health prediction System</h1>
		</div>
		<?phpecho output_msg($message);?>
		<!--<ul>
			<?if ($session->is_logged_in()) {  ?>
			<li><a href="edit_profile.php">Edit Profile</a></li>
			<li><a href="diagnose.php">Diagnose</a></li>
			<li><a href="logout.php">Logout</a></li>
			<?php} else {?>
			<li><a href="login.php">Login</a></li>
			<li><a href="register.php">Register</a></li>
			<?php} ?>
		</ul>
		-->
		
		
	</div>
<?php include_layout_template('footer.php'); ?>
		
