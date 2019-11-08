<?php
session_start();
$page ='';
include('../fn/escape_string.php');
include('../dbcon.php');

$sql = "SELECT * FROM tbl_admin WHERE id=1";



$query     = $conn->prepare($sql);
$isExecute = $query->execute();   
              



if($isExecute)
{

    $adminrows = $query->rowCount();
	
	
	if($adminrows==1)
	{
		$result = $query->fetch(PDO::FETCH_ASSOC);  



		$DBadmin = $result['username'];
		$DBadminpassowrd = $result['password'];
		
		if(!isset($_SESSION['admindata']))
		{	
			if(isset($_REQUEST['admin_submit']))
			{

		
				if($_REQUEST['admin_name']==$DBadmin && (md5($_REQUEST['admin_pass']))==$DBadminpassowrd)
				{


                    $_SESSION['admindata'] = array(
																		'is_login'=>true,
																		'username'=>'admin',
													);
					
					header('location:dashboard.php');
					
				}
				else
				{
					header('location:index.php');
				}
			}
			else
			{
				
			}
		}
		else
		{
			header('location:dashboard.php');
		}
	}
	else
	{
		header('location:index.php');
	}
}
else
{
	$adminrows = 0;
	header('location:index.php');
	
}
?>
<!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>
        <!-- META SECTION -->
        <title>ADMIN PANEL</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->

        <!-- CSS INCLUDE -->
        <link rel="stylesheet" type="text/css" id="theme" href="css/theme-default-head-light.css"/>
        <!-- EOF CSS INCLUDE -->
    </head>
    <body>
        
        <div class="login-container">
        
            <div class="login-box animated fadeInDown">
                <div class="login-logo1"></div>
                <div class="login-body">
                    <div class="login-title">LOGIN</div>
                    <form action="" class="form-horizontal" method="post" autocomplete="off">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="Username *" name="admin_name"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="password" class="form-control" placeholder="Password *" name="admin_pass"/>
                        </div>
                    </div>
                    <div class="form-group">
                        
                        <div class="col-md-6">
                            <button class="btn btn-info btn-block" name="admin_submit">Log In</button>
                        </div>
                        <div class="col-md-6">
                            <button type="reset" class="btn btn-warning btn-block" name="admin_submit">Reset</button>
                        </div>
                    </div>

                    <div class="form-group" id="" style="margin-top:15px;">
                        <div class="col-md-6" style="color:#fff;">
                            <span style="color:red;">*</span> - Required Fields
                        </div>
                    </div>


                    </form>
                </div>
                
            </div>
            
        </div>
        
    </body>
</html>






