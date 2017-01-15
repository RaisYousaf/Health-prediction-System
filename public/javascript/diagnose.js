var counter = 0;
function suggest(e){
	var input = e.value;
	input = input.trim()
	console.log(input);
	if(input != ''){
		$.ajax({
			type: "get",
			url: "autocomplete.php",
			data: {word: input},
			async: true,
			success: function(data){
				if(data !== false){
					var outWords = $.parseJSON(data); 
					$('#auto').remove();//remove any existing #auto
					$(e).after("<div id='auto' class='auto'></div>" );
					
					$('#auto').prepend('<div >');
					for(x = 0; x < outWords.length; x++){
						//Fills the #auto div with the options
						$('#auto').prepend('<div class=\"listitem\" padding-left=\"50px" value="'+outWords[x].s_id+'"> '+outWords[x].symptom+'</div><hr>'); 
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
		if(counter==0) $('tbody').append("<tr id='last'>");
		$('tbody #last').append("<td><div ><input type='text'  class='suggest' onkeyup='suggest(this)'><input type=\"hidden\" name=\"key[]\" ></div></td>")
		counter = counter + 1;
		if(counter % 3==0){
			$('#last').attr('id','');
			$('tbody').append("</tr><tr id='last'>");
		}
			
		
		
		
	});