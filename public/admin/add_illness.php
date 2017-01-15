<?php require_once("../../includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) { redirect_to("login.php"); }

 
	 if(isset($_POST['addillness'])){
		 
		 
		
		
		$illness = $_POST['illness'];
		
		$selected = array();
		$new_symptoms = array();
		var_dump($_POST['selected']);
		echo "<br />";
		var_dump($_POST['s_name']);

		if(isset($_POST['selected'])  || isset($_POST['s_name'])){
			$key = $_POST['selected'];
			$s_name = $_POST['s_name'];
			echo count($s_name);
			for($i=0; $i<count($s_name); $i++){
				if(empty($key[$i]) && !empty($s_name[$i]))
					array_push($new_symptoms, $s_name[$i]);
				elseif(!empty($key[$i]))
					array_push($selected, $key[$i]);
				elseif(empty($key[$i]) && empty($s_name[$i]))
					continue;
				
				
			}
		}
		
		//add the new illness to database
		//$query = "INSERT INTO illness VALUES('','$illness')";
		$new_illness = new Illness();
		$new_illness->name = $illness;
		$new_illness->save();
		//$database->query($query);
		$illness_id = $database->insert_id();
		
		
		// var_dump($new_symptoms);
		// echo "<br />";
		// var_dump($selected);

		//register the selected symptoms from the auto dropdown
		foreach($selected as $sel){
			//$sel_symp = Symptom::find_by_id($sel);
			$i_s = new Illness_Symptom();
			$i_s->illness_id = $illness_id;
			$i_s->s_id = $sel;
			$i_s->save();
		}

		//register the newly type symptoms
		foreach($new_symptoms as $n_s){
			$symptom = new Symptom();
			$symptom->name = $n_s;
			$symptom->save();
			
			//grab d id of the just added symptom
			$symptom_id = $database->insert_id();
			$i_s = new Illness_Symptom();
			$i_s->illness_id = $illness_id;
			$i_s->s_id = $symptom_id;
			$i_s->save();
			
			
			
		}
		
		
		
		$session->message($illness.' is added.');
		//redirect_to('add_illness.php');
		
	
	
	//redirect_to("index.php");
	
}
	?>



<?php include_layout_template('admin_header.php'); ?>
<div id="con">
          

<div class="form-mini-container">
    <form class="form-validation" method="post" action="add_illness.php">
		<div class="form-title-row">
            <h1>Add new Illness</h1>
		</div>

<?php echo output_msg($message); ?>
 

		<ul>
			<li><a href="index.php">Go back</a></li>
		</ul> 
		<table cellspacing="5" cellpadding="5" >
          <tbody>
			<tr>
          <td>
              <label>
                  Sickness Name:
                  <input name="illness" type="text" class="suggest"  onkeyup="suggest(this)">
                  
              </label>
          </td>
          <td>
              <label>
                  Symptoms:</label>
                  <?php 
				echo '<div id="wrapper"><table id="filer">';
		?>
			<tr><td><div ><input type="text" name="s_name[]" class="suggest" autocomplete="off" onkeyup="suggest(this)"><input type="hidden" name="selected[]" ></div></td>
			<td><div ><input type="text" name="s_name[]" class="suggest" autocomplete="off" onkeyup="suggest(this)"><input type="hidden" name="selected[]" ></div></td></tr>
			<tr><td><div ><input type="text" name="s_name[]" class="suggest" autocomplete="off" onkeyup="suggest(this)"><input type="hidden" name="selected[]" ></div></td>
			<td><div ><input type="text" name="s_name[]" class="suggest" autocomplete="off" onkeyup="suggest(this)"><input type="hidden" name="selected[]" ></div></td></tr>
			<tr><td><div ><input type="text" name="s_name[]" class="suggest" autocomplete="off"  onkeyup="suggest(this)"><input type="hidden" name="selected[]" ></div></td>
			<td><div ><input type="text" name="s_name[]" class="suggest" autocomplete="off" onkeyup="suggest(this)"><input type="hidden" name="selected[]" ></div></td></tr>
		<?php
		
		echo "</table></div><a id='addMore'>Add More</a>";
		
				  ?>
                  
              
          </td>
        </tr>
				
		
		  </tbody>
		</table>
		<label>
                   <input name="addillness" type="submit" value="Add illness">
                  
              </label>

<?php include_layout_template('admin_footer.php'); ?>
<script src="../javascript/add_illness.js"></script>