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
            $sql =  "SELECT * FROM tbl_fun_accessories LIMIT ?,?";
        
            $query = $conn->prepare($sql);
            $query->bindParam(1, $StartIndex, PDO::PARAM_INT);
            $query->bindParam(2, $PageSize, PDO::PARAM_INT);
            $query->execute();

        }
        else
        {
            $sql = "SELECT * FROM tbl_fun_accessories order by {$Sorting} LIMIT ?,?";
            //$jTableResult['############qq#############'] = "SELECT * FROM tbl_store order by ".$Sorting." LIMIT ".$StartIndex.",".$PageSize;
            
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

        $sqlAllComments = "SELECT * FROM tbl_fun_accessories";
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

        if($_POST["name"]==''){throw new exception('fun accessories Item name cannot be empty');}
        if($_POST["price"]==''){throw new exception('fun accessories price Item cannot be empty');}




        $jTableResult['product_name'] = $product_name = $_POST["name"];
        $jTableResult['description'] = $description = escape_string($_POST["funAccessoriesDescriptionText"]);
        $jTableResult['price'] = $price = $_POST["price"];

        //check store has same produts
        $sql_FA   = "SELECT * FROM tbl_fun_accessories WHERE name = ?";        
        $query_FA = $conn->prepare($sql_FA);
        $query_FA->execute(array($_POST["name"]));       
        //$results = $query->fetchAll(PDO::FETCH_ASSOC);
        $rows_FA = $query_FA->rowCount();
        if($rows_FA){throw new exception('Item already exsists');}







        $productFolderNameDbInsert='';


        if(isset($_FILES['FAimg']))
        {

            $jTableResult['file_name'] = $_FILES['FAimg']['name'];
            $jTableResult['file_type'] = $_FILES['FAimg']['type'];
            $jTableResult['file_tmp_name'] = $_FILES['FAimg']['tmp_name'];
            $jTableResult['file_error'] = $_FILES['FAimg']['error'];
            $jTableResult['file_size'] = $_FILES['FAimg']['size'];


            $allowedExts = array("gif", "jpeg", "jpg", "png");
            $temp = explode(".", $_FILES["FAimg"]["name"]);
            $extension = strtolower(end($temp));

            $filenameText = pathinfo($_FILES['FAimg']['name'], PATHINFO_FILENAME);

            if ((   ($_FILES["FAimg"]["type"] == "image/gif") || ($_FILES["FAimg"]["type"] == "image/jpeg") ||
                    ($_FILES["FAimg"]["type"] == "image/jpg") || ($_FILES["FAimg"]["type"] == "image/jpeg")||
                    ($_FILES["FAimg"]["type"] == "image/x-png") || ($_FILES["FAimg"]["type"] == "image/png")  ) &&
                ($_FILES["FAimg"]["size"] < 2000000)&& in_array($extension, $allowedExts) )
            {
                if ($_FILES["FAimg"]["error"] > 0)
                {
                    throw new exception("file upload error Return Code: " . $_FILES["FAimg"]["error"]);
                }
                else
                {

                    $t = time();
                    clearstatcache();

                    $newFileName = "../upload/fun_accessories/FA_item_" .$t."/".$filenameText."_".$t.".".$extension;
                    $newFileNameDbInsert = "upload/fun_accessories/FA_item_" .$t."/".$filenameText."_".$t.".".$extension;
                    $productFolderNameDbInsert = "upload/fun_accessories/FA_item_".$t;
                    $productFolderName = "../upload/fun_accessories/FA_item_".$t;

                    if (file_exists($newFileName))
                    {
                        throw new exception($_FILES["FAimg"]["name"] . "image file already exists fun accessories item ".$_POST["name"]);
                    }
                    else
                    {

                        if(!is_dir($productFolderName))
                        {
                            if(!is_dir("../upload/fun_accessories"))
                            {

                                if(!is_dir("../upload"))
                                {
                                    mkdir("../upload",0755);
                                }
                                mkdir ("../upload/fun_accessories",0755,true);
                            }

                            mkdir("../upload/fun_accessories/FA_item_".$t,0755,true);
                        }

                        $isUploaded = move_uploaded_file($_FILES["FAimg"]["tmp_name"],$newFileName);

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
        $sql = "INSERT INTO tbl_fun_accessories(id,
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
        $sql = "SELECT * FROM tbl_fun_accessories WHERE id = ?";
        $query = $conn->prepare($sql); 
        $query->execute(array($lastRrowId));
        $lastRrow = $query->fetch(PDO::FETCH_ASSOC);  


         
        
        //var_dump($results);
        //Return result to jTable
        $jTableResult['Result'] = "OK";
        $jTableResult['Record'] = $lastRrow;
        print json_encode ($jTableResult);

    }
    else if ($_GET["action"] == "update")
    {

        





       $debugArr = array();


        // $newFileNameDbInsert='""';

        if($_POST["name"]==''){throw new exception('fun accessories Item name cannot be empty');}
        if($_POST["price"]==''){throw new exception('fun accessories Item price cannot be empty');}

        $debugArr['product_name']   = $product_name = $_POST["name"];
        $debugArr['description']    = $description = escape_string($_POST["funAccessoriesDescriptionText"]);
        $debugArr['price'] = $price = $_POST["price"];
        $debugArr['funAccessorieItemid'] = $funAccessorieItemid = $_POST["id"];


        //checks if user enter store name already exsists
        $sql_FA = "SELECT * FROM tbl_fun_accessories WHERE name = ? AND NOT id = ?";        
        $query_FA = $conn->prepare($sql_FA);
        $query_FA->execute(array($_POST["name"],$_POST['id']));       
        //$results = $query->fetchAll(PDO::FETCH_ASSOC);
        $rows = $query_FA->rowCount();
        if($rows){throw new exception('Item already exsists in fun accessories page');}

        $productFolderNameDbInsert='';










        $sql = "SELECT * FROM tbl_fun_accessories WHERE id = ?";
        $query = $conn->prepare($sql);
        $query->execute(array($_POST['id']));       
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $debugArr['productFoldername'] = $productFoldername = $result['folder'];
        $debugArr['newFileNameDbInsert'] = $newFileNameDbInsert = $result['image'];
        $productFolderNameDbInsert = $productFoldername;










        if(isset($_FILES["FAimg"]))
        {

            
            $debugArr['file_name'] = $_FILES["FAimg"]['name'];
            $debugArr['file_type'] = $_FILES["FAimg"]['type'];
            $debugArr['file_tmp_name'] = $_FILES["FAimg"]['tmp_name'];
            $debugArr['file_error'] = $_FILES["FAimg"]['error'];
            $debugArr['file_size'] = $_FILES["FAimg"]['size'];


            $allowedExts = array("gif", "jpeg", "jpg", "png");
            $temp = explode(".", $_FILES["FAimg"]["name"]);
            $extension = strtolower(end($temp));

            $filenameText = pathinfo($_FILES["FAimg"]['name'], PATHINFO_FILENAME);

            if ((   ($_FILES["FAimg"]["type"] == "image/gif") || ($_FILES["FAimg"]["type"] == "image/jpeg") ||
                    ($_FILES["FAimg"]["type"] == "image/jpg") || ($_FILES["FAimg"]["type"] == "image/jpeg")||
                    ($_FILES["FAimg"]["type"] == "image/x-png") || ($_FILES["FAimg"]["type"] == "image/png")  ) &&
                ($_FILES["FAimg"]["size"] < 2000000)&& in_array($extension, $allowedExts) )
            {
                if ($_FILES["FAimg"]["error"] > 0)
                {
                    throw new exception("file upload error Return Code: " . $_FILES["FAimg"]["error"]);
                }
                else
                {

                    $t = time();
                    clearstatcache();

                    if($productFoldername=='')
                    {
                        $productFoldername = "upload/fun_accessories/FA_item_" .$t;

                        //if foldername is empty then create now timestamp
                        if(!is_dir("../".$productFoldername))
                        {
                            if(!is_dir("../upload/fun_accessories"))
                            {

                                if(!is_dir("../upload"))
                                {
                                    mkdir("../upload",0755);
                                }
                                mkdir ("../upload/fun_accessories",0755,true);
                            }
                            mkdir("../".$productFoldername,0755,true);
                        }

                    }
                    else
                    {
                        //if folder is not cretae folder according to db filename field
                        if(!is_dir("../".$productFoldername))
                        {
                            if(!is_dir("../upload/fun_accessories"))
                            {

                                if(!is_dir("../upload"))
                                {
                                    mkdir("../upload",0755);
                                }
                                mkdir ("../upload/fun_accessories",0755,true);
                            }
                            mkdir("../".$productFoldername,0755,true);
                        }


                    }


                    $newFileName = $filenameText."_".$t.".".$extension;
                    $newFileNameDbInsert ="'". $newFileName."'";
                    $newFileNamePath = "../".$productFoldername."/".$filenameText."_".$t.".".$extension;
                    $productFolderNameDbInsert = '"'.$productFoldername.'"';

                    if (file_exists($newFileNamePath))
                    {
                        throw new exception(" file already exists for fun accessories item ");
                    }
                    else
                    {
                        $isUploaded = move_uploaded_file($_FILES["FAimg"]["tmp_name"],$newFileNamePath);

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
        $sql = "UPDATE tbl_fun_accessories SET  name = ?,
                                                description = ?,
                                                image = ?,
                                                price = ?,
                                                folder = ? WHERE id= ?";


        $query_category = $conn->prepare($sql);
        $query_category->execute(array( $product_name,
                                        $description,
                                        $newFileNameDbInsert,
                                        $price,
                                        $productFolderNameDbInsert,
                                        $funAccessorieItemid));                                      




        //Get last inserted record (to return to jTable)
        $sql   = "SELECT * FROM tbl_fun_accessories WHERE id = ?";
        $query = $conn->prepare($sql);
        $query->execute(array($funAccessorieItemid));
        $lastRrow = $query->fetch(PDO::FETCH_ASSOC);
        






       // $debugArr;

        //Return result to jTable
        $jTableResult = array();
        $jTableResult['Result'] = "OK";
        $jTableResult['Record'] = $lastRrow;
        print json_encode ($jTableResult);
    }
    //Deleting a record (deleteAction)
    else if ($_GET["action"] == "delete")
    {
        $jTableResult = array();

        $sql = "SELECT * FROM tbl_fun_accessories WHERE id=?";
        $query    = $conn->prepare($sql);
        $isDelete = $query->execute(array($_POST["id"])); 
        $dbRecord  = $query->fetch(PDO::FETCH_ASSOC);   

        
        //$query->debugDumpParams();

        

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

        //var_dump($isDelete);

        if($isDelete)
        {
            //Delete from database
            $sql      = "DELETE FROM tbl_fun_accessories  WHERE id = ?";
            $query    = $conn->prepare($sql);
            $isDelete = $query->execute(array($_POST["id"]));   

            //Return result to jTable
            $jTableResult = array();
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
