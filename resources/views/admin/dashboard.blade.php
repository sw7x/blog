<?php
$page ='admin.dashboard';
?>

@include('admin.header')

@include('admin.side')

    <!-- PAGE CONTENT -->
    <div class="page-content">

        @include('admin.navigation')

        <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">
            <div class="_container col-md-12">
                <h1 style="text-transform: uppercase">Dashboard</h1>

                <div class="table-responsive">
                    <?php //var_dump (session()->all()); ?>
                    <table class="table table-hover table-bordered" style="font-size: 14px;color:#000;font-weight: bold;">
                        <tr>
                            <th style="background-color:#d6dfe6">Entity</th>
                            <th style="background-color:#d6dfe6">Rows</th>
                        </tr>
                        <tr>
                            <td>Home Slider</td>
                            <td>{{$data['homeSlider']}}</td>
                        </tr>
                        <tr>
                            <td>Tour Packages</td>
                             <td>{{$data['package']}}</td>
                        </tr>
                        <tr>
                            <td>Inquiries</td>
                            <td>{{$data['inquiry']}}</td>
                        </tr>
                         
                    </table>

                </div>

            </div>
        </div>
        <!-- END PAGE CONTENT WRAPPER -->
    </div>
    <!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->

@include('admin.footer')
