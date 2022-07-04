<?php
  include_once '../controller/DashboardController.php';
  include_once '../controller/RoleValidation.php';
?>
<div class="wrapper">

  <!-- Preloader -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="../dist/img/mpp.png" alt="AdminLTELogo" height="60" width="60">
  </div> -->

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Dashboard</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar logoutt -->
      <li class="nav-item">
        <a class="nav-link" href="../controller/Logout.php" role="button">
          <i class="fas fa-sign-out-alt"></i>
        </a>
        <div class="navbar-search-block">
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #192543">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="../view/dist/img/mpp.png" alt="AdminLTE Logo" class="brand-image elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-bold">Student4U</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block"><?php echo 'Hi, '.$curr_user['user_name']; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-header">MENU</li>
          <li class="nav-item">
            <a href="index.php" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Student Complaints
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="complaint_view.php?mode=1" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Complaints</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="complaint_view.php?mode=2" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pending Complaints</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="complaint_view.php?mode=3" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Complaints History</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="complaint_view.php?mode=4" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Approved Complaints</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="complaint_view.php?mode=5" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Rejected Complaints</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-paperclip"></i>
              <p>
                Paperwork Submission
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="paperwork_view.php?mode=1" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Submissions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="paperwork_view.php?mode=2" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pending Submissions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="paperwork_view.php?mode=3" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Submission History</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="paperwork_view.php?mode=4" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Approved Submissions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="paperwork_view.php?mode=5" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Rejected Submissions</p>
                </a>
              </li>
            </ul>
          </li>

                <li class="nav-header">CLUB</li>
                <li class="nav-item">
                  <a href="club_view.php" class="nav-link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>Club List</p>
                  </a>
                </li>
                <?php 
          
                  if($role == 2) {
                    ?>
                <li class="nav-header">USER MANAGEMENT</li>
                <li class="nav-item">
                  <a href="student_view.php" class="nav-link">
                    <i class="fas fa-graduation-cap nav-icon"></i>
                    <p>Student List</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="mpp_create.php" class="nav-link">
                    <i class="fas fa-address-card nav-icon"></i>
                    <p>Register MPP Member</p>
                  </a>
                </li>

              <?php
            }

          ?>
          <li class="nav-header">SETTING</li>
          <li class="nav-item">
            <a href="user_edit.php" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>User Setting</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="feedback.php" class="nav-link">
              <i class="nav-icon fas fa-comment-alt"></i>
              <p>Help and Feedback</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <!-- <div class="content-wrapper"> -->
    <!-- Content Header (Page header) -->
    <!-- <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <!-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div>
        </div> -->
    <!-- </div>
  </div> --> 
    <!-- /.content-header -->


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
</body>
</html>
