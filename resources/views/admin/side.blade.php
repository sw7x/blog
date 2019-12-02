

        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top-fixed">

            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar page-sidebar-fixed scroll mCustomScrollbar _mCS_1 mCS-autoHide">
                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                    <li class="xn-logo">
                        <a href="#" class="x-navigation-control"></a>
                    </li>
                    <li class="xn-profile">
                        <a href="#" class="profile-mini">
                            <img src="{{ URL::to('/admin') }}/img/logo.png" alt=""/>
                        </a>
                        <div class="profile">
                            <div class="profile-image">
                                <img src="{{ URL::to('/admin') }}/img/tlogo.png" alt="John Doe" style="border-radius: 0%;background-color: #fff;width: 100%;"/>
                            </div>
                            <div class="profile-data">
                                <div class="profile-data-title">User Name</div>
                                <div class="profile-data-name">{{ Auth::user()->name }}</div>
                            </div>
                        </div>
                    </li>



                    <!-- {{Route::currentRouteName()}} -->  



                    <li class="{{ Route::is('admin.dashboard') ? 'active' : '' }}">
                        <a href="{{route('admin.dashboard')}}" class="sidebar_menu_item sidebar_link_highlight'>
                            <span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span>
                        </a>
                    </li>


                    <li class="{{ Route::is('admin.home-slider') ? 'active' : '' }}">
                        <a href="{{route('admin.home-slider')}}" class="sidebar_menu_item sidebar_link_highlight'>
                            <span class="fa fa-desktop"></span> <span class="xn-text">Home Slider</span>
                        </a>
                    </li>

                    <li class="{{ Route::is('admin.packages') ? 'active' : '' }}">
                        <a href="{{route('admin.packages')}}" class="sidebar_menu_item sidebar_link_highlight'>
                            <span class="fa fa-desktop"></span> <span class="xn-text">Tour Packages</span>
                        </a>
                    </li>

                    <!-- 

                    /*route('admin.destinations')*/
                    
                    
                    <li class="">
                        <a href="" class="sidebar_menu_item sidebar_link_highlight'>
                            <span class="fa fa-desktop"></span> <span class="xn-text">Destinations</span>
                        </a>
                    </li>

                    /*route('admin.hotels')*/
                    <li class="">
                        <a href="" class="sidebar_menu_item sidebar_link_highlight'>
                            <span class="fa fa-desktop"></span> <span class="xn-text">Accommodation (Hotels)</span>
                        </a>
                    </li>
                    -->

                    <li class="{{ Route::is('admin.contact') ? 'active' : '' }}">
                        <a href="{{route('admin.contact')}}" class="sidebar_menu_item sidebar_link_highlight'>
                            <span class="fa fa-desktop"></span> <span class="xn-text">Contact Form</span>
                        </a>
                    </li>                  


                </ul>
                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR -->
