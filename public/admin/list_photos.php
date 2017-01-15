<?php require_once("../../include/initialize.php"); ?>
<?php if (!$session->is_logged_in()) { redirect_to("login.php"); } ?>
<?php
//Pagination parameters
	$per_page = 3;
	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
	$total_count = Photograph::count_all();

  // Find all the photos
  //$photos = Photograph::find_all();
  
  $pagination = new Pagination($per_page, $page, $total_count);
  //find photos using offset and limit
  $query = "SELECT * FROM photographs LIMIT {$per_page}".
	  " OFFSET {$pagination->offset()}";
	  
	  
	$photos = Photograph::find_by_sql($query);
?>
<?php include_layout_template('admin_header.php'); ?>

<h2>Photographs</h2>

<?php echo output_msg($message); ?>
		<ul>
			<li><a href="index.php">Go back</a></li>
		</ul>
		<table border="1"><tr><th>Photo</th><th>Filename</th><th>Caption</th><th>Type</th><th>Size</th><th>Comments</th><th></th></tr>
		<?phpforeach($photos as $photo): ?>
			<tr>
			<td><img src="../<?phpecho $photo->image_path();?>" width="100px"></td>
			<td><?phpecho $photo->filename; ?></td>
			<td><?phpecho $photo->caption; ?></td>
			<td><?phpecho $photo->type; ?></td>
			<td><?phpecho $photo->size_as_text(); ?></td>
			<td><a href="comments.php?id=<?phpecho $photo->id;?>"><?phpecho count($photo->comments());?></a>
			<td><a href="delete_photo.php?id=<?phpecho $photo->id; ?>">Delete</a></td>
			
		<?phpendforeach;?>
		</tr></table>
		<div id="pagination" style="clear:both;">
			<?
				if($pagination->total_pages() > 1){
				if($pagination->has_previous_page()){
						echo "<a href='list_photos.php?page=".$pagination->previous_page()."'> &laquo; Previous</a> ";
					}
					for($i = 1; $i <= $pagination->total_pages(); $i++){
						if($i == $page)
							echo "<span class=\"selected\" >{$i}</span> ";
						else
							echo "<a href=\"list_photos.php?page={$i}\"> {$i}</a> ";
					}

					if($pagination->has_next_page()){
					echo " <a href=\"list_photos.php?page={$pagination->next_page()}\"> Next &raquo;</a>";
					}
				}
				
			?>
		</div>
		<br />
		<a href="photo_upload.php">Upload another Photo</a>
	</div>
<?php include_layout_template('footer.php'); ?>
		
