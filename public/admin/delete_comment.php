<?php require_once('../../include/initialize.php');
	if (!$session->is_logged_in()) { redirect_to("login.php"); }
	
	if(isset($_GET['id'])){
		$comment = comment::find_by_id($_GET['id']);
		if($comment->delete()){
			$session->message("The comment was deleted!");
			redirect_to('comments.php?id='.$comment->photograph_id);
		}
		else{
			$session->message("unable to delete comment.");
			redirect_to("comments.php?id={$comment->photograph_id}");
		}
	}
	else{
		$session->message("No comment was selected");
		redirect_to('index.php');
	}
	