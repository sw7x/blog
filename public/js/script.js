$(function () {

    $("#home a:contains('Home')").parent().addClass("active");
    
    $("#Destinations a:contains('Destinations')").parent().addClass("active"); 
	$("#Destinations-2 a:contains('Destinations')").parent().addClass("active");
	$("#Packages a:contains('Tour packages')").parent().addClass("active");
	$("#Accommodation a:contains('Accommodation')").parent().addClass("active");
	$("#Gallery a:contains('Gallery')").parent().addClass("active");
	$("#contact a:contains('Contact us')").parent().addClass("active");
	
    $("#teen-and-summer-holidays a:contains('Teen age summer holidays')").parent().addClass("active");
    
   
     $('#characterLeft').text('140 characters left');
    $('#message').keydown(function () {
        var max = 140;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft').text('You have reached the limit');
            $('#characterLeft').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft').removeClass('red');            
        }
    }); 
   
   });