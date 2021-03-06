﻿<?php $bodyId = "Gallery" ?>

@include('header')


<!-- header start -->
<header>
@include('navigation')<!-- Headder Nav Bar End-->
</header>
<!-- header end -->


<!-- Tour Packages  headder  div start -->


<div class="contact pages">
    <div class="contact container">
        <h1>Gallery</h1>
    </div>
</div>
<!-- Tour Packages  headder div end -->

<!-- Tour Packages  Discription start -->
<div class="con-itb pages">
    <div class="con-itb container" >

        <!-- Projects Row -->
        <div class="row">
            
            <!-- Image Block 1 start -->
            <div class="col-lg-6 col-md-4 col-xs-6 thumb mfp-with-zoom">
                <a class="image-popup-vertical-fit thumbnail" href="{{ URL::to('/') }}/images/accommodation/1.jpg" data-lightbox="Test" data-title="">
                    <img class="img-responsive" src="{{ URL::to('/') }}/images/accommodation/1.jpg" alt="">
                </a>
            </div>  <!-- 1 Image -->

            <div class="col-lg-6 col-md-4 col-xs-6 thumb mfp-with-zoom">
                <a class="image-popup-vertical-fit thumbnail" href="{{ URL::to('/') }}/images/accommodation/2.jpg" data-lightbox="Test" data-title="">
                    <img class="img-responsive" src="{{ URL::to('/') }}/images/accommodation/2.jpg" alt="">
                </a>
            </div>  <!-- 2 Image -->

            <div class="col-lg-6 col-md-4 col-xs-6 thumb mfp-with-zoom">
                <a class="thumbnail image-popup-vertical-fit" href="{{ URL::to('/') }}/images/accommodation/3.jpg" data-lightbox="Test" data-title="">
                    <img class="img-responsive" src="{{ URL::to('/') }}/images/accommodation/3.jpg" alt="">
                </a>
            </div>  <!-- 3 Image -->

            <div class="col-lg-6 col-md-4 col-xs-6 thumb mfp-with-zoom">
                <a class="thumbnail image-popup-vertical-fit" href="{{ URL::to('/') }}/images/accommodation/4.jpg" data-lightbox="Test" data-title="">
                    <img class="img-responsive" src="{{ URL::to('/') }}/images/accommodation/4.jpg" alt="">
                </a>
            </div>  <!-- 4 Image -->            
            <!-- Image Block 1 End -->

            <!-- Image Block 2 start -->
            <div class="col-lg-6 col-md-4 col-xs-6 thumb  mfp-with-zoom">
                <a class="thumbnail image-popup-vertical-fit" href="{{ URL::to('/') }}/images/accommodation/5.jpg" data-lightbox="Test" data-title="">
                    <img class="img-responsive" src="{{ URL::to('/') }}/images/accommodation/5.jpg" alt="">
                </a>
            </div>  <!-- 1 Image -->

            <div class="col-lg-6 col-md-4 col-xs-6 thumb  mfp-with-zoom">
                <a class="thumbnail image-popup-vertical-fit" href="{{ URL::to('/') }}/images/accommodation/6.jpg" data-lightbox="Test" data-title="">
                    <img class="img-responsive" src="{{ URL::to('/') }}/images/accommodation/6.jpg" alt="">
                </a>
            </div>  <!-- 2 Image -->

            <div class="col-lg-6 col-md-4 col-xs-6 thumb  mfp-with-zoom">
                <a class="thumbnail image-popup-vertical-fit" href="{{ URL::to('/') }}/images/accommodation/7.jpg" data-lightbox="Test" data-title="">
                    <img class="img-responsive" src="{{ URL::to('/') }}/images/accommodation/7.jpg" alt="">
                </a>
            </div>  <!-- 3 Image -->

            <div class="col-lg-6 col-md-4 col-xs-6 thumb  mfp-with-zoom">
                <a class="thumbnail image-popup-vertical-fit" href="{{ URL::to('/') }}/images/accommodation/8.jpg" data-lightbox="Test" data-title="">
                    <img class="img-responsive" src="{{ URL::to('/') }}/images/accommodation/8.jpg" alt="">
                </a>
            </div>  <!-- 4 Image -->
            <!-- Image Block 2 End -->

        </div>
        <!-- /.row -->
    </div>
</div>    
<!-- Tour Packages  Discription  end -->

<!-- Pagination 
<div class="container">
    <div class="row text-center">
        <div class="col-lg-12">
            <ul class="pagination">
                <li>
                    <a href="#">&laquo;</a>
                </li>
                <li class="active">
                    <a href="#">1</a>
                </li>
                <li>
                    <a href="#">2</a>
                </li>
                <li>
                    <a href="#">&raquo;</a>
                </li>
            </ul>
        </div>
    </div>
</div>-->
<!-- /.row -->






  
@include('footer')