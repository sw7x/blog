<?php $bodyId = "home" ?>

@include('header')



<!-- header start -->
<header>
@include('navigation')<!-- Headder Nav Bar End-->
@include('slider')<!-- Flash div  end -->
</header>
<!-- header end -->


<!-- welcome note div start -->
<div class="wel pages">
    <div class="wel container">
        <h1>
        welcome to luxury tours Sri lanka</h1>
        <p>Srilankan holidays offers you range of holidays package from luxury holidays to village holidays from any part of the country. We offer you in luxury transportation by land, sea or air for your ultimate comfort with a Professional English speaking tour guide that will escort you during your tour.</p>
    </div>
</div>
<!-- welcome note div end -->

<!-- Thing to do div start -->
<div class="thi pages">
    <div class="thi container">
        <h1>Things To Do</h1>

        <!-- Projects Row start -->
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-6 portfolio-item">
                <a href="#">
                    <img class="img-thumbnail img-responsive" src="{{ URL::to('/') }}/images/things/1.jpg" alt="">
                </a>
                <a class="thi-D" href="">Hiking</a>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6 portfolio-item">
                <a href="#">
                    <img class="img-thumbnail img-responsive" src="{{ URL::to('/') }}/images/things/5.jpg" alt="">
                </a>
                <a class="thi-D" href="">Surfing</a>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6 portfolio-item">
                <a href="#">
                    <img class="img-thumbnail img-responsive" src="{{ URL::to('/') }}/images/things/6.jpg" alt="">
                </a>
                <a class="thi-D" href="">Zip lining</a>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6 portfolio-item">
                <a href="#">
                    <img class="img-thumbnail img-responsive" src="{{ URL::to('/') }}/images/things/7.jpg" alt="">
                </a>
                <a class="thi-D" href="">Golfing</a>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6 portfolio-item">
                <a href="#">
                    <img class="img-thumbnail img-responsive" src="{{ URL::to('/') }}/images/things/8.jpg" alt="">
                </a>
                <a class="thi-D" href="">Off Road Adventures</a>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6 portfolio-item">
                <a href="#">
                    <img class="img-thumbnail img-responsive" src="{{ URL::to('/') }}/images/things/9.jpg" alt="">
                </a>
                <a class="thi-D" href="">Luxury Camping</a>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6 portfolio-item">
                <a href="#">
                    <img class="img-thumbnail img-responsive" src="{{ URL::to('/') }}/images/things/10.jpg" alt="">
                </a>
                <a class="thi-D" href="">Gem mines	</a>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6 portfolio-item">
                <a href="#">
                    <img class="img-thumbnail img-responsive" src="{{ URL::to('/') }}/images/things/11.jpg" alt="">
                </a>
                <a class="thi-D" href="">Waterfalls</a>
            </div>
        </div>
        <!-- Projects Row end -->
    </div>
</div>
<!--  Thing to do div end -->

<!-- Luxury hotels div start -->
<div class="pack pages">
    <div class="pack container">
        <h1>most popular Luxury hotels </h1>

        <!-- Projects Row start -->
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-6 portfolio-item">
                <a href="#">
                    <img class="img-thumbnail img-responsive" src="{{ URL::to('/') }}/images/packages/1.jpg" alt="">
                </a>

            </div>
            <div class="col-md-3 col-sm-3 col-xs-6 portfolio-item">
                <a href="#">
                    <img class="img-thumbnail img-responsive" src="{{ URL::to('/') }}/images/packages/2.jpg" alt="">
                </a>

            </div>
            <div class="col-md-3 col-sm-3 col-xs-6 portfolio-item">
                <a href="#">
                    <img class="img-thumbnail img-responsive" src="{{ URL::to('/') }}/images/packages/3.jpg" alt="">
                </a>

            </div>
            <div class="col-md-3 col-sm-3 col-xs-6 portfolio-item">
                <a href="#">
                    <img class="img-thumbnail img-responsive" src="{{ URL::to('/') }}/images/packages/4.jpg" alt="">
                </a>

            </div>
        </div>
        <!-- Projects Row end -->

    </div>
</div>
<!--  Luxury hotels div end -->










@include('footer')
