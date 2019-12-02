<!-- Flash div start  -->
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

    @php 
        $sliderIndicator = 0;
        $sliderImgCount = 0;
    @endphp
    <!-- Indicators -->
    <ol class="carousel-indicators">
        @foreach($sliderImages as $img)
            @if($sliderIndicator == 0)
                @php($activeClass = 'active')
            @else
                @php($activeClass = '')
            @endif
            <li data-target="#carousel-example-generic" data-slide-to="{{$sliderIndicator}}" class="{{$activeClass}}"></li>
            @php($sliderIndicator++)
        @endforeach     

        <!-- 
        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
        <li data-target="#carousel-example-generic" data-slide-to="3"></li>
         -->
    </ol>
     
   

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        @foreach($sliderImages as $img)
            @if($sliderImgCount == 0)
                @php($activeClass = 'active')
            @else
                @php($activeClass = '')
            @endif
            <div class="item {{$activeClass}}" id="carousel_{{$sliderImgCount}}">
                <img src="{{ URL::to('/') }}/storage/{{$img->image}}" alt="...">
            </div>
            @php($sliderImgCount++)
        @endforeach

    <!-- 
    <div class="item"><img src="{{ URL::to('/') }}/images/flash/1.jpg" alt="..."></div>
    <div class="item"><img src="{{ URL::to('/') }}/images/flash/2.jpg" alt="..."></div>
    <div class="item"><img src="{{ URL::to('/') }}/images/flash/3.jpg" alt="..."></div>
    <div class="item"><img src="{{ URL::to('/') }}/images/flash/4.jpg" alt="..."></div>
    -->
    </div>
 
    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>

</div> <!-- Carousel -->
<!-- Flash div end  -->