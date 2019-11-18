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
        $Sorting='category_id DESC';
        if ($Sorting=='undefined')
        {
            $sql = "SELECT * FROM tbl_category LIMIT ?,?";
            $jTableResult['############qq#############'] = $sql;

            $query = $conn->prepare($sql);
            $query->bindParam(1, $StartIndex, PDO::PARAM_INT);
            $query->bindParam(2, $PageSize, PDO::PARAM_INT);
            $query->execute();            
        }
        else
        {
            $sql = "SELECT * FROM tbl_category order by {$Sorting} LIMIT ?,?";
            //$sql = "SELECT * FROM tbl_category ORDER BY ";
            $jTableResult['############qq#############'] = $sql;
            
            $query = $conn->prepare($sql);            
            
            $query->bindParam(1, $StartIndex, PDO::PARAM_INT);
            $query->bindParam(2, $PageSize, PDO::PARAM_INT);
            $query->execute();
        }

        //$query->debugDumpParams();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);    


        //Add all records to an array
        $resultArr = array();
        foreach ($results as $result)
        {
            $resultArr[] = $result;
        }

        //Return result to jTable
        $jTableResult['Result'] = "OK";
        $jTableResult['Records'] = $resultArr;

        $sqlAllComments = "SELECT * FROM tbl_category";
        $queryAllComments = $conn->prepare($sqlAllComments);                     
        $queryAllComments->execute();
        $rows_comments    = $queryAllComments->rowCount();
        
        
        $jTableResult["TotalRecordCount"] =  $rows_comments;
        print json_encode ($jTableResult);


    }
    else if ($_GET["action"] == "create")
    {
        if($_POST["category"]==''){throw new exception('category cannot be empty');}

        //check category already exsists
        $sql_category = "SELECT * FROM tbl_category WHERE category = ?";        
        $query_category = $conn->prepare($sql_category);
        $query_category->execute(array($_POST["category"]));       
        //$results = $query->fetchAll(PDO::FETCH_ASSOC);
        $rows = $query_category->rowCount();
        if($rows){throw new exception('category already exists');}


        //Insert record into database
        $sql = "INSERT INTO tbl_category(category_id,category) VALUES('', ?)";
        $query    = $conn->prepare($sql);
        $isInsert = $query->execute(array($_POST["category"]));
        

        //Get last inserted record (to return to jTable)
        //$id = $conn->lastInsertId();
        $stmt     = $conn->query("SELECT LAST_INSERT_ID()");
        $lastRrow = $stmt->fetchColumn();

        var_dump($lastRrow);

        //Return result to jTable
        $jTableResult = array();
        $jTableResult['Result'] = "OK";
        $jTableResult['Record'] = $lastRrow;
        print json_encode ($jTableResult);
    }
    else if ($_GET["action"] == "update")
    {
        if($_POST["category"]==''){throw new exception('category cannot be empty');}

        $sql_category = "SELECT * FROM tbl_category WHERE category = ? AND NOT category_id = ?";        
        $query_category = $conn->prepare($sql_category);
        $query_category->execute(array($_POST["category"],$_POST['category_id']));       
        //$results = $query->fetchAll(PDO::FETCH_ASSOC);
        $rows = $query_category->rowCount();
        if($rows){throw new exception('category already exsists');}



        //Update record in database
        $sql_category_update = "UPDATE tbl_category SET category = ? WHERE category_id = ?";
        $query_category_update      = $conn->prepare($sql_category_update);
        $query_category_update->execute(array($_POST["category"],$_POST['category_id']));
        

        //Return result to jTable
        $jTableResult = array();
        $jTableResult['Result'] = "OK";
        print json_encode ($jTableResult);
    }
    //Deleting a record (deleteAction)
    else if ($_GET["action"] == "delete")
    {
        //Delete from database
        $sql = "DELETE FROM tbl_category WHERE category_id = ?";

        $query    = $conn->prepare($sql);
        $isDelete = $query->execute(array($_POST["category_id"]));   

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
