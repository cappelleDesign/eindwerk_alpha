<?php
$page = filter_var($_GET['page'], FILTER_SANITIZE_STRING);
?>
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="account">NEOLUDUS Admin</a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">                          
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="home"><i class="fa fa-home fa-fw"></i> Back to base site</a>                
                <li class="divider"></li>
                <li><a href="account/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="account" class="<?php echo strtolower($page) === 'dashboard' ? 'active' : '' ?>">
                        <i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                </li>
                <li>
                    <a href="admin/user-mgr" class="<?php echo strtolower($page) === 'user-mgr' ? 'active' : '' ?>">
                        <i class="fa fa-users fa-fw"></i> User mgr</a>
                </li>
                <li>
                    <a href="admin/review-mgr" class="<?php echo strtolower($page) === 'review-mgr' ? 'active' : '' ?>">
                        <i class="fa fa-newspaper-o fa-fw"></i> Review mgr</a>
                </li>
                 <li>
                    <a href="admin/avatar-mgr" class="<?php echo strtolower($page) === 'avatar-mgr' ? 'active' : '' ?>">
                        <i class="fa fa-image fa-fw"></i> Avatar mgr</a>
                </li>

                <!--                <li>
                                    <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Charts<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="flot.html">Flot Charts</a>
                                        </li>
                                        <li>
                                            <a href="morris.html">Morris.js Charts</a>
                                        </li>
                                    </ul>
                                     /.nav-second-level 
                                </li>-->                
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>