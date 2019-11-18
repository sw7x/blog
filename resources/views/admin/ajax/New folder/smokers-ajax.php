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
            $sql = "SELECT * FROM tbl_smokers LIMIT ?,?";
            $query = $conn->prepare($sql);
            $query->bindParam(1, $StartIndex, PDO::PARAM_INT);
            $query->bindParam(2, $PageSize, PDO::PARAM_INT);
            $query->execute();

        }
        else
        {
            $sql = "SELECT * FROM tbl_smokers order by {$Sorting} LIMIT ?,?";
            $query = $conn->prepare($sql);            
            $query->bindParam(1, $StartIndex, PDO::PARAM_INT);
            $query->bindParam(2, $PageSize, PDO::PARAM_INT);
            $query->execute();
        
        }

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

        $sqlAllComments = "SELECT * FROM tbl_smokers";
        $queryAllComments = $conn->prepare($sqlAllComments);                     
        $queryAllComments->execute();
        $rows_comments    = $queryAllComments->rowCount();
        
        
        $jTableResult["TotalRecordCount"] =  $rows_comments;
        print json_encode ($jTableResult);


    }
    else if ($_GET["action"] == "create")
    {

        $jTableResult = array();
        $fileuploadedPath='""';
        $productFolderName = '""';

        if($_POST["name"]==''){throw new exception('smokers Item name cannot be empty');}
        if($_POST["price"]==''){throw new exception('smokers Item price cannot be empty');}




        $jTableResult['product_name'] = $product_name = $_POST["name"];
        $jTableResult['description'] = $description = escape_string($_POST["smokersDescriptionText"]);
        $jTableResult['price'] = $price = $_POST["price"];

        //check store has same produts
        $sql_smoke = "SELECT * FROM tbl_smokers WHERE name = ?";        
        $query_smoke = $conn->prepare($sql_smoke);
        $query_smoke->execute(array($_POST["name"]));       
        //$results = $query->fetchAll(PDO::FETCH_ASSOC);
        $rows_smoke = $query_smoke->rowCount();
        if($rows_smoke){throw new exception('Item already exsists in smokers page');}


        $productFolderNameDbInsert='';


        if(isset($_FILES['smokersimg']))
        {

            $jTableResult['file_name'] = $_FILES['smokersimg']['name'];
            $jTableResult['file_type'] = $_FILES['smokersimg']['type'];
            $jTableResult['file_tmp_name'] = $_FILES['smokersimg']['tmp_name'];
            $jTableResult['file_error'] = $_FILES['smokersimg']['error'];
            $jTableResult['file_size'] = $_FILES['smokersimg']['size'];


            $allowedExts = array("gif", "jpeg", "jpg", "png");
            $temp = explode(".", $_FILES["smokersimg"]["name"]);
            $extension = strtolower(end($temp));

            $filenameText = pathinfo($_FILES['smokersimg']['name'], PATHINFO_FILENAME);

            if ((   ($_FILES["smokersimg"]["type"] == "image/gif") || ($_FILES["smokersimg"]["type"] == "image/jpeg") ||
                    ($_FILES["smokersimg"]["type"] == "image/jpg") || ($_FILES["smokersimg"]["type"] == "image/jpeg")||
                    ($_FILES["smokersimg"]["type"] == "image/x-png") || ($_FILES["smokersimg"]["type"] == "image/png")  ) &&
                ($_FILES["smokersimg"]["size"] < 2000000)&& in_array($extension, $allowedExts) )
            {
                if ($_FILES["smokersimg"]["error"] > 0)
                {
                    throw new exception("file upload error Return Code: " . $_FILES["smokersimg"]["error"]);
                }
                else
                {

                    $t = time();
                    clearstatcache();

                    $newFileName = "../upload/smokers/smoke_item_" .$t."/".$filenameText."_".$t.".".$extension;
                    $newFileNameDbInsert = "upload/smokers/smoke_item_" .$t."/".$filenameText."_".$t.".".$extension;
                    $productFolderNameDbInsert = "upload/smokers/smoke_item_".$t;
                    $productFolderName = "../upload/smokers/smoke_item_".$t;

                    if (file_exists($newFileName))
                    {
                        throw new exception($_FILES["smokersimg"]["name"] . " image file  already exists smokers item ".$_POST["name"]);
                    }
                    else
                    {

                        if(!is_dir($productFolderName))
                        {
                            if(!is_dir("../upload/smokers"))
                            {

                                if(!is_dir("../upload"))
                                {
                                    mkdir("../upload",0755);
                                }
                                mkdir ("../upload/smokers",0755,true);
                            }

                            mkdir("../upload/smokers/smoke_item_".$t,0755,true);
                        }

                        $isUploaded = move_uploaded_file($_FILES["smokersimg"]["tmp_name"],$newFileName);

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
        $sql = "INSERT INTO tbl_smokers(id,
                                        name,
                                        description,
                                        price,
                                        image,
                                        folder) VALUES('',?,?,?,?,?)";



        $query    = $conn->prepare($sql);
        $isInsert = $query->execute(array(  $product_name,
                                            $description,
                                            $price,
                                            $fileuploadedPath,
                                            $productFolderNameDbInsert)); 

        //Get last inserted record (to return to jTable)
        $lastRrowId     = $conn->lastInsertId();        
        $sql = "SELECT * FROM tbl_smokers WHERE id = ?";
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

        if($_POST["name"]==''){throw new exception('smokers Item name cannot be empty');}
        if($_POST["price"]==''){throw new exception('smokers Item price cannot be empty');}

        $jTableResult['product_name'] = $product_name = $_POST["name"];
        $jTableResult['description'] = $description = escape_string($_POST["smokersDescriptionText"]);
        $jTableResult['price'] = $price = $_POST["price"];
        $jTableResult['smokesItemid'] = $smokesItemid = $_POST["id"];


        //checks if user enter store name already exsists
        $sql_smoke = "SELECT * FROM tbl_smokers WHERE name = ? AND NOT id = ?";        
        $query_smoke = $conn->prepare($sql_smoke);
        $query_smoke->execute(array($_POST["name"],$_POST['id']));       
        //$results = $query->fetchAll(PDO::FETCH_ASSOC);
        $rows = $query_smoke->rowCount();
        if($rows){throw new exception('Item already exsists in fun accessories page');}

        $productFolderNameDbInsert='';










        $sql = "SELECT * FROM tbl_smokers WHERE id = ?";
        $query = $conn->prepare($sql);
        $query->execute(array($_POST['id']));       
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $debugArr['productFoldername'] = $productFoldername = $result['folder'];
        $debugArr['newFileNameDbInsert'] = $newFileNameDbInsert = $result['image'];
        $productFolderNameDbInsert = $productFoldername;

        if(isset($_FILES["smokersimg"]))
        {

            $jTableResult['file_name'] = $_FILES["smokersimg"]['name'];
            $jTableResult['file_type'] = $_FILES["smokersimg"]['type'];
            $jTableResult['file_tmp_name'] = $_FILES["smokersimg"]['tmp_name'];
            $jTableResult['file_error'] = $_FILES["smokersimg"]['error'];
            $jTableResult['file_size'] = $_FILES["smokersimg"]['size'];


            $allowedExts = array("gif", "jpeg", "jpg", "png");
            $temp = explode(".", $_FILES["smokersimg"]["name"]);
            $extension = strtolower(end($temp));

            $filenameText = pathinfo($_FILES["smokersimg"]['name'], PATHINFO_FILENAME);

            if ((   ($_FILES["smokersimg"]["type"] == "image/gif") || ($_FILES["smokersimg"]["type"] == "image/jpeg") ||
                    ($_FILES["smokersimg"]["type"] == "image/jpg") || ($_FILES["smokersimg"]["type"] == "image/jpeg")||
                    ($_FILES["smokersimg"]["type"] == "image/x-png") || ($_FILES["smokersimg"]["type"] == "image/png")  ) &&
                ($_FILES["smokersimg"]["size"] < 2000000)&& in_array($extension, $allowedExts) )
            {
                if ($_FILES["smokersimg"]["error"] > 0)
                {
                    throw new exception("file upload error Return Code: " . $_FILES["smokersimg"]["error"]);
                }
                else
                {

                    $t = time();
                    clearstatcache();

                    if($productFoldername=='')
                    {
                        $productFoldername = "upload/smokers/smoke_item_" .$t;

                        //if foldername is empty then create now timestamp
                        if(!is_dir("../".$productFoldername))
                        {
                            if(!is_dir("../upload/smokers"))
                            {

                                if(!is_dir("../upload"))
                                {
                                    mkdir("../upload",0755);
                                }
                                mkdir ("../upload/smokers",0755,true);
                            }
                            mkdir("../".$productFoldername,0755,true);
                        }

                    }
                    else
                    {
                        //if folder is not cretae folder according to db filename field
                        if(!is_dir("../".$productFoldername))
                        {
                            if(!is_dir("../upload/smokers"))
                            {

                                if(!is_dir("../upload"))
                                {
                                    mkdir("../upload",0755);
                                }
                                mkdir ("../upload/smokers",0755,true);
                            }
                            mkdir("../".$productFoldername,0755,true);
                        }


                    }


                    $newFileName = $filenameText."_".$t.".".$extension;
                    $newFileNameDbInsert ="'". $newFileName."'";
                    $newFileNamePath = "../".$productFoldername."/".$filenameText."_".$t.".".$extension;
                    $productFoldernameDbInsert = '"'.$productFoldername.'"';

                    if (file_exists($newFileNamePath))
                    {
                        throw new exception(" file already exists for item ");
                    }
                    else
                    {
                        $isUploaded = move_uploaded_file($_FILES["smokersimg"]["tmp_name"],$newFileNamePath);

                        if($isUploaded)
                        {
                            $newFileNameDbInsert = $productFoldername."/".$filenameText."_".$t.".".$extension;
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
        $sql = "UPDATE tbl_smokers SET  name = ?,
                                        description = ?,
                                        image = ?,
                                        price = ?,
                                        folder = ? WHERE id= ?";


        $query = $conn->prepare($sql);
        $query->execute(array( $product_name,
                                        $description,
                                        $newFileNameDbInsert,
                                        $price,
                                        $productFolderNameDbInsert,
                                        $smokesItemid));                                     


        //Get last inserted record (to return to jTable)
        $sql   = "SELECT * FROM tbl_smokers WHERE id = ?";
        $query = $conn->prepare($sql);
        $query->execute(array($smokesItemid));
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

        $sql = "SELECT * FROM tbl_smokers WHERE id=?";
        $query    = $conn->prepare($sql);
        $isDelete = $query->execute(array($_POST["id"])); 
        $dbRecord  = $query->fetch(PDO::FETCH_ASSOC);   

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
            $sql      = "DELETE FROM tbl_smokers  WHERE id = ?";
            $query    = $conn->prepare($sql);
            $isDelete = $query->execute(array($_POST["id"]));

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
