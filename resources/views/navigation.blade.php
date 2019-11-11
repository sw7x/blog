
<!-- Headder Nav Bar start-->
<nav class="navbar navbar-default " role="navigation">
    <div class="container">

        <!-- logo div start-->
        <div class="navbar-header" >
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse" style="margin-top:30px;">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{route('index')}}"><img alt="" src="{{ URL::to('/') }}/images/core/logo.png" /></a>
        </div>
        <!-- logo div end-->
        <!-- Manu items start-->
        <div class="collapse navbar-collapse" id="collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{route('index')}}">Home</a></li>
                <li><a href="{{route('teen-and-summer-holidays')}}">Teen age summer holidays</a></li>
                <li><a href="{{route('packages.index')}}">Tour packages</a></li>
                <li><a href="{{route('destinations')}}">Destinations<a></li>
                <li><a href="{{route('accommodation')}}">Accommodation</a></li>
                <li><a href="{{route('gallery')}}">Honeymoon packages</a></li>
                <li><a href="{{route('contact.index')}}">Contact us</a></li>
            </ul>
        </div>
        <!-- Manu items end-->
    </div>
</nav>
<!-- Headder Nav Bar end  -->


