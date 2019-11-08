<?php
$directory ='ajax';
session_start();
include('../init.php');
include('../../dbcon.php');
//$page ='dashboard';
include('../../fn/escape_string.php');



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
        $Sorting = "id DESC";
        
        if ($Sorting=='undefined')
        {
            $sql   = "SELECT * FROM tbl_user_comments LIMIT ?,?";            
            $query = $conn->prepare($sql);
            $query->bindParam(1, $StartIndex, PDO::PARAM_INT);
            $query->bindParam(2, $PageSize, PDO::PARAM_INT);
            $query->execute();
        }
        else
        {
            $sql   = "SELECT * FROM tbl_user_comments order by {$Sorting} LIMIT ?,?";           
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

        $sqlAllComments = "SELECT * FROM tbl_user_comments";
        $queryAllComments = $conn->prepare($sqlAllComments);                     
        $rows_comments    = $queryAllComments->rowCount();





        $jTableResult["TotalRecordCount"] =  $rows_comments;
        print json_encode ($jTableResult);
        //var_dump($jTableResult);

    }
    else if ($_GET["action"] == "create")
    {

    }
    else if ($_GET["action"] == "update")
    {

    }
    //Deleting a record (deleteAction)
    else if ($_GET["action"] == "delete")
    {
        //Delete from database
        $sql = "DELETE FROM tbl_user_comments WHERE id = ?";

        $query    = $conn->prepare($sql);
        $isDelete = $query->execute(array($_POST["id"]));   
        
        //$results = $query->fetchAll(PDO::FETCH_ASSOC);                
        //$rows_product_catgegories    = $query->rowCount();



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
