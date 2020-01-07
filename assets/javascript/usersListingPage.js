function validate() {
	let minLettersValidate = min3LettersValidate(document.querySelector("#searchItem").value);

	if (minLettersValidate) {
		$("#fullWrapper").css({ 'opacity': '0.5' });
		$("#loaderDiv").show();
	}

	return minLettersValidate;
}


$("body").on("click", ".delete", function(e) {
	id = $(e.currentTarget).data("id");
	console.log(id);

	//console.log( e.currentTarget.getAttribute("data-id").toString());
	//console.log(e.currentTarget.getAttribute("data-id")==$(e.currentTarget).data("id"));
});

$(document).ready(function() {
	$("#yes").on("click", function(){

		$.ajax({ 
			type 		: 'POST', 
			url 		: 'delete.php', 
			data 		: {'id':id},
			dataType 	: 'json',
			success 	: function(data) {
			    			if (data.success) { 
			    				//alert(data.message);
                                console.log(data.message);
                                $(".modal-title").text("User Deleted");
                                $(".modal-footer").hide();
                                setTimeout(()=>{window.location.href = window.location.href;}, 2000);
			    			}
						}
		});
	  
	});
});
