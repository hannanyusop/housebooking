<div class="page-sidebar">
    <div class="main-header-left d-none d-lg-block">
        <div class="logo-wrapper"><a href="index.php"><img src="../../assets/images/endless-logo.png" alt=""></a></div>
    </div>
    <div class="sidebar custom-scrollbar">
        <div class="sidebar-user text-center">
            <div><img class="img-60 rounded-circle" src="../../assets/images/user/1.jpg" alt="#">
                <div class="profile-edit"><a href="edit-profile.html" target="_blank"><i data-feather="edit"></i></a></div>
            </div>
            <h6 class="mt-3 f-14"><?=$_SESSION['auth']['name'] ?></h6>
            <p><?=$_SESSION['auth']['role'] ?></p>
        </div>
        <ul class="sidebar-menu">

            <li><a class="sidebar-header " href="index.php"><i data-feather="home"></i><span>Dashboard</span></a></li>
            <li><a class="sidebar-header" href="project-index.php"><i data-feather="book"></i><span> Project List</span></a></li>
            <li><a class="sidebar-header " href="booking-index.php"><i data-feather="list"></i><span>Booking List</span></a></li>
        </ul>
    </div>
</div>