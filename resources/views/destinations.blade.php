<?php $bodyId = "Destinations" ?>

@include('header')



<!-- header start -->
<header>
@include('navigation')<!-- Headder Nav Bar End-->

</header>
<!-- header end -->



<!-- Destination headder  div start -->


<div class="contact pages">
    <div class="contact container">
        <h1>Destinations</h1>
    </div>
</div>
<!-- Destination headder div end -->
<!-- Destination Discription start -->
<div class="con-itb pages">
    <div class="con-itb container" >

        <!-- Project One -->
        <div class="row">
            <div class="col-md-7">
                <a href="#">
                    <img class="img-responsive" src="{{ URL::to('/') }}/images/destinations/1.jpg" alt="">
                </a>
            </div>
            <div class="col-md-5">
                <h3>Colombo, Sri Lanka</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium veniam exercitationem expedita laborum at voluptate. Labore, voluptates totam at aut nemo deserunt rem magni pariatur quos perspiciatis atque eveniet unde.</p>
                <a class="btn btn-primary" href="#">Read More</a>
            </div>
        </div>
        <!-- /.row -->

        <hr>
        <!-- Project Two -->
        <div class="row">
            <div class="col-md-7">
                <a href="#">
                    <img class="img-responsive" src="{{ URL::to('/') }}/images/destinations/2.jpg" alt="">
                </a>
            </div>
            <div class="col-md-5">
                <h3>Anuradhapura, Sri Lanka</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut, odit velit cumque vero doloremque repellendus distinctio maiores rem expedita a nam vitae modi quidem similique ducimus! Velit, esse totam tempore.</p>
                <a class="btn btn-primary" href="#">Read More</a>
            </div>
        </div>
        <!-- /.row -->

        <hr>

        <!-- Project Three -->
        <div class="row">
            <div class="col-md-7">
                <a href="#">
                    <img class="img-responsive" src="{{ URL::to('/') }}/images/destinations/3.jpg" alt="">
                </a>
            </div>
            <div class="col-md-5">
                <h3>Sigiriya, Sri Lanka</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut, odit velit cumque vero doloremque repellendus distinctio maiores rem expedita a nam vitae modi quidem similique ducimus! Velit, esse totam tempore.</p>
                <a class="btn btn-primary" href="#">Read More</a>
            </div>
        </div>
        <!-- /.row -->

        <hr>

        <!-- Project Four -->
        <div class="row">

            <div class="col-md-7">
                <a href="#">
                    <img class="img-responsive" src="{{ URL::to('/') }}/images/destinations/4.jpg" alt="">
                </a>
            </div>
            <div class="col-md-5">
                <h3>Polonnaruwa, Sri Lanka</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut, odit velit cumque vero doloremque repellendus distinctio maiores rem expedita a nam vitae modi quidem similique ducimus! Velit, esse totam tempore.</p>
                <a class="btn btn-primary" href="#">Read More</a>
            </div>
        </div>
        <!-- /.row -->

        <hr>

        <!-- Project Five -->
        <div class="row">
            <div class="col-md-7">
                <a href="#">
                    <img class="img-responsive" src="{{ URL::to('/') }}/images/destinations/5.jpg" alt="">
                </a>
            </div>
            <div class="col-md-5">
                <h3>Dambulla Cave Temple, Sri Lanka</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut, odit velit cumque vero doloremque repellendus distinctio maiores rem expedita a nam vitae modi quidem similique ducimus! Velit, esse totam tempore.</p>
                <a class="btn btn-primary" href="#">Read More</a>
            </div>
        </div>
        <!-- /.row -->
        <hr>

        <!-- Project six -->
        <div class="row">

            <div class="col-md-7">
                <a href="#">
                    <img class="img-responsive" src="{{ URL::to('/') }}/images/destinations/6.jpg" alt="">
                </a>
            </div>
            <div class="col-md-5">
                <h3>Kandy, Sri Lanka</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut, odit velit cumque vero doloremque repellendus distinctio maiores rem expedita a nam vitae modi quidem similique ducimus! Velit, esse totam tempore.</p>
                <a class="btn btn-primary" href="#">Read More</a>
            </div>
        </div>
        <!-- /.row -->

        <hr>

        <!-- Project Seven -->
        <div class="row">

            <div class="col-md-7">
                <a href="#">
                    <img class="img-responsive" src="{{ URL::to('/') }}/images/destinations/7.jpg" alt="">
                </a>
            </div>
            <div class="col-md-5">
                <h3>Nuwara Eliya – The City of Lights</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut, odit velit cumque vero doloremque repellendus distinctio maiores rem expedita a nam vitae modi quidem similique ducimus! Velit, esse totam tempore.</p>
                <a class="btn btn-primary" href="#">Read More</a>
            </div>
        </div>
        <!-- /.row -->

        <hr>

        <!-- Project eight -->
        <div class="row">

            <div class="col-md-7">
                <a href="#">
                    <img class="img-responsive" src="{{ URL::to('/') }}/images/destinations/8.jpg" alt="">
                </a>
            </div>
            <div class="col-md-5">
                <h3>Sinharaja Forest Reserve, Sri Lanka</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut, odit velit cumque vero doloremque repellendus distinctio maiores rem expedita a nam vitae modi quidem similique ducimus! Velit, esse totam tempore.</p>
                <a class="btn btn-primary" href="#">Read More</a>
            </div>
        </div>
        <!-- /.row -->



    </div>
</div>
<!-- Destination Discription  end -->

<!-- Pagination
<div class="container">
    <div class="row text-center">
        <div class="col-lg-12">
            <ul class="pagination">
                <li>
                    <a href="#">&laquo;</a>
                </li>
                <li class="active">
                    <a href="destinations.php">1</a>
                </li>
                <li>
                    <a href="destinations-2.php">2</a>
                </li>
                <li>
                    <a href="#">&raquo;</a>
                </li>
            </ul>
        </div>
    </div>
</div> -->
<!-- /.row -->







  
@include('footer')
