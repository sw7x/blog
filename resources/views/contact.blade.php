<?php $bodyId = "contact" ?>

@include('header')



<!-- header start -->
<header>
@include('navigation')<!-- Headder Nav Bar End-->
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
                <form role="form" action="{{route('contact.submit')}}" method="post" class="contact-form">
                    <h3 >Send your Inquiry</h3>
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                        @if ($errors->has('name'))
                            <div class="error">{{ $errors->first('name') }}</div>
                        @endif
                    </div>

                    <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                        @if ($errors->has('email'))
                            <div class="error">{{ $errors->first('email') }}</div>
                        @endif
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number" required>
                        @if ($errors->has('mobile'))
                            <div class="error">{{ $errors->first('mobile') }}</div>
                        @endif
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required>
                        @if ($errors->has('subject'))
                            <div class="error">{{ $errors->first('subject') }}</div>
                        @endif
                    </div>

                    <div class="form-group">
                        <textarea class="form-control" type="textarea" name="message" id="message" placeholder="Message" maxlength="140" rows="7"></textarea>
                    </div>
                    {{ csrf_field() }}

                    <span class="msg-error error"></span>
                    <div id="recaptcha" class="g-recaptcha" data-sitekey="6LdCBcIUAAAAABi0vF5jBWKXdz2UfU0TN14qj9Zs" style="margin-bottom: 20px;"></div>

                    <button type="submit" id="submit" name="submit" class="btn btn-primary submit">Submit Form</button>
                    <button type="reset" id="reset" name="reset" class="btn btn-danger pull-right">Reset Form</button>&nbsp;

                </form>
            </div>
            <!-- Contact Form Section End -->






        </div>
    </div>
</div>
<!-- page Discription end -->




@include('footer')
