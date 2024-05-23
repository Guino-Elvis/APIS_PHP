function lfunction(){
	var dataString = $("#frmtest").serialize();
	//alert(dataString);

	$.ajax({
		type : "POST",
		url : "http://localhost/upeu/2024_1/test_api/v1/",
		
		//Add the request header		
		headers : {
			Authorization : '123456a'
		},		
		contentType : 'application/x-www-form-urlencoded',
		
		//Add form data
		data : dataString,
		
		success : function(response) {
			console.log(response);
		},
		error : function(xhr, status, error) {
			alert("Error: "+status+error);
		}
	}); //End of Ajax
}