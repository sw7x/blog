<?php $bodyId = "Packages" ?>

@include('header')



<!-- header start -->
<header>
@include('navigation')
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

		@foreach ($records as $key => $data)
	        <div class="row">
	            <div class="tp col-md-7">
                    <a href="{{route('packages.index')}}/{{$data->id}}">
	                    <img class="eeee img-responsive"  src="{{ URL::to('/storage/package_images') }}/{{$data->image}}" alt="">
	                </a>
	            </div>
	            <div class="tp col-md-5">
	               <a href="{{route('packages.index')}}/{{$data->id}}"> <h3>{{$data->title}}</h3></a>
					 <a class="tp btn btn-primary" href="#">From US${{$data->price}}</a>
	                <p>{{$data->discription}}</p>
	                <span> Duration:  <font >{{$data->duration}}</font></span> <br>
	                <a class="tprm btn btn-primary" href="{{route('packages.index')}}/{{$data->id}}">Read More</a>
	            </div>
	        </div>
        	<hr>
   		@endforeach

   		</div>
    </div>
    <!-- Tour Packages  Discription  end -->



    <!-- Pagination -->
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-12">

                @include('pagination.limit_links', ['paginator' => $records])

            </div>
        </div>
    </div>









@include('footer')
