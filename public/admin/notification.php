<?php require_once("../../includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) { redirect_to("login.php"); }
 
	 $notifications = Notification::find_all_new();
	

	?>
<?php include_layout_template('admin_header.php'); ?>
<div id="con">
          

<div class="form-mini-container">
    <form class="form-validation" method="post" action="add_illness.php">
		<div class="form-title-row">
            <h1>Notifications</h1>
		</div>

<?php echo output_msg($message); ?>
 

		<ul>
			<li><a href="index.php">Go back</a></li>
		</ul> 
		<?php if($notifications ==null){
				echo "No new Notification";
	
			}else{
				$counter = 0;
				?>
				<center>
			<table cellspacing="5" cellpadding="5" >
			  <thead>
				<tr>
			  <td>
				  <label>
					  S/N
					  
				  </label>
			  </td>
			  <td>
				  <label>
					  User/Patient
					  
				  </label>
			  </td>
			  <td>
				  <label>
					  Illness
					  
				  </label>
				  
			  </td>
			  <td>
					<label>
					  Symptoms
					  
				  </label>
				</td>
				<td>
					<label>
					  Date
					  
				  </label>
				</td>
				<td>
					<label>
					  Action
					  
				  </label>
				</td>
				
			</tr>
			  </thead>
			<tbody>
			<?php foreach($notifications as $notification){ ?>
				<tr>
				<td>
				  <label>
					  <?php echo ++$counter ;?>
					  
				  </label>
			  </td>
			  <td>
				  <label>
					  <?php $user = User::find_by_id($notification->notifier);
						echo $user->username;
						
					?>
					  
				  </label>
			  </td>
			  <?php 
						$query = "SELECT * FROM diagnosis WHERE user_id ='".$notification->notifier."' AND date_diagnosed = '".$notification->date_created."' LIMIT 1";
						$diagnosis = Diagnosis::find_by_sql($query);
						foreach($diagnosis as $d){
						
						?>
			  <td>
				  <label>
					  <?php 
						//$query = "SELECT * FROM illness WHERE "
						$illness = Illness::find_by_id($d->illness_id);
						echo $illness->name;
						
					?>
					  
				  </label>
				  
			  </td>
			  <td>
					<label>
					  
						<?php
						echo "<ul>";
						
				//if($date != $date) echo "</tr><tr>"; 
				//$date = $notification->date_created;
			
						
							$symptom_ids = explode(",", $d->symptom_id);
							foreach($symptom_ids as $symptom_id){
							$symptom = Symptom::find_by_id($symptom_id);
							echo "<li>".$symptom->name;
							
							}
						}
						echo "</ul>";
					?>
					  
				  </label>
				</td>
				<td>
				  <label>
					  <?php echo datetime_to_text($notification->date_created); ?>
						
						
					  
				  </label>
				  
			  </td>
				<td>
				  <label>
					  <a href="viewed.php?id='<?php echo $notification->id; ?>'">Clear</a>
						
						
					  
				  </label>
				  
			  </td>
				
			</tr>
			<?php } ?>
			  </tbody>
			</table>
			<?php } ?>
		</div>

<?php include_layout_template('admin_footer.php'); ?>
