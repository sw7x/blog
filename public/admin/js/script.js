/**
 * Created by Home on 8/4/2015.
 */



$(document).on('click', '#chngpwclose', function (event)
{

	$('#passold').val('');
	$('#passnew').val('');
	$('#changePasswordStatus > p').html('');
	$('#mb-change-pw').removeClass('open');



});


$(document).on('click', 'input[name="change_password_submit"]', function (event)
{

//	$('#mb-change-pw').removeClass('open');
//	$('#mb-change-pw').addClass('open');


	var pwOld = $('input[name="password_old"]').val();
	var pwNew = $('input[name="password_new"]').val();
//	alert(pwOld);
//	alert(pwNew);

    var action    = $('#admin_change_password').attr('action');
    var csrfToken = $('input[name="_token"]').val();
    var userId    = $('input[name="userid"]').val();
    //alert(action);


    if(pwOld=='' || pwNew=='')
	{
		$('#changePasswordStatus > p').html('one of password cannot be empty').removeClass('green').addClass('red');
	}
	else
	{
		$.ajax(
		{
			type: "POST",
			dataType:'json',
			url:action,
			async:true,
			data:{
				pwOld : pwOld,
				pwNew : pwNew,
				_token : csrfToken,
				userId : userId


			},
			success:function(data)
			{

				if(data['status']=='Successfully')
				{

					$('#changePasswordStatus > p').html('Password Change Successfully').removeClass('red').addClass('green');

					setTimeout(function ()
					{
						$('#mb-change-pw').removeClass('open');
						$('#passold').val('');
						$('#passnew').val('');
						$('#changePasswordStatus > p').html('');
					}, 1000);




				}
				else
				{
					$('#changePasswordStatus > p').html('Password Change Failed').removeClass('green').addClass('red');
				}

			},
			error:function(request,errorType,errorMessage)
			{
				alert ('error - '+errorType+'with message - '+errorMessage);
			}
		});

	}


	event.preventDefault();
	event.stopPropagation();
	return false;


});


$(document).on('change', '.sazzad-file-upload input[type="file"]', function(event) {
    // Does some stuff and logs the event to the console
    var filename = $('.sazzad-file-upload input[type="file"]').val();
    var filenameaa = $(this).val();
    if (/^\s*$/.test(filename)) {
        $(".sazzad-file-upload").removeClass('active');
        $(".sazzad-file-upload #noFile").text("No file chosen...");
    }
    else {
        $(".sazzad-file-upload").addClass('active');
        $(".sazzad-file-upload #noFile").text(filename.replace("C:\\fakepath\\", ""));
    }
});



