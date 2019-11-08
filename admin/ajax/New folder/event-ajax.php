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

        $Sorting="id DESC";

        //Get records from database
        if ($Sorting=='undefined')
        {
            $result = mysql_query ("SELECT * FROM tbl_events LIMIT " . $StartIndex . "," . $PageSize);
        }
        else
        {
            $result = mysql_query ("SELECT * FROM tbl_events order by ".$Sorting." LIMIT ".$StartIndex.",".$PageSize);
            //$jTableResult['############qq#############'] = "SELECT * FROM tbl_store order by ".$Sorting." LIMIT ".$StartIndex.",".$PageSize;
        }

        //Add all records to an array
        $rows = array();
        while ($row = mysql_fetch_array ($result))
        {
            $rows[] = $row;
        }

        //Return result to jTable
        $jTableResult['Result'] = "OK";
        $jTableResult['Records'] = $rows;
        $jTableResult["TotalRecordCount"] =  mysql_num_rows(mysql_query ("SELECT * FROM tbl_events"));
        print json_encode ($jTableResult);

    }
    else if ($_GET["action"] == "create")
    {

        $jTableResult = array();
        $fileuploadedPath='""';
        $eventFolderName = '""';

        if($_POST["name"]==''){throw new exception('events name cannot be empty');}





        $jTableResult['events_name'] = $events_name = "'".$_POST["name"]."'";
        $jTableResult['description'] = $description = "'".escape_string($_POST["eventDescriptionText"])."'";


        //check store has same produts
        $query_events = mysql_query ("SELECT * FROM tbl_events WHERE name = '".$_POST["name"]."'");
        $rows_events = mysql_num_rows($query_events);
        if($rows_events){throw new exception('event name already exsists');}


        $eventFolderNameDbInsert='""';


        if(isset($_FILES['eventimg']))
        {

            $jTableResult['file_name'] = $_FILES['eventimg']['name'];
            $jTableResult['file_type'] = $_FILES['eventimg']['type'];
            $jTableResult['file_tmp_name'] = $_FILES['eventimg']['tmp_name'];
            $jTableResult['file_error'] = $_FILES['eventimg']['error'];
            $jTableResult['file_size'] = $_FILES['eventimg']['size'];


            $allowedExts = array("gif", "jpeg", "jpg", "png");
            $temp = explode(".", $_FILES["eventimg"]["name"]);
            $extension = strtolower(end($temp));

            $filenameText = pathinfo($_FILES['eventimg']['name'], PATHINFO_FILENAME);

            if ((   ($_FILES["eventimg"]["type"] == "image/gif") || ($_FILES["eventimg"]["type"] == "image/jpeg") ||
                    ($_FILES["eventimg"]["type"] == "image/jpg") || ($_FILES["eventimg"]["type"] == "image/jpeg")||
                    ($_FILES["eventimg"]["type"] == "image/x-png") || ($_FILES["eventimg"]["type"] == "image/png")  ) &&
                ($_FILES["eventimg"]["size"] < 2000000)&& in_array($extension, $allowedExts) )
            {
                if ($_FILES["eventimg"]["error"] > 0)
                {
                    throw new exception("file upload error Return Code: " . $_FILES["eventimg"]["error"]);
                }
                else
                {

                    $t = time();
                    clearstatcache();

                    $newFileName = "../upload/events/events_item_" .$t."/".$filenameText."_".$t.".".$extension;
                    $newFileNameDbInsert = "upload/events/events_item_" .$t."/".$filenameText."_".$t.".".$extension;
                    $eventFolderNameDbInsert = "'"."upload/events/events_item_".$t."'";
                    $eventFolderName = "../upload/events/events_item_".$t;

                    if (file_exists($newFileName))
                    {
                        throw new exception($_FILES["eventimg"]["name"] . "image file already exists for this Event ".$_POST["name"]);
                    }
                    else
                    {

                        if(!is_dir($eventFolderName))
                        {
                            if(!is_dir("../upload/events"))
                            {

                                if(!is_dir("../upload"))
                                {
                                    mkdir("../upload",0755);
                                }
                                mkdir ("../upload/events",0755,true);
                            }

                            mkdir("../upload/events/event_item_".$t,0755,true);
                        }

                        $isUploaded = move_uploaded_file($_FILES["eventimg"]["tmp_name"],$newFileName);

                        if($isUploaded)
                        {
                            $fileuploadedPath="'".$newFileNameDbInsert."'";///////////////////////////
                        }
                        else
                        {
                            throw new exception("error file uploaded but not moved to correct location ");
                        }
                    }
                }
            }
            else
            {
                throw new exception("file is not image file");
            }
        }


        //Insert record into database
        $sql = "INSERT INTO tbl_events(id,
                                        name,
                                        description,
                                        image,
                                        folder) VALUES('',
                                                        $events_name,
                                                        $description,
                                                        $fileuploadedPath,
                                                        $eventFolderNameDbInsert)";
        $jTableResult['sql'] = $sql;
        $result = mysql_query ($sql);

        //Get last inserted record (to return to jTable)
        $result = mysql_query ("SELECT * FROM tbl_events WHERE id = LAST_INSERT_ID();");
        $row = mysql_fetch_array ($result);

        //Return result to jTable
        $jTableResult['Result'] = "OK";
        $jTableResult['Record'] = $row;

        print json_encode ($jTableResult);

    }
    else if ($_GET["action"] == "update")
    {

        $jTableResult = array();
        // $newFileNameDbInsert='""';

        if($_POST["name"]==''){throw new exception('event name cannot be empty');}


        $jTableResult['event_name'] = $events_name = "'".$_POST["name"]."'";
        $jTableResult['description'] = $description = "'".escape_string($_POST["eventDescriptionText"])."'";
        $jTableResult['eventid'] = $eventid = $_POST["id"];


        //checks if user enter store name already exsists
        $query_events = mysql_query ("SELECT * FROM tbl_events WHERE name = '".$_POST["name"]."' AND NOT id= ".$_POST["id"]);
        $rows = mysql_num_rows($query_events);
        if($rows){throw new exception('event already exsists');}

        $eventFolderNameDbInsert='""';










        $query = mysql_query ("SELECT * FROM tbl_events WHERE id =".$_POST["id"]);
        $result = mysql_fetch_array($query);
        $jTableResult['eventsFoldername'] = $eventFoldername = $result['folder'];
        $jTableResult['newFileNameDbInsert'] = $newFileNameDbInsert = "'".$result['image']."'";
        $eventFolderNameDbInsert = "'".$eventFoldername."'";

        if(isset($_FILES["eventimg"]))
        {

            $jTableResult['file_name'] = $_FILES["eventimg"]['name'];
            $jTableResult['file_type'] = $_FILES["eventimg"]['type'];
            $jTableResult['file_tmp_name'] = $_FILES["eventimg"]['tmp_name'];
            $jTableResult['file_error'] = $_FILES["eventimg"]['error'];
            $jTableResult['file_size'] = $_FILES["eventimg"]['size'];


            $allowedExts = array("gif", "jpeg", "jpg", "png");
            $temp = explode(".", $_FILES["eventimg"]["name"]);
            $extension = strtolower(end($temp));

            $filenameText = pathinfo($_FILES["eventimg"]['name'], PATHINFO_FILENAME);

            if ((   ($_FILES["eventimg"]["type"] == "image/gif") || ($_FILES["eventimg"]["type"] == "image/jpeg") ||
                    ($_FILES["eventimg"]["type"] == "image/jpg") || ($_FILES["eventimg"]["type"] == "image/jpeg")||
                    ($_FILES["eventimg"]["type"] == "image/x-png") || ($_FILES["eventimg"]["type"] == "image/png")  ) &&
                ($_FILES["eventimg"]["size"] < 2000000)&& in_array($extension, $allowedExts) )
            {
                if ($_FILES["eventimg"]["error"] > 0)
                {
                    throw new exception("file upload error Return Code: " . $_FILES["eventimg"]["error"]);
                }
                else
                {

                    $t = time();
                    clearstatcache();

                    if($eventFoldername=='')
                    {
                        $eventFoldername = "upload/events/event_item_" .$t;

                        //if foldername is empty then create now timestamp
                        if(!is_dir("../".$eventFoldername))
                        {
                            if(!is_dir("../upload/events"))
                            {

                                if(!is_dir("../upload"))
                                {
                                    mkdir("../upload",0755);
                                }
                                mkdir ("../upload/events",0755,true);
                            }
                            mkdir("../".$eventFoldername,0755,true);
                        }

                    }
                    else
                    {
                        //if folder is not cretae folder according to db filename field
                        if(!is_dir("../".$eventFoldername))
                        {
                            if(!is_dir("../upload/events"))
                            {

                                if(!is_dir("../upload"))
                                {
                                    mkdir("../upload",0755);
                                }
                                mkdir ("../upload/events",0755,true);
                            }
                            mkdir("../".$eventFoldername,0755,true);
                        }


                    }


                    $newFileName = $filenameText."_".$t.".".$extension;
                    $newFileNameDbInsert ="'". $newFileName."'";
                    $newFileNamePath = "../".$eventFoldername."/".$filenameText."_".$t.".".$extension;
                    $productFoldernameDbInsert = '"'.$eventFoldername.'"';

                    if (file_exists($newFileNamePath))
                    {
                        throw new exception(" file already exists for user ");
                    }
                    else
                    {
                        $isUploaded = move_uploaded_file($_FILES["eventimg"]["tmp_name"],$newFileNamePath);

                        if($isUploaded)
                        {
                            $newFileNameDbInsert = "'".$eventFoldername."/".$filenameText."_".$t.".".$extension."'";
                        }
                        else
                        {
                            throw new exception("error file uploaded but not moved to correct location ");
                        }
                    }
                }
            }
            else
            {
                throw new exception("file is not image file");
            }
        }


        //update record into database
        $sql = "UPDATE tbl_events SET name=".$events_name.",
                                            description=".$description.",
                                            image=".$newFileNameDbInsert.",
                                            folder=".$eventFolderNameDbInsert." WHERE id=".$eventid;




        $jTableResult['sql'] = $sql;
        $result = mysql_query ($sql);

        //Get last inserted record (to return to jTable)
        $result = mysql_query ("SELECT * FROM tbl_events WHERE id = ".$eventid);
        $row = mysql_fetch_array ($result);

        //Return result to jTable
        $jTableResult['Result'] = "OK";
        $jTableResult['Record'] = $row;

        print json_encode ($jTableResult);
    }
    //Deleting a record (deleteAction)
    else if ($_GET["action"] == "delete")
    {
        $jTableResult = array();

        $result = mysql_query ("SELECT * FROM tbl_events WHERE id=".$_POST["id"]);
        $dbRecord = mysql_fetch_array($result);

        $jTableResult['product_id'] = $_POST["id"];

        if($dbRecord['folder']!=='')
        {
            $isDelete = delete_files('../'.$dbRecord['folder']);
            // $isDelete = deleteDir('../'.$dbRecord['foldername']);
        }
        else
        {
            $isDelete = true;
        }

        $jTableResult['isDelete'] = $isDelete;


        if($isDelete)
        {
            //Delete from database
            $result = mysql_query ("DELETE FROM tbl_events WHERE id = " . $_POST["id"] . ";");

            //Return result to jTable
            $jTableResult['Result'] = "OK";

        }
        else
        {
            throw new exception('directory was unable to delete therefore record not deleted');
        }

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

function delete_files($path)
{
    if (is_dir($path) === true)
    {
        $files = array_diff(scandir($path), array('.', '..'));

        foreach ($files as $file)
        {
            delete_files(realpath($path) . '/' . $file);
        }

        return rmdir($path);
    }

    else if (is_file($path) === true)
    {
        unlink($path);
    }

    return false;
}


function deleteDir($dirPath)
{
    if (! is_dir($dirPath))
    {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/')
    {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file)
    {
        if (is_dir($file))
        {
            deleteDir($file);
        } else
        {
            return unlink($file);
        }
    }
    return rmdir($dirPath);
}


?>
