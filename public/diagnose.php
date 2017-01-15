<?php require_once("../includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) { redirect_to("login.php"); }

$user_id = $session->user_id;
 include_layout_template('header.php'); ?>

<div id="con">
          

<div class="form-mini-container">
    <form class="form-validation" method="post" action="diagnose.php">
		<div class="form-title-row">
            <h1>Patient Diagnosis</h1>
		</div>


<?php echo output_msg($message); ?>
	
		
			<a href="index.php">Go back</a>
		<center>
<?php

if(isset($_POST['diagnose'])){
	
	
	if(isset($_POST['selected'])){
		$key = $_POST['selected'];
		
	$selected = array();
	foreach($key as $k){
		if(empty($k)) continue;
		array_push($selected, $k);
	}
	
	
	//var_dump($selected);
	
		$symptoms_illness = array();
		foreach($selected as $sel){
			//$query = "SELECT * FROM illness_symptoms INNER JOIN illness USING(illness_id) WHERE s_id = $sel ORDER BY illness_id ASC";
			//$result = mysqli_query(mysqli_connect("localhost","root","","smart_health_prediction"), $query);
			//while($row = mysqli_fetch_array($result))
				//echo $row['name']."*".$row['illness_id']."<br>";
			$data = Illness_Symptom::find_all_by_id($sel);
			//var_dump($data);
			foreach($data as $d)
				array_push($symptoms_illness, $d);
		} //var_dump($symptoms_illness);
		$chances = $illness = array(0,0,0,0,0,0,0,0,0,0,0);
		$current = 0; $k = 0;
		
		sort($symptoms_illness);
		
		foreach($symptoms_illness as $s_i){ //echo $s_i->s_id;
			if($s_i->illness_id == $current){
				//echo "i_id == current ";
				$chances[$k]= ++$chances[$k];
				$illness[$k] = $s_i->illness_id;
				
			}
			else{
				$current = $s_i->illness_id;
				$k++;
				$chances[$k]= ++$chances[$k];
				$illness[$k] = $s_i->illness_id;
			}
			
			//echo $s_i->illness_id;

		}
		
		for($c=1; $c < count($chances); $c++){
			if($chances[$c] == 0) break;
			
		}
		
		echo "<br>With the symptoms you have choosen, Our system predicts you're having <br>";
		
		$accurate = $illness[array_search(max($chances),$chances)];
		//echo "$accurate<br />";
		$query = "SELECT * FROM illness WHERE illness_id = $accurate";
		$illness = Illness::find_by_id($accurate);
		
		
			$illness_id = $illness->illness_id;
			echo "<span class='error' id='emphasis'>".$illness->name ."</span><br />";

			
		


		
		//save into diagnosis table
		
		
		$diagnosis = new Diagnosis();
			
		
		$diagnosis->user_id = $user_id;
			$diagnosis->illness_id = $illness_id;
			
			$symptom_ids = "";
			$symptom_ids .= join(",", $selected);
			$diagnosis->symptom_id = $symptom_ids;
				
			//	$diagnosis->save();
		
		
		
		//make notification
		// $notification = new Notification();
		// $notification->notifee = 1;
		// $notification->notifier = $user_id;
		// $notification->save();

			//redirect to a page to perform questioning

		
		
		
	}else{
		$session->message('You haven\'t chosen any symptom');
		redirect_to("diagnose.php");
	}


}
else{

  // Find all the symptoms
  //$symptoms = Symptom::find_all();

		
		// Display the symptoms form field in a table
	  $no = 0;
	  $sid = 0;
	  echo "Select the symptoms that you have<br>";
	  echo '<div id="wrapper"><table id="filer">';
		?>
			<tr><td><div ><input type="text"  class="suggest" onkeyup="suggest(this)"><input type="hidden" name="selected[]" ></div></td>
			<td><div ><input type="text"  class="suggest"  onkeyup="suggest(this)"><input type="hidden" name="selected[]" ></div></td>
			<td><div ><input type="text"  class="suggest"  onkeyup="suggest(this)"><input type="hidden" name="selected[]" ></div></td></tr>
			<tr><td><div ><input type="text"  class="suggest" onkeyup="suggest(this)"><input type="hidden" name="selected[]" ></div></td>
			<td><div ><input type="text"  class="suggest"  onkeyup="suggest(this)"><input type="hidden" name="selected[]" ></div></td>
			<td><div ><input type="text"  class="suggest"  onkeyup="suggest(this)"><input type="hidden" name="selected[]" ></div></td></tr>
			<tr><td><div ><input type="text"  class="suggest" onkeyup="suggest(this)"><input type="hidden" name="selected[]" ></div></td>
			<td><div ><input type="text"  class="suggest"  onkeyup="suggest(this)"><input type="hidden" name="selected[]" ></div></td>
			<td><div ><input type="text"  class="suggest"  onkeyup="suggest(this)"><input type="hidden" name="selected[]" ></div></td></tr>
		<?php
		
		echo "</table></div><a id='addMore'>Add More</a>";
		
		echo "<input type='submit' name='diagnose' value='Diagnose' /><br>";
		
		
}
	?>
		
		</div>
	</form>
	
<?php include_layout_template('footer.php'); ?>
<script src="javascript/diagnose.js"></script>
		
