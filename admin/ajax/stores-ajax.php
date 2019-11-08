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

        $Sorting = "store_id DESC";
        //Get records from database
        if ($Sorting=='undefined')
        {
            $sql = "SELECT * FROM tbl_store LIMIT ?,?";
            $query = $conn->prepare($sql);
            $query->bindParam(1, $StartIndex, PDO::PARAM_INT);
            $query->bindParam(2, $PageSize, PDO::PARAM_INT);
            $query->execute();

        }
        else
        {
            $sql = "SELECT * FROM tbl_store order by {$Sorting} LIMIT ?,?";
            $query = $conn->prepare($sql);            
            $query->bindParam(1, $StartIndex, PDO::PARAM_INT);
            $query->bindParam(2, $PageSize, PDO::PARAM_INT);
            $query->execute();
        }

        $results = $query->fetchAll(PDO::FETCH_ASSOC);                
        $rows_product_catgegories    = $query->rowCount();


        //Add all records to an array
        $resultArr = array();
        foreach ($results as $result)
        {
            $resultArr[] = $result;
        }

        //Return result to jTable

        $jTableResult['Result'] = "OK";
        $jTableResult['Records'] = $resultArr;

        $sqlAllComments = "SELECT * FROM tbl_store";
        $queryAllComments = $conn->prepare($sqlAllComments);                     
        $rows_comments    = $queryAllComments->rowCount();

        $jTableResult["TotalRecordCount"] =  $rows_comments;
        print json_encode ($jTableResult);

    }
    else if ($_GET["action"] == "create")
    {

        $jTableResult = array();
        $fileuploadedPath='""';
        $storeFolderName = '""';

        if($_POST["name"]==''){throw new exception('store area cannot be empty');}
        if($_POST["open"]==''){throw new exception('store open time  cannot be empty');}
        if($_POST["close"]==''){throw new exception('store close time cannot be empty');}

        
        //check store has same produts
        $sql_store   = "SELECT * FROM tbl_store WHERE name = ?";        
        $query_store = $conn->prepare($sql_store);
        $query_store->execute(array($_POST["name"]));       
        //$results = $query->fetchAll(PDO::FETCH_ASSOC);
        $rows_store = $query_store->rowCount();
        if($rows_store){throw new exception('store name already exsists');}



        $jTableResult['store_name'] = $store_name = $_POST["name"];
        $jTableResult['description'] = $description = escape_string($_POST["descriptionText"]);
        $jTableResult['open'] = $open = $_POST["open"];
        $jTableResult['close'] = $close = $_POST["close"];

        $storeFolderNameDbInsert='';
        if(isset($_FILES['storeimg']))
        {

            $jTableResult['file_name'] = $_FILES['storeimg']['name'];
            $jTableResult['file_type'] = $_FILES['storeimg']['type'];
            $jTableResult['file_tmp_name'] = $_FILES['storeimg']['tmp_name'];
            $jTableResult['file_error'] = $_FILES['storeimg']['error'];
            $jTableResult['file_size'] = $_FILES['storeimg']['size'];


            $allowedExts = array("gif", "jpeg", "jpg", "png");
            $temp = explode(".", $_FILES["storeimg"]["name"]);
            $extension = strtolower(end($temp));

            $filenameText = pathinfo($_FILES['storeimg']['name'], PATHINFO_FILENAME);

            if ((   ($_FILES["storeimg"]["type"] == "image/gif") || ($_FILES["storeimg"]["type"] == "image/jpeg") ||
                    ($_FILES["storeimg"]["type"] == "image/jpg") || ($_FILES["storeimg"]["type"] == "image/jpeg")||
                    ($_FILES["storeimg"]["type"] == "image/x-png") || ($_FILES["storeimg"]["type"] == "image/png")  ) &&
                ($_FILES["storeimg"]["size"] < 2000000)&& in_array($extension, $allowedExts) )
            {
                if ($_FILES["storeimg"]["error"] > 0)
                {
                    throw new exception("file upload error Return Code: " . $_FILES["storeimg"]["error"]);
                }
                else
                {

                    $t = time();
                    clearstatcache();

                    $newFileName = "../upload/stores/store_" .$t."/".$filenameText."_".$t.".".$extension;
                    $newFileNameDbInsert = "upload/stores/store_" .$t."/".$filenameText."_".$t.".".$extension;
                    $storeFolderNameDbInsert = "upload/stores/store_".$t;
                    $storeFolderName = "../upload/stores/store_".$t;

                    if (file_exists($newFileName))
                    {
                        throw new exception($_FILES["storeimg"]["name"] . " already exists for user ".$_POST["name"]);
                    }
                    else
                    {

                        if(!is_dir($storeFolderName))
                        {
                            if(!is_dir("../upload"))
                            {
                                mkdir("../upload",0755);
                                if(!is_dir("../upload/stores"))
                                {
                                    mkdir ("../upload/stores",0755,true);
                                }

                            }
                            mkdir("../upload/stores/store_".$t,0755,true);
                        }

                        $isUploaded = move_uploaded_file($_FILES["storeimg"]["tmp_name"],$newFileName);

                        if($isUploaded)
                        {
                            $fileuploadedPath=$newFileNameDbInsert;///////////////////////////
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
        $sql = "INSERT INTO tbl_store(  store_id,
                                        name,
                                        description,
                                        image,
                                        open,
                                        close,
                                        foldername) VALUES('',?,?,?,?,?,?)";

        $query    = $conn->prepare($sql);
        $isInsert = $query->execute(array(  $store_name,
                                            $description,
                                            $fileuploadedPath,
                                            $open,
                                            $close,
                                            $storeFolderNameDbInsert));


       
       //Get last inserted record (to return to jTable)
        $lastRrowId     = $conn->lastInsertId();        
        $sql = "SELECT * FROM tbl_store WHERE store_id = ?";
        $query = $conn->prepare($sql); 
        $query->execute(array($lastRrowId));
        $lastRrow = $query->fetch(PDO::FETCH_ASSOC);  
        

        //Return result to jTable
        $jTableResult['Result'] = "OK";
        $jTableResult['Record'] = $lastRrow;

        print json_encode ($jTableResult);

    }
    else if ($_GET["action"] == "update")
    {

        $jTableResult = array();
       // $newFileNameDbInsert='""';

        if($_POST["name"]==''){throw new exception('store area cannot be empty');}
        if($_POST["open"]==''){throw new exception('store open time  cannot be empty');}
        if($_POST["close"]==''){throw new exception('store close time cannot be empty');}

        //checks if user enter store name already exsists
        $sql_store = "SELECT * FROM tbl_store WHERE name = ? AND NOT store_id = ?";        
        $query_store = $conn->prepare($sql_store);
        $query_store->execute(array($_POST["name"],$_POST['store_id']));       
        //$results = $query->fetchAll(PDO::FETCH_ASSOC);
        $rows = $query_store->rowCount();
        if($rows){throw new exception('store name already exsists');}






        $jTableResult['store_name'] = $store_name = $_POST["name"];
        $jTableResult['description'] = $description = escape_string($_POST["descriptionText"]);
        $jTableResult['open'] = $open = $_POST["open"];
        $jTableResult['close'] = $close = $_POST["close"];
        $jTableResult['store_id'] = $storeid = $_POST["store_id"];


        $sql = "SELECT * FROM tbl_store WHERE store_id = ?";
        $query = $conn->prepare($sql);
        $query->execute(array($_POST['store_id']));       
        $result = $query->fetch(PDO::FETCH_ASSOC);



        $jTableResult['storeFoldername'] = $userFoldername = $result['foldername'];
        $jTableResult['newFileNameDbInsert'] = $newFileNameDbInsert = $result['image'];
        $userFoldernameDbInsert = $userFoldername;
        if(isset($_FILES['storeimg_update']))
        {

            $jTableResult['file_name'] = $_FILES['storeimg_update']['name'];
            $jTableResult['file_type'] = $_FILES['storeimg_update']['type'];
            $jTableResult['file_tmp_name'] = $_FILES['storeimg_update']['tmp_name'];
            $jTableResult['file_error'] = $_FILES['storeimg_update']['error'];
            $jTableResult['file_size'] = $_FILES['storeimg_update']['size'];


            $allowedExts = array("gif", "jpeg", "jpg", "png");
            $temp = explode(".", $_FILES["storeimg_update"]["name"]);
            $extension = strtolower(end($temp));

            $filenameText = pathinfo($_FILES['storeimg_update']['name'], PATHINFO_FILENAME);

            if ((   ($_FILES["storeimg_update"]["type"] == "image/gif") || ($_FILES["storeimg_update"]["type"] == "image/jpeg") ||
                    ($_FILES["storeimg_update"]["type"] == "image/jpg") || ($_FILES["storeimg_update"]["type"] == "image/jpeg")||
                    ($_FILES["storeimg_update"]["type"] == "image/x-png") || ($_FILES["storeimg_update"]["type"] == "image/png")  ) &&
                ($_FILES["storeimg_update"]["size"] < 2000000)&& in_array($extension, $allowedExts) )
            {
                if ($_FILES["storeimg_update"]["error"] > 0)
                {
                    throw new exception("file upload error Return Code: " . $_FILES["storeimg_update"]["error"]);
                }
                else
                {

                    $t = time();
                    clearstatcache();

                    if($userFoldername=='')
                    {
                        $userFoldername = "upload/stores/store_" .$t;

                        //if foldername is empty then create now timestamp
                        if(!is_dir("../".$userFoldername))
                        {
                            if(!is_dir("../upload"))
                            {
                                mkdir("../upload",0755);

                                if(!is_dir("../upload/stores"))
                                {
                                    mkdir ("../upload/stores",0755,true);

                                }

                            }
                            mkdir("../".$userFoldername,0755,true);

                        }

                    }
                    else
                    {
                        //if folder is not cretae folder according to db filename field
                        if(!is_dir("../".$userFoldername))
                        {
                            if(!is_dir("../upload"))
                            {
                                mkdir("../upload",0705);
                                chmod("../upload", 0705);
                                if(!is_dir("../upload/stores"))
                                {
                                    mkdir ("../upload/stores",0705,true);
                                    chmod("../upload/stores", 0705);
                                }

                            }
                            mkdir("../".$userFoldername,0705,true);
                            chmod("../".$userFoldername, 0705);
                        }


                    }


                    $newFileName = $filenameText."_".$t.".".$extension;
                    $newFileNameDbInsert = $newFileName;
                    $newFileNamePath = "../".$userFoldername."/".$filenameText."_".$t.".".$extension;
                    $userFoldernameDbInsert = '"'.$userFoldername.'"';

                    if (file_exists($newFileNamePath))
                    {
                        throw new exception(" file already exists for user ");
                    }
                    else
                    {
                        $isUploaded = move_uploaded_file($_FILES["storeimg_update"]["tmp_name"],$newFileNamePath);

                        if($isUploaded)
                        {
                            $newFileNameDbInsert = $userFoldername."/".$filenameText."_".$t.".".$extension;
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
        $sql = "UPDATE tbl_store SET    name= ?,
                                        description = ?,
                                        image = ?,
                                        open = ?,
                                        close = ?,
                                        foldername = ? WHERE store_id= ?";


        $query_category = $conn->prepare($sql);
        $query_category->execute(array( $store_name,
                                        $description,
                                        $newFileNameDbInsert,
                                        $open,
                                        $close,
                                        $userFoldernameDbInsert,
                                        $storeid)); 
                                        




        //Get last inserted record (to return to jTable)
        $sql   = "SELECT * FROM tbl_store WHERE store_id = ?";
        $query = $conn->prepare($sql);
        $query->execute(array($storeid));
        $lastRrow = $query->fetch(PDO::FETCH_ASSOC);


        

        //Return result to jTable
        $jTableResult['Result'] = "OK";
        $jTableResult['Record'] = $lastRrow;
        print json_encode ($jTableResult);
    }
    //Deleting a record (deleteAction)
    else if ($_GET["action"] == "delete")
    {
        $jTableResult = array();

        $sql = "SELECT * FROM tbl_store WHERE store_id = ?";
        $query    = $conn->prepare($sql);
        $isDelete = $query->execute(array($_POST["store_id"])); 
        $dbRecord  = $query->fetch(PDO::FETCH_ASSOC);  
        

        $jTableResult['store_id'] = $_POST["store_id"];

        if($dbRecord['foldername']!=='')
        {
            $isDelete = delete_files('../'.$dbRecord['foldername']);
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
            $sql      = "DELETE FROM tbl_store  WHERE store_id = ?";
            $query    = $conn->prepare($sql);
            $isDelete = $query->execute(array($_POST["store_id"]));   

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
