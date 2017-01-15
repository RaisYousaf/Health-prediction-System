<?php
	require_once('../includes/initialize.php');
	

if (isset($_POST['submit'])) { // Form has been submitted.

  $first_name = trim($_POST['first_name']);
  $last_name = trim($_POST['last_name']);
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  $newUser = User::makeNew($first_name,$last_name,$username,$password);
	
  
  
  // Check database to see if username/password exist.
	$found_user = User::authenticate($username);
	//if it returns true; username exist
  if (!$found_user) {
    $newUser->save();
	log_action("Registration ", $username." registered.");
    //redirect_to("index.php");
  } else {
    // username/password combo was not found in the database
    $message = "Username already exist.";
  }
  
} else { // Form has not been submitted.
  $username = "";
  $password = "";
  $message = "";
}
include_layout_template('header.php'); 
?>


		<h2>New User Registration</h2>
		<?php echo output_msg($message); ?>

		<form action="register.php" method="post">
		  <table cellspacing="20px" border=0>
		    <tr>
		      <td>First Name:</td>
		      <td>
		        <input type="text" name="first_name" maxlength="30" value="<?php echo htmlentities($first_name); ?>" />
		      </td>
		      <td>last Name:</td>
		      <td>
		        <input type="text" name="last_name" maxlength="30" value="<?php echo htmlentities($last_name); ?>" />
		      </td>
		    </tr><tr>
		      <td>Username:</td>
		      <td>
		        <input type="text" name="username" maxlength="30" value="<?php echo htmlentities($username); ?>" />
		      </td>
		      <td>Password:</td>
		      <td>
		        <input type="password" name="password" maxlength="30" value="<?php echo htmlentities($password); ?>" />
		      </td>
		    </tr>
		    <tr>
		      <td>
		        
		      </td>
			  <td colspan=2> Already a user? <a href="login.php">Login</a></td>
			  <td>
		        <input type="submit" name="submit" value="register" />
		      </td>
		    </tr>
		  </table>
		</form>
    <?include_layout_template('footer.php'); ?>