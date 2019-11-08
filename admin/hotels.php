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
                <h1 style="text-transform: uppercase">hotels</h1>

                
            </div>

        </div>
        <!-- END PAGE CONTENT WRAPPER -->
    </div>
    <!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->






<?php include 'footer.php';?>


















