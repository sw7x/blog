<?php $bodyId = "Packages" ?>

@include('header')



<!-- header start -->
<header>
@include('navigation')
</header>
<!-- header end -->




    <div class="contact pages">
        <div class="contact container">
            <h1>{{$record['title']}}</h1>
        </div>
    </div>

  <!-- Tour Packages  Discription start -->
    <div class="con-itb pages">
    	<div class="con-itb container" >

            <!-- Project One -->
            <div class="row">
                <div class="tp col-md-7">
                    <a href="#">
                        <img class="img-responsive"  src="{{ URL::to('/storage/package_images') }}/{{$record['image']}}" alt="">
                    </a>
                </div>
                <div class="tp col-md-5">
                    <h3>{{$record['title']}}</h3>
                     <span> Duration:  <font > {{$record['duration']}} </font></span> <br><br>
                     <a class="tp btn btn-primary" href="#">From US${{$record['price']}}</a>
                </div>
            </div>

            <div class="row" style="padding-top:20px;">
                <div class="tp col-md-12">
                    <p>{{$record['discription']}}</p>

                    @if($record['highlights1'] != '' ||
                        $record['highlights2'] != '' ||
                        $record['highlights3'] != '' ||
                        $record['highlights4'] != '' ||
                        $record['highlights5'] != '')
                        <h3>Tour Highlights</h3>
                        <ul>
                            @if($record['highlights1'] != '')
                            <li>{{$record['highlights1']}}</li>
                            @endif

                            @if($record['highlights2'] != '')
                                <li>{{$record['highlights2']}}</li>
                            @endif

                            @if($record['highlights3'] != '')
                            <li>{{$record['highlights3']}}</li>
                            @endif

                            @if($record['highlights4'] != '')
                            <li>{{$record['highlights4']}}
                            @endif

                            @if($record['highlights5'] != '')
                                <li>{{$record['highlights5']}}</li>
                            @endif
                        </ul>
                    @endif
                </div>
            </div>

    	</div>
    </div>


<!-- Home Contend  end -->
@include('footer')
