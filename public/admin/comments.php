<?php
require_once('../../include/initialize.php');


?>
<?php
  
	if(isset($_GET['id'])){
		$photo = Photograph::find_by_id($_GET['id']);
		
	}
	else{
		$session->message("No photo was selected.");
		redirect_to('index.php');
	}
	
	/*if(isset($_POST['submit'])){
		$author = trim($_POST['author']);
		$body = trim($_POST['body']);
		
		$new_comment = Comment::make($photo->id, $body, $author);
		if($new_comment && $new_comment->save()){
			redirect_to("photo.php?id={$photo->id}");
		}
		else{
			$message = "unable to save comment.";
		}
	}
	else{
		$author = "";
		$body = "";
	}*/
	
	$comments = $photo->comments();
	
		
  
  
?>
<?php include_layout_template('admin_header.php');  ?>
		
		<a href="list_photos.php"?>&laquo; Back</a><p />
			<?php echo "<h3>Comments on {$photo->filename} </h3>";?>
			<?php echo output_msg($message); $message=""?>
			<?php foreach($comments as $comment):?>
				<div class="comment" style="margin-bottom:2em;">
					<div class="author">
						<strong><?php echo htmlentities($comment->author); ?></strong> wrote:
					</div>
					<div class="body">
						<?php echo strip_tags($comment->body,'<strong><em><p>'); ?>
					</div>
					<div class="created">
						<?php echo datetime_to_text($comment->created); ?>
					</div>
					<div>
						<a href="delete_comment.php?id=<?phpecho $comment->id; ?>">Delete</a>
					</div>
				</div>
			<?php endforeach; ?>
			<?php echo empty($comments) ?  "No Comments, yet." : null; ?> 
			
			
			<?php echo output_msg($message);?>
			<form action="comments.php?id=<?phpecho $photo->id; ?>" method="post">
			<table>
				<tr><td>Admin Comment: </td>
					<td><textarea name="body" cols="50" rows="10"><?php echo $body; ?></textarea></td></tr>
				<tr><td>&nbsp;</td><td><input type="submit" name="submit" value="Submit Comment"></td></tr>	
			</table>
					
			</div> 
		
		
		
<?php include_layout_template('footer.php'); ?>