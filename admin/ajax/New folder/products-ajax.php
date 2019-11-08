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

        $Sorting = "product_id DESC";
        //Get records from database
        if ($Sorting=='undefined')
        {
            if(!isset($_POST['storeid'])||$_POST['storeid']==0)
            {
                $sql = "SELECT * FROM tbl_products LIMIT ?,?";
                $query = $conn->prepare($sql);
                $query->bindParam(1, $StartIndex, PDO::PARAM_INT);
                $query->bindParam(2, $PageSize, PDO::PARAM_INT);
            
            }
            else
            {
                $sql = "SELECT * FROM tbl_products WHERE storeid = ? LIMIT ?,?";
                $query = $conn->prepare($sql);
                $query->bindParam(1, $_POST['storeid'], PDO::PARAM_INT);
                $query->bindParam(2, $StartIndex, PDO::PARAM_INT);
                $query->bindParam(3, $PageSize, PDO::PARAM_INT);
            }
        }
        else
        {
            if(!isset($_POST['storeid'])||$_POST['storeid']==0)
            {
                $sql = "SELECT * FROM tbl_products order by {$Sorting} LIMIT ?,?";
                $query = $conn->prepare($sql);                
                $query->bindParam(1, $StartIndex, PDO::PARAM_INT);
                $query->bindParam(2, $PageSize, PDO::PARAM_INT);
               
            }
            else
            {
                $sql = "SELECT * FROM tbl_products WHERE storeid= ? ORDER BY {$Sorting} LIMIT ?,?";
                $query = $conn->prepare($sql);
                $query->bindParam(1, $_POST['storeid'], PDO::PARAM_INT);
                $query->bindParam(2, $StartIndex, PDO::PARAM_INT);
                $query->bindParam(3, $PageSize, PDO::PARAM_INT);
            }

        }

        $query->execute();
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


        if(!isset($_POST['storeid'])||$_POST['storeid']==0)
        {
            $sqlAllProducts   = "SELECT * FROM tbl_products";
            $queryAllProducts = $conn->prepare($sqlAllProducts);                     
            $queryAllProducts->execute();

        }
        else
        {
            $sqlAllProducts = "SELECT * FROM tbl_products WHERE storeid=?";
            $queryAllProducts = $conn->prepare($sqlAllProducts);                     
            $queryAllProducts->execute($_POST['storeid']);
        }
        
        $rows_products    = $queryAllProducts->rowCount();
        $jTableResult["TotalRecordCount"] = $rows_products;


        //$jTableResult["TotalRecordCount"] =  mysql_num_rows(mysql_query ("SELECT * FROM tbl_products"));
        print json_encode ($jTableResult);

    }
    else if ($_GET["action"] == "create")
    {

        $jTableResult = array();
        $fileuploadedPath='';
        $productFolderName = '';

        if($_POST["name"]==''){throw new exception('product area cannot be empty');}
        if($_POST["price"]==''){throw new exception('product open time  cannot be empty');}




        $jTableResult['product_name'] = $product_name = $_POST["name"];
        $jTableResult['description'] = $description = escape_string($_POST["productDescriptionText"]);
        $jTableResult['price'] = $price = $_POST["price"];


        if(isset($_POST["storeid"]))
        {
            $jTableResult['storeid'] = $storeid = $_POST["storeid"];

            //check store has same produts
            $sql_store = "SELECT * FROM tbl_products WHERE name = ? AND storeid = ?";
            $query_store = $conn->prepare($sql_store);
            $query_store->execute(array($_POST["name"],$_POST["storeid"]));       
            //$results = $query->fetchAll(PDO::FETCH_ASSOC);
            $rows_store = $query_store->rowCount();
            if($rows_store){throw new exception('product name already exsists in store');}
            
        }
        else
        {
            $jTableResult['storeid'] = $storeid = 'NULL';
        }


        if(isset($_POST["categoryid"]))
        {
            $jTableResult['categoryid'] = $categoryid = $_POST["categoryid"];
        }
        else
        {
            $jTableResult['categoryid'] = $categoryid = 'NULL';
        }

        $productFolderNameDbInsert='';


        if(isset($_FILES['productimg']))
        {

            $jTableResult['file_name'] = $_FILES['productimg']['name'];
            $jTableResult['file_type'] = $_FILES['productimg']['type'];
            $jTableResult['file_tmp_name'] = $_FILES['productimg']['tmp_name'];
            $jTableResult['file_error'] = $_FILES['productimg']['error'];
            $jTableResult['file_size'] = $_FILES['productimg']['size'];


            $allowedExts = array("gif", "jpeg", "jpg", "png");
            $temp = explode(".", $_FILES["productimg"]["name"]);
            $extension = strtolower(end($temp));

            $filenameText = pathinfo($_FILES['productimg']['name'], PATHINFO_FILENAME);

            if ((   ($_FILES["productimg"]["type"] == "image/gif") || ($_FILES["productimg"]["type"] == "image/jpeg") ||
                    ($_FILES["productimg"]["type"] == "image/jpg") || ($_FILES["productimg"]["type"] == "image/jpeg")||
                    ($_FILES["productimg"]["type"] == "image/x-png") || ($_FILES["productimg"]["type"] == "image/png")  ) &&
                ($_FILES["productimg"]["size"] < 2000000)&& in_array($extension, $allowedExts) )
            {
                if ($_FILES["productimg"]["error"] > 0)
                {
                    throw new exception("file upload error Return Code: " . $_FILES["productimg"]["error"]);
                }
                else
                {

                    $t = time();
                    clearstatcache();

                    $newFileName = "../upload/products/product_" .$t."/".$filenameText."_".$t.".".$extension;
                    $newFileNameDbInsert = "upload/products/product_" .$t."/".$filenameText."_".$t.".".$extension;
                    $productFolderNameDbInsert = "upload/products/product_".$t;
                    $productFolderName = "../upload/products/product_".$t;

                    if (file_exists($newFileName))
                    {
                        throw new exception($_FILES["productimg"]["name"] . " already exists for user ".$_POST["name"]);
                    }
                    else
                    {

                        if(!is_dir($productFolderName))
                        {
                            if(!is_dir("../upload/products"))
                            {

                                if(!is_dir("../upload"))
                                {
                                    mkdir("../upload",0755);
                                }
                                mkdir ("../upload/products",0755,true);
                            }

                            mkdir("../upload/products/product_".$t,0755,true);
                        }

                        $isUploaded = move_uploaded_file($_FILES["productimg"]["tmp_name"],$newFileName);

                        if($isUploaded)
                        {
                            $fileuploadedPath = $newFileNameDbInsert;///////////////////////////
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
        $sql = "INSERT INTO tbl_products(product_id,
                                        name,
                                        description,
                                        price,
                                        image,
                                        folder,
                                        storeid,
                                        categoryid) VALUES('',?,?,?,?,?,?,?)";

        $query    = $conn->prepare($sql);
        $isInsert = $query->execute(array(  $product_name,
                                            $description,
                                            $price,
                                            $fileuploadedPath,
                                            $productFolderNameDbInsert,
                                            $storeid,
                                            $categoryid));     
                                            

        //Get last inserted record (to return to jTable)
        $lastRrowId     = $conn->lastInsertId();
        $sql = "SELECT * FROM tbl_products WHERE product_id = ?";
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

        if($_POST["name"]==''){throw new exception('product area cannot be empty');}
        if($_POST["price"]==''){throw new exception('product open time  cannot be empty');}

        $jTableResult['product_name'] = $product_name = $_POST["name"];
        $jTableResult['description'] = $description = escape_string($_POST["productDescriptionText"]);
        $jTableResult['price'] = $price = $_POST["price"];
        $jTableResult['productid'] = $productid = $_POST["product_id"];

        if(isset($_POST["storeid"]))
        {
            $jTableResult['storeid'] = $storeid = $_POST["storeid"];

            //checks if user enter store name already exsists
            $sql_store = "SELECT * FROM tbl_products WHERE name = ? AND storeid = ? AND NOT product_id = ?";
            $query_store = $conn->prepare($sql_store);
            $query_store->execute(array($_POST["name"],$_POST['storeid'],$_POST["product_id"]));
            //$results = $query->fetchAll(PDO::FETCH_ASSOC);
            $rows = $query_store->rowCount();
            if($rows){throw new exception('product name already exsists');}

        }
        else
        {
            $jTableResult['storeid'] = $storeid = 'NULL';
        }

        if(isset($_POST["categoryid"]))
        {
            $jTableResult['categoryid'] = $categoryid = $_POST["categoryid"];
        }
        else
        {
            $jTableResult['categoryid'] = $categoryid = 'NULL';
        }

        $productFolderNameDbInsert='';










        $sql = "SELECT * FROM tbl_products WHERE product_id = ?";
        $query = $conn->prepare($sql);
        $query->execute(array($_POST['product_id']));       
        $result = $query->fetch(PDO::FETCH_ASSOC);



        $jTableResult['productFoldername'] = $productFoldername = $result['folder'];
        $jTableResult['newFileNameDbInsert'] = $newFileNameDbInsert = $result['image'];
        $productFolderNameDbInsert = $productFoldername;

        if(isset($_FILES['productimg']))
        {

            $jTableResult['file_name'] = $_FILES['productimg']['name'];
            $jTableResult['file_type'] = $_FILES['productimg']['type'];
            $jTableResult['file_tmp_name'] = $_FILES['productimg']['tmp_name'];
            $jTableResult['file_error'] = $_FILES['productimg']['error'];
            $jTableResult['file_size'] = $_FILES['productimg']['size'];


            $allowedExts = array("gif", "jpeg", "jpg", "png");
            $temp = explode(".", $_FILES["productimg"]["name"]);
            $extension = strtolower(end($temp));

            $filenameText = pathinfo($_FILES['productimg']['name'], PATHINFO_FILENAME);

            if ((   ($_FILES["productimg"]["type"] == "image/gif") || ($_FILES["productimg"]["type"] == "image/jpeg") ||
                    ($_FILES["productimg"]["type"] == "image/jpg") || ($_FILES["productimg"]["type"] == "image/jpeg")||
                    ($_FILES["productimg"]["type"] == "image/x-png") || ($_FILES["productimg"]["type"] == "image/png")  ) &&
                ($_FILES["productimg"]["size"] < 2000000)&& in_array($extension, $allowedExts) )
            {
                if ($_FILES["productimg"]["error"] > 0)
                {
                    throw new exception("file upload error Return Code: " . $_FILES["storeimg_update"]["error"]);
                }
                else
                {

                    $t = time();
                    clearstatcache();

                    if($productFoldername=='')
                    {
                        $productFoldername = "upload/products/product_" .$t;

                        //if foldername is empty then create now timestamp
                        if(!is_dir("../".$productFoldername))
                        {
                            if(!is_dir("../upload/products"))
                            {

                                if(!is_dir("../upload"))
                                {
                                    mkdir("../upload",0755);
                                }
                                mkdir ("../upload/products",0755,true);
                            }
                            mkdir("../".$productFoldername,0755,true);
                        }

                    }
                    else
                    {
                        //if folder is not cretae folder according to db filename field
                        if(!is_dir("../".$productFoldername))
                        {
                            if(!is_dir("../upload/products"))
                            {

                                if(!is_dir("../upload"))
                                {
                                    mkdir("../upload",0755);
                                }
                                mkdir ("../upload/products",0755,true);
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
                        throw new exception(" file already exists for user ");
                    }
                    else
                    {
                        $isUploaded = move_uploaded_file($_FILES["productimg"]["tmp_name"],$newFileNamePath);

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
        $sql = "UPDATE tbl_products SET name = ?,
                                        description = ?,
                                        image = ?,
                                        price = ?,
                                        categoryid = ?,
                                        storeid = ?,
                                        folder = ? WHERE product_id=?";

        $query_category = $conn->prepare($sql);
        $query_category->execute(array( $product_name,
                                        $description,
                                        $newFileNameDbInsert,
                                        $price,
                                        $categoryid,
                                        $storeid,
                                        $productFolderNameDbInsert,
                                        $productid));                                        


        //Get last inserted record (to return to jTable)
        $sql   = "SELECT * FROM tbl_products WHERE product_id = ?";
        $query = $conn->prepare($sql);
        $query->execute(array($productid));
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

        $sql = "SELECT * FROM tbl_products WHERE product_id=?";
        $query    = $conn->prepare($sql);
        $isDelete = $query->execute(array($_POST["product_id"])); 
        $dbRecord  = $query->fetch(PDO::FETCH_ASSOC);  
        

        $jTableResult['product_id'] = $_POST["product_id"];

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
            $sql      = "DELETE FROM tbl_products  WHERE product_id = ?";
            $query    = $conn->prepare($sql);
            $isDelete = $query->execute(array($_POST["product_id"])); 


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
