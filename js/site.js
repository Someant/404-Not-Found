
(function () {

    var formOne = function () {
    	var formData = $("#formOne").serialize();
    	
    	$.ajax({ url: '/ajax.php',
            data: formData,
            type: 'post',
            complete: function(output) {
                         $('#formOneResults').html(output.responseText);
                     }
    	});	  	
    };

    var formTwo = function () {
    	var formData = $("#formTwo").serialize();
    	
    	$.ajax({ url: '/ajax.php',
            data: formData,
            type: 'post',
            complete: function(output) {
                         $('#formTwoResults').html(output.responseText);
                     }
    	});	    	
    };

    $(document).ready(function () {
    	$("#formOneBtn").on("click", function(e){
    		e.preventDefault();
    		formOne();
    	});    	
    	
    	$("#formTwoBtn").on("click", function(e){
    		e.preventDefault();
    		formTwo();
    	});

    });

} ()); 


