<?php $bodyId = "contact" ?>

<?php include "header.php"; ?>



<!-- header start -->
<header>
<?php include "navigation.php"; ?><!-- Headder Nav Bar End-->
</header>
<!-- header end -->


<!-- Page  headder  div start -->


<div class="contact pages">
    <div class="contact container">
        <h1>Contact Us</h1>
    </div>
</div>
<!-- page headder div end -->

<div class="con-itb pages">
    <div class="con-itb container" >
        <div class="row">
            <!-- Contact Form Section start -->
            <div class="cf col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <form role="form" action="" method="post">
                    <h3 >Send your Inquiry</h3>
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" type="textarea" id="message" placeholder="Message" maxlength="140" rows="7"></textarea>                    
                    </div>

                    <button type="reset" id="reset" name="reset" class="btn btn-danger ">Reset Form</button>&nbsp;
                    <button type="submit" id="submit" name="submit" class="btn btn-primary submit pull-right">Submit Form</button>

                </form>
            </div>
            <!-- Contact Form Section End -->


            


            
        </div>
    </div>
</div>
<!-- page Discription end -->



  
<?php include "footer.php"; ?>