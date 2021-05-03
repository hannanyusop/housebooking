<div class="page-sidebar">
    <div class="main-header-left d-none d-lg-block">
        <div class="logo-wrapper"><a href="http://laravel.pixelstrap.com/endless"><img src="../../assets/images/logo.png" alt="" style="max-width: 200px"></a></div>
    </div>
    <div class="sidebar custom-scrollbar">
        <div class="sidebar-user text-center">
            <div>
                <div class="profile-edit"><a href="edit-profile.html" target="_blank"><i data-feather="edit"></i></a></div>
            </div>
            <h6 class="mt-3 f-14"><?=$_SESSION['auth']['name'] ?></h6>
            <p><?=$_SESSION['auth']['role'] ?></p>
        </div>
        <ul class="sidebar-menu">

            <li><a class="sidebar-header " href="index.php"><i data-feather="menu"></i><span>Dashboard</span></a></li>
            <li><a class="sidebar-header " href="project-index.php"><i data-feather="briefcase"></i><span>Project</span></a></li>
            <li class="">
                <a class="sidebar-header" href="#"><i data-feather="home"></i><span>Booking</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li><a href="#" class=""><i class="fa fa-circle"></i>New Booking</a></li>
                    <li><a href="#" class=""><i class="fa fa-circle"></i>View</a></li>
                </ul>
            </li>

            <li><a class="sidebar-header" href="#" class="" target="_blank"><i data-feather="book"></i><span> Simple Menu</span></a></li>
        </ul>
    </div>
</div>