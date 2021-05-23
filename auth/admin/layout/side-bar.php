<div class="page-sidebar">
    <div class="main-header-left d-none d-lg-block">
        <div class="logo-wrapper"><a href="http://laravel.pixelstrap.com/endless"><img src="../../assets/images/endless-logo.png" alt=""></a></div>
    </div>
    <div class="sidebar custom-scrollbar">
        <div class="sidebar-user text-center">
            <h6 class="mt-3 f-14"><?=$_SESSION['auth']['name'] ?></h6>
            <p><?=$_SESSION['auth']['role'] ?></p>
        </div>
        <ul class="sidebar-menu">

            <li><a class="sidebar-header " href="index.php"><i data-feather="menu"></i><span>Dashboard</span></a></li>
            <li>
                <a class="sidebar-header" href="project-index.php" class="" >
                    <i data-feather="book"></i><span>Project Management</span>
                </a>
            </li>
            <li>
                <a class="sidebar-header" href="booking-index.php" class="" >
                    <i data-feather="book"></i><span>Booking Management</span>
                </a>
            </li>
            <li class="">
                <a class="sidebar-header" href="#"><i data-feather="home"></i><span>User Management</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li><a href="user-customer-index.php" class=""><i class="fa fa-circle"></i>Customer</a></li>
                    <li><a href="user-agent-index.php" class=""><i class="fa fa-circle"></i>Agent</a></li>
                    <li><a href="user-admin-index.php" class=""><i class="fa fa-circle"></i>Admin</a></li>
                </ul>
            </li>
            <li class="">
                <a class="sidebar-header" href="#"><i data-feather="home"></i><span>Voucher</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li><a href="voucher-index.php" class=""><i class="fa fa-circle"></i>Voucher</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>