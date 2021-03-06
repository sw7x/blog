
<footer>
    <div class="foot pages">
        <div class="content container">
            <div class="row">

                <div class="foots col-md-3 col-sm-6 col-xs-12">
                    <h3>Book & Pay</h3>
                    <a href="">How to Book & Pay</a>
                    <a href="">Child Discounts & Terms</a>
                    <a href="">Payments</a>
                </div>

                <div class="foot col-md-3 col-sm-6 col-xs-12">
                    <h3>
                    Address</h3>
                    <p>Luxury Tours Sri Lanka</p>
                    <p>No. 222 , " Leo House " </p>
                    <p>Cotta Road , Borella </p>
                    <p> Colombo 00800 , Sri Lanka. </p>
                </div>

                <div class="foot col-md-3 col-sm-6 col-xs-12">
                    <h3>Contact</h3>
                    <p><strong>Mobile USA </strong>+94 (11) 4610657</p>
                    <p><strong>Email USA </strong>info@webdsl.com</p>
                    <p><strong>Mobile SL </strong>+94 (0) 777 760123</p>
                    <p><strong>Email SL </strong>info@webdsl.com</p>
                </div>

                <div class="foot col-md-3 col-sm-6 col-xs-12">
                    <h3 style="padding-bottom:0;">Follow us</h3>
                    <div class="followUs">
                        <a  href="#"><i class="fa fa-facebook"></i></a> <span>Facebook</span>
                    </div>
                    <div class="followUs">
                        <a href="#"><i class="fa fa-google-plus"></i></a> <span>Google Plus</span>
                    </div>
                    <div class="followUs">
                        <a  href="#"><i class="fa fa-twitter"></i></a> <span>Twitter</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- content container -->

    <div class="webe pagess">
        <div class="wdbe container">
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <p style="font-family:Tahoma, Geneva, sans-serif; font-size:11px; color:#ffffff; float:left; margin-top:10px;">2015 © LANKA CCTV. All Rights Reserved.</p>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <a class="wdb" href="#" style="text-decoration:none; float:right" title="Web Design Sri Lanka"><p style="font-family:Tahoma, Geneva, sans-serif; font-size:11px; color:#ffffff; float:right; margin-top:10px;"> Design &amp; Develop by Web Designers Sri Lanka </p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- footer end -->
<script src="{{ URL::to('/') }}/js/jquery.min.js" type="text/javascript"></script>
<script src="{{ URL::to('/') }}/js/bootstrap.min.js" type="text/javascript"></script>
<script src="{{ URL::to('/') }}/js/script.js" type="text/javascript"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js'></script>
<script src="https://www.google.com/recaptcha/api.js"></script>
<script type="text/javascript">


	$( 'form.contact-form' ).on('reset', function(event){
		grecaptcha.reset();
		//event.preventDefault();
    });


	$( 'form.contact-form' ).submit(function(event){
		var $captcha = $( '#recaptcha' ),
			response = grecaptcha.getResponse();

		if (response.length === 0) {
			$( '.msg-error').text( "reCAPTCHA is mandatory" );
			if( !$captcha.hasClass( "error" ) ){
				$captcha.addClass( "error" );
			}
			return false;
		} else {
			$( '.msg-error' ).text('');
			$captcha.removeClass( "error" );
			//alert( 'reCAPTCHA marked' );
		}
		//event.preventDefault();
	});



    $(document).ready(function(){
        $('.image-popup-vertical-fit').magnificPopup({
            type: 'image',
            mainClass: 'mfp-with-zoom', 
            gallery:{
               enabled:true
            },

            zoom: {
                enabled: true, 

                duration: 300, // duration of the effect, in milliseconds
                easing: 'linear', // CSS transition easing function

                opener: function(openerElement) {
                  return openerElement.is('img') ? openerElement : openerElement.find('img');
                }
            }

        });

    });


</script>






</body>
</html>
