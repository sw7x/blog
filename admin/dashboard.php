<?php

$page ='dashboard';
$directory ='';
session_start();
include('init.php');
include('../dbcon.php');




// $user_sql = "SELECT * FROM tbl_inquiry ORDER BY id ASC";
// $user_query     = $conn->prepare($user_sql);
// $user_query->execute();   
// $user_results = $user_query->fetchAll(PDO::FETCH_ASSOC);      




?>








<?php include 'header.php';?>

<?php include 'side.php';?>
            
    <!-- PAGE CONTENT -->
    <div class="page-content">

        <?php include 'navigation.php';?>



        <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">
            <div class="_container col-md-12">
                <h1 style="text-transform: uppercase">Dashboard</h1>

                <div class="table-responsive">
                        
                    <table class="table table-hover table-bordered" style="font-size: 14px;color:#000;font-weight: bold;">
                        <tr>
                            <th>Entity</th>
                            <th>Rows</th>
                        </tr>
                        <tr>
                            <td>PRODUCT CATEGORIES</td>
                            <td>44</td>
                        </tr>
                         <tr>
                            <td>STORES</td>
                             <td>44</td>
                        </tr>
                         <tr>
                            <td>PRODUCTS</td>
                            <td>44</td>
                        </tr>
                         <tr>
                            <td>DELIVERY GRIDS</td>
                             <td>44</td>
                         <tr>
                            <td>SMOKERS ITEMS</td>
                             <td>44</td>
                        </tr>
                         <tr>
                            <td>GROCERY ITEMS</td>
                             <td>44</td>
                        </tr>
                         <tr>
                            <td>FUN ACCESSORIES ITEMS</td>
                             <td>44</td>
                        </tr>
                         <tr>
                            <td>EVENTS</td>
                             <td>44</td>
                        </tr>
                         <tr>
                            <td>USER COMMENTS</td>
                            <td>44</td>
                         </tr>
                    </table>   
                        

                </div>

            </div>
        </div>
        <!-- END PAGE CONTENT WRAPPER -->
    </div>
    <!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->






<?php include 'footer.php';?>


















