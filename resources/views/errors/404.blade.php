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
        <h1>404 PAGE NOT FOUND</h1>
    </div>
</div>
<!-- page headder div end -->

<div class="con-itb pages">
    <div class="con-itb container" >
        <div class="row">
            <!-- Contact Form Section start -->
            <div class="cf col-lg-6 col-md-6 col-sm-6 col-xs-12">

                <div class="page404">
                    <h1>404</h1>
                    <p>Oops! Something is wrong.</p>{{ URL::previous() }}
{{--                    <a class="left button" href=""><i class="icon-home"></i>Go Back</a>--}}
                    <a class="right button" href="{{route('index')}}"><i class="icon-home"></i>Go to Home Page</a>
                </div>

            </div>
            <!-- Contact Form Section End -->
        </div>
    </div>
</div>
<!-- page Discription end -->




@include('footer')
