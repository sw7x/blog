<!-- START X-NAVIGATION VERTICAL -->
<ul class="x-navigation x-navigation-horizontal x-navigation-panel">
    <!-- TOGGLE NAVIGATION -->
    <li class="xn-icon-button">
        <h4 style="margin:17px;">
            <a href='#' style="color: #000;display: block;text-decoration: none;">
                <strong>ADMIN PANEL <?php //var_dump (Auth::check()); ?></strong>
            </a>
        </h4>
    </li>

    <li class="xn-icon-button pull-right">
        <a href="#" class="mb-control" style="width: 150px;" data-box="#mb-signout">Sign-Out <span class="fa fa-sign-out"></span></a>
    </li>
    <!-- END SIGN OUT -->

    <!-- change password -->
    <li class="xn-icon-button pull-right" style="width: 150px;">
        <a href="#" class="mb-control" style="width: 150px;" data-box="#mb-change-pw" id="chngpwlink">Change Password<span class="fa fa-unlock" ></span></a>
    </li>
    <!-- change password -->

</ul>
<!-- END X-NAVIGATION VERTICAL -->

<!-- START BREADCRUMB -->
<ul class="breadcrumb">

</ul>
<!-- END BREADCRUMB -->





<!-- MESSAGE BOX-->
<div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
    <div class="mb-container">
        <div class="mb-middle">
            <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
            <div class="mb-content">
                <p>Are you sure you want to log out?</p>
                <p>Press No if you want to continue work. Press Yes to logout current user.</p>
            </div>
            <div class="mb-footer">
                <div class="pull-right">
                    <a href="{{route('admin.logout')}}" class="btn btn-success btn-lg" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Yes</a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <button class="btn btn-default btn-lg mb-control-close">No</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MESSAGE BOX-->






<!-- MESSAGE BOX-->
<div class="message-box animated" data-sound="" id="mb-change-pw" role="dialog">
    <div class="mb-container">
        <div class="mb-middle">
            <div class="mb-title">
                <span class="fa fa-unlock"></span> Change Admin Password
                <button class="btn btn-default btn-danger btn-sm" style="float: right" id="chngpwclose">X</button>
                <div class="clear"></div>
            </div>
            <div class="mb-content"  id="changePasswordStatus">
                <p></p>

            </div>

            <div class="mb-content">
                <form action="{{route('admin.change-password')}}" id="admin_change_password" method="post" name="" autocomplete="off">
                    <div class="form-group">
                        <label for="" style="float:left;padding:10px 0px;">Type Old Password<span></span></label><br/>
                        <input type="password" name="password_old" value="" id="passold" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="" style="float:left;padding:10px 0px;">Type New Password<span></span></label><br/>
                        <input type="password" name="password_new" value="" id="passnew" class="form-control">
                    </div>
                    

                    <div>
                        <div id="hint1" class="hint"></div>
                        <input class="btn btn-success formbuttons" style="float:left" name="change_password_submit" type="submit" value="Submit" id="asd">
                        <input class="btn btn-warning formbuttons" style="float:right" name="" type="reset" value="Reset" id="">
                        <div class="clear"></div>
                    </div>
                </form>
                <br/><br/><br/>
            </div>

<!--            <div class="mb-footer">-->
<!--                <div class="pull-right">-->
<!--                    <a href="logout.php" class="btn btn-success btn-lg">Yes</a>-->
<!--                    <button class="btn btn-default btn-lg mb-control-close">X</button>-->
<!--                </div>-->
<!--            </div>-->
        </div>
    </div>
</div>
<!-- END MESSAGE BOX-->

