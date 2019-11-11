<?php $bodyId = "teen-and-summer-holidays" ?>

@include('header')



<!-- header start -->
<header>
@include('navigation')<!-- Headder Nav Bar End-->
</header>
<!-- header end -->


<!-- Page  headder  div start -->


<div class="teen-and-summer-holidays pages">
    <div class="teen-and-summer-holidays container">
        <h1>Contact Submit</h1>
    </div>
</div>
<!-- page headder div end -->

<div class="con-itb pages">
    <div class="con-itb container" >
        <div class="row">
            <!-- Contact Form Section start -->
            <div class="cf col-lg-6 col-md-6 col-sm-6 col-xs-12">

                <div class="">

                    <h2>{{ session('status') != null ? session('status') : "Form is not submitted" }}</h2>
                    <p>{{ session('msg') != null ? session('msg') : "Error" }}</p>


                    <a class="left button" href="{{route('contact.index')}}"><i class="icon-home"></i>Go Back</a><br>
                    <a class="right button" href="{{route('index')}}"><i class="icon-home"></i>Go to Home Page</a>
                </div>

            </div>
            <!-- Contact Form Section End -->
        </div>
    </div>
</div>
<!-- page Discription end -->




@include('footer')
