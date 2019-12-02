<?php
$page ='admin.home-slider';
?>


@include('admin.header')

@include('admin.side')

    <!-- PAGE CONTENT -->
    <div class="page-content">

        @include('admin.navigation')


        <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">
            <div class="_container bcol-md-12 clearfix">
                
                <div class="" style="padding-left: 20px">
                    <h1 style="text-transform: uppercase">Home Page Slider</h1>
                </div>

                <div class="table-responsive">
                    <div id="homeSliderTableContainer"></div> 
                </div>       



            </div>
        </div>
        <!-- END PAGE CONTENT WRAPPER -->



    </div>
    <!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->


@include('admin.footer')
