<?php 
$directory ='ajax';
session_start();
include('../init.php');
include('../../dbcon.php');
//$page ='dashboard';
include('../../fn/escape_string.php');


$mainAray;

if(!isset($_SESSION['admindata']))
{
	$mainAray['status'] = 'Failed0_';
	echo json_encode($mainAray);
	//die();
	exit();
}



	$password_old = md5($_REQUEST['pwOld']);
	$password_new = md5($_REQUEST['pwNew']);

	$sql = "SELECT * FROM tbl_admin WHERE id=1";
	$query = $conn->prepare($sql);
    $isExecute = $query->execute();   
                  
    





	if($isExecute)
	{
		
		$rows    = $query->rowCount();

		if($rows ==1)
		{
			$result = $query->fetch(PDO::FETCH_ASSOC);
			if($result['password']==$password_old)
			{
				$sql2 = "UPDATE tbl_admin SET password=? WHERE id=1";
				
				$query2     = $conn->prepare($sql2);
    			$isExecute2 = $query2->execute(array($password_new)); 


				if($isExecute2)
				{
					$mainAray['status'] = 'Successfully';
				}
				else
				{
					$mainAray['status'] = 'Failed1';
				}

			}
			else
			{
				$mainAray['status'] = 'Failed2';
			}
		}
		else
		{
			$mainAray['status'] = 'Failed3';
		}
	}
	else
	{
		$rows = 0;
		$mainAray['status'] = 'Failed4';
	}


		echo json_encode($mainAray);


		//$status
		//Failed
		//Successfully


?>