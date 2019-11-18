<?php
$directory ='ajax';
session_start();
include('../init.php');
include('../../dbcon.php');
//$page ='dashboard';
include('../data/escape_string.php');



if(!isset($_SESSION['admindata']))
{
    $mainAray['status'] = 'Failed0_';
    echo json_encode($mainAray);
    die();
    //exit();
}


try
{
    if ($_GET['action'] == 'list')
    {
        $jTableResult = array();
        $jTableResult['__________________________________________________StartIndex__________________________________________________'] = $StartIndex= $_REQUEST['jtStartIndex'];
        $jTableResult['__________________________________________________PageSize__________________________________________________'] = $PageSize = $_REQUEST['jtPageSize'];
        $jTableResult['__________________________________________________jtSorting__________________________________________________'] = $Sorting = $_REQUEST['jtSorting'];

        //Get records from database
        //$result = mysql_query ("SELECT * FROM tbl_deliverygrid LIMIT 3,5");

        //$jTableResult['qu'] = "SELECT * FROM tbl_deliverygrid LIMIT ".$StartIndex.",".$PageSize;

        //Get records from database

        $Sorting="deliverygrid_id DESC";

        if ($Sorting=='undefined')
        {
            $sql = "SELECT * FROM tbl_deliverygrid LIMIT ?,?";        
            $query = $conn->prepare($sql);            
            $query->bindParam(1, $StartIndex, PDO::PARAM_INT);
            $query->bindParam(2, $PageSize, PDO::PARAM_INT);
            $query->execute();
        }
        else
        {
            $sql = "SELECT * FROM tbl_deliverygrid order by {$Sorting} LIMIT ?,?";                    
            $query = $conn->prepare($sql);            
            $query->bindParam(1, $StartIndex, PDO::PARAM_INT);
            $query->bindParam(2, $PageSize, PDO::PARAM_INT);
            $query->execute();
        }

        $results = $query->fetchAll(PDO::FETCH_ASSOC);   
        //$rows_product_catgegories    = $query->rowCount();

        
        

        //Add all records to an array
        $resultArr = array();
        foreach ($results as $result)
        {
            $resultArr[] = $result;
        }

        //Return result to jTable
        $jTableResult['Result'] = "OK";
        $jTableResult['Records'] = $resultArr;

        $sqlAllRows           = "SELECT * FROM tbl_deliverygrid";
        $queryAllRows         = $conn->prepare($sqlAllRows); 
        $queryAllRows->execute();                    
        $rows_deliverygrid    = $queryAllRows->rowCount();

        $jTableResult["TotalRecordCount"] =  $rows_deliverygrid;
        
        print json_encode ($jTableResult);
        die();
        //print json_encode ("jTableResult");
        //var_dump($jTableResult);

    }
    else if ($_GET["action"] == "create")
    {
        if($_POST["area"]==''){throw new exception('area cannot be empty');}
        if($_POST["price"]==''){throw new exception('price cannot be empty');}

        $sql_area = "SELECT * FROM tbl_deliverygrid WHERE area = ?";
        $query_area = $conn->prepare($sql_area);
        $query_area->execute(array($_POST["area"]));       
        //$results = $query->fetchAll(PDO::FETCH_ASSOC);
        $rows = $query_area->rowCount();
        if($rows){throw new exception('area already in data grid');}




        //Insert record into database
        $insert_sql      = "INSERT INTO tbl_deliverygrid(deliverygrid_id,area,price) VALUES('', ?,?)";
        $insert_query    = $conn->prepare($insert_sql);
        $isInsert        = $insert_query->execute(array($_POST["area"],$_POST["price"]));



        //Get last inserted record (to return to jTable)           
        $sql = "SELECT * FROM tbl_deliverygrid WHERE deliverygrid_id = LAST_INSERT_ID()";
        $query = $conn->prepare($sql); 
        $query->execute();
        $lastRrow = $query->fetch(PDO::FETCH_ASSOC);  


        //Return result to jTable
        $jTableResult = array();
        $jTableResult['Result'] = "OK";
        $jTableResult['Record'] = $lastRrow;
        print json_encode ($jTableResult);
    }
    else if ($_GET["action"] == "update")
    {
        if($_POST["area"]==''){throw new exception('area cannot be empty');}
        if($_POST["price"]==''){throw new exception('price cannot be empty');}

        //TODO cannot update price
        $sql_area = "SELECT * FROM tbl_deliverygrid WHERE area = ? AND NOT deliverygrid_id = ?";
        
        $query_area = $conn->prepare($sql_area);
        $query_area->execute(array($_POST["area"],$_POST["deliverygrid_id"]));       
        //$results = $query->fetchAll(PDO::FETCH_ASSOC);
        $rows = $query_area->rowCount();
        if($rows){throw new exception('area already in data grid');}

        



        //Update record in database
        $update_sql   = "UPDATE tbl_deliverygrid SET area = ? , price = ? WHERE deliverygrid_id = ?";
        $update_query = $conn->prepare($update_sql);
        $update_query->execute(array($_POST["area"],$_POST["price"],$_POST["deliverygrid_id"])); 


        //Get last inserted record (to return to jTable)
        $sql   = "SELECT * FROM tbl_deliverygrid WHERE id = ?";
        $query = $conn->prepare($sql);
        $query->execute(array($_POST["deliverygrid_id"]));
        $lastRrow = $query->fetch(PDO::FETCH_ASSOC);


        //Return result to jTable
        $jTableResult = array();
        $jTableResult['Result'] = "OK";
        $jTableResult['Record'] = $lastRrow;
        print json_encode ($jTableResult);
    }
    //Deleting a record (deleteAction)
    else if ($_GET["action"] == "delete")
    {
        //Delete from database
        $sql = "DELETE FROM tbl_deliverygrid WHERE deliverygrid_id = ?";

        $query    = $conn->prepare($sql);
        $isDelete = $query->execute(array($_POST["deliverygrid_id"]));   


        //Return result to jTable
        $jTableResult = array();
        $jTableResult['Result'] = "OK";
        print json_encode ($jTableResult);
    }

}
catch(Exception $ex)
{
    //Return error message
    $jTableResult = array();
    $jTableResult['Result'] = "ERROR";
    $jTableResult['Message'] = $ex->getMessage();
    print json_encode($jTableResult);
}

?>
