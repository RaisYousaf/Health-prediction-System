<?php
	require_once('../../include/initialize.php');
	
	
	
	if (!$session->is_logged_in()) { redirect_to("login.php"); }
	$max_file_size = 1000000;
	
	if(isset($_POST['submit'])){
		$photo = new Photograph();
		$photo->caption = $_POST['caption'];
		$photo->attach_file($_FILES['file-upload']);
		if($photo->save()){
			$session->message("Photograph uploaded successfully.");
			redirect_to('list_photos.php');
		}
		else
			$message = join("<br />", $photo->errors);
	}
 
 
 ?>		
 <?php include_layout_template('admin_header.php');  ?>
		
		<form action="photo_upload.php" method="post"enctype="multipart/form-data">
			<h2> Add illiness</h2>
			<?phpecho $message; ?>
			<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size;?>" />
			<input type="file" name="file-upload" /><br />
			Caption: <input type="text" name="caption" /><br />
			<input type="submit" value="upload" name="submit" />
		</form>
	</div>
<?php include_layout_template('footer.php'); ?>
		
