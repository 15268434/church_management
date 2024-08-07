<style>
  .user-img {
    position: absolute;
    height: 27px;
    width: 27px;
    object-fit: cover;
    left: -7%;
    top: -12%;
  }
  .btn-rounded {
    border-radius: 50px;
  }
</style>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark border border-light border-top-0 border-left-0 border-right-0 navbar-light text-sm" style="direction: rtl;">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?php echo base_url ?>" class="nav-link"><?php echo (!isMobileDevice()) ? $_settings->info('name'):$_settings->info('short_name'); ?> - المشرف</a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- User Dropdown Menu -->
    <li class="nav-item">
      <div class="btn-group nav-link">
        <button type="button" class="btn btn-rounded badge badge-light dropdown-toggle dropdown-icon" data-toggle="dropdown">
          <span><img src="<?php echo validate_image($_settings->userdata('avatar')) ?>" class="img-circle elevation-2 user-img" alt="صورة المستخدم"></span>
          <span class="ml-3"><?php echo ucwords($_settings->userdata('firstname').' '.$_settings->userdata('lastname')) ?></span>
          <span class="sr-only">تبديل القائمة المنسدلة</span>
        </button>
        <div class="dropdown-menu" role="menu">
          <a class="dropdown-item" href="<?php echo base_url.'admin/?page=user' ?>"><span class="fa fa-user"></span> حسابي</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?php echo base_url.'/classes/Login.php?f=logout' ?>"><span class="fas fa-sign-out-alt"></span> تسجيل الخروج</a>
        </div>
      </div>
    </li>
    <!-- End User Dropdown -->

    <!-- Control Sidebar Toggle Button -->
    <!-- <li class="nav-item">
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
        <i class="fas fa-th-large"></i>
      </a>
    </li> -->
    <!-- End Control Sidebar Toggle Button -->
  </ul>
</nav>
<!-- /.navbar -->
