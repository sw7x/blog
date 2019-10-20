<!-- Tour Packages  headder  div start -->
<?php

$connection = mysqli_connect('localhost', 'root', '', 'ltsl');
mysqli_set_charset($connection,"utf8");

if(isset($_GET['destinations'])){

	$display_id= $_GET['destinations'];
	$select_post = "select * from package where id='$display_id'";
	$result = $connection->query($select_post);

while($row = $result->fetch_array())
  {
	$P_id = $row['id'];
	$P_title = $row['title'];
	$P_price = $row['price'];
	$P_discription =$row['discription'];
	$P_image = $row['image'];
	$P_duration = $row['duration'];
	$P_highlights1 = $row['highlights1'];
	$P_highlights2 = $row['highlights2'];
	$P_highlights3 = $row['highlights3'];
	$P_highlights4 = $row['highlights4'];
	$P_highlights5 = $row['highlights5'];
	
  }
}
else
{

		
		$P_id = '';
		$P_title = '';
		$P_price ='';
		$P_discription = '';
		$P_image = '';
		$P_image = '';
		$P_duration = '';
		$P_highlights1 ='';
		$P_highlights2 ='';
		$P_highlights3 ='';
		$P_highlights4 ='';
		$P_highlights5 ='';
		$display_id=NULL;

}


?>

    <div class="contact pages">
        <div class="contact container">
            <h1><?php echo $P_title;  ?></h1>
        </div>
    </div>
  <!-- Tour Packages  headder div end -->
  <!-- Tour Packages  Discription start -->
    <div class="con-itb pages">
    <div class="con-itb container" >

    
       <!-- Project One -->
        <div class="row">
            <div class="tp col-md-7">
                <a href="#">
                    <img class="img-responsive"  src="images/package/<?php  echo $P_image;?>" alt="">
                </a>
            </div>
            <div class="tp col-md-5">
                <h3><?php echo $P_title;  ?></h3>
                 <span> Duration:  <font > <?php echo $P_duration; ?> </font></span> <br><br>
				 <a class="tp btn btn-primary" href="#">From US$<?php echo $P_price;?></a>
                  
              
            </div>
        </div>
        
         <div class="row" style="padding-top:20px;">
            <div class="tp col-md-12">
              <p><?php echo $P_discription; ?></p>
              <h3>Tour Highlights</h3>
              <ul>
              <li><?php echo $P_highlights1; ?></li>
              <li><?php echo $P_highlights2; ?></li>
              <li><?php echo $P_highlights3; ?></li>
              <li><?php echo $P_highlights4; ?></li>
              <?php if($P_highlights5!==''){?><li><?php echo $P_highlights5; ?></li><?php }?>
              
              </ul>
            </div>
            
        </div>
        <!-- /.row -->

      
  
        

        
        
        

       

        
    
    </div>
    
    
    
</div>
    </div>
  <!-- Tour Packages  Discription  end -->
  
    
  

    