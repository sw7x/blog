<?php $bodyId = "Packages" ?>

<?php include "header.php"; ?>



<!-- header start -->
<header>
<?php include "navigation.php"; ?>
</header>
<!-- header end -->








	<!-- Tour Packages  headder  div start -->

    <div class="contact pages">
        <div class="contact container">
            <h1>Tour Packages</h1>
        </div>
    </div>
  	<!-- Tour Packages  headder div end -->

  	<!-- Tour Packages  Discription start -->
    <div class="con-itb pages">
    	<div class="con-itb container" >    
     	<!-- Project One -->
		<?php

		$connection = mysqli_connect('localhost', 'root', '', 'travel');
		mysqli_set_charset($connection,"utf8");

		$select_post = "select * from package ";
		$result = $connection->query($select_post);

		while($row = $result->fetch_array())
		  {
			$P_id = $row['id'];
			$P_title = $row['title'];
			$P_price = $row['price'];
			$P_discription = substr($row['discription'],0,250);
			$P_image = $row['image'];
			$P_duration = $row['duration'];
			$P_highlights1 = $row['highlights1'];
			$P_highlights2 = $row['highlights2'];
			$P_highlights3 = $row['highlights3'];
			$P_highlights4 = $row['highlights4'];
			$P_highlights5 = $row['highlights5'];
		?>
	        <div class="row">
	            <div class="tp col-md-7">
	                <a href="packdisplay.php?dis=<?php echo $P_id; ?>">
	                    <img class="img-responsive"  src="images/package/<?php  echo $P_image;?>" alt="">
	                </a>
	            </div>
	            <div class="tp col-md-5">
	               <a href="packdisplay.php?dis=<?php echo $P_id; ?>"> <h3><?php echo $P_title;  ?></h3></a>
					 <a class="tp btn btn-primary" href="#">From US$<?php echo $P_price;?></a>
	                <p><?php echo $P_discription; ?></p>
	                <span> Duration:  <font > <?php echo $P_duration; ?> </font></span> <br>
	                <a class="tprm btn btn-primary" href="packdisplay.php?dis=<?php echo $P_id; ?>">Read More</a>
	            </div>
	        </div>
        <hr>
   		<?php 
   		} 
   		?>

   		</div>
    </div>
    <!-- Tour Packages  Discription  end -->


  
    <!-- Pagination -->
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-12">
                <ul class="pagination">
                    <li><a href="#">&laquo;</a></li>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">&raquo;</a></li>
                </ul>
            </div>
        </div>
    </div>


  

    


  

<?php include "footer.php"; ?>
