var counter = 0;
function suggest(e){
	var input = e.value;
	input = input.trim()
	console.log(input);
	if(input != ''){
		$.ajax({
			type: "get",
			url: "../autocomplete.php", //use dignose script they perform same function
			data: {word: input},
			async: true,
			success: function(data){
				if(data !== false){
					var outWords = $.parseJSON(data); 
					$('#auto').remove();//remove any existing #auto
					$(e).after("<div id='auto' class='auto' style='z-index:10000; position:absolute;'>" );
					
					$('#auto').prepend('<div >');
					for(x = 0; x < outWords.length; x++){
						//Fills the #auto div with the options
						$('#auto').prepend('<div class=\"listitem\"  value="'+outWords[x].s_id+'"> '+outWords[x].symptom+'</div><hr>'); 
						$('#auto').prepend('<input type="hidden" name="" value="'+outWords[x].s_id+'">');
					}
					
					$('#auto').prepend('</div>');
					
				}
			}
			})
	}
}


	
	
	 $(document.body).on('click', ".listitem", function(){
            var values = $(this).html();
			$('#auto').next().attr('value',$(this).prev().val());
			//$('#auto').after('<input type="hidden" name='selected[]' value="'+$(this).prev().val()+'">');
            $('#auto').prev().val(values);
            $('#auto').remove();
            return false;
        });
	$(document.body).on('click',  function(){
            $('#auto').remove();
        });
		
	
	
	
	$('#addMore').on('click', function(){
		
		console.log(counter);
		if(counter==0) $('#filer tbody').append("<tr id='last'>");
		$('tbody #last').append("<td><div ><input type='text' name='s_name[]' autocomplete='off' class='suggest' onkeyup='suggest(this)'><input type=\"hidden\" name=\"selected[]\" ></div></td>")
		counter = counter + 1;
		if(counter % 2==0){
			$('#last').attr('id','');
			$('#filer tbody').append("</tr><tr id='last'>");
		}
			
		
		
		
	});