<?php

session_start();
if(!(isset($_SESSION['password']))){
	header('Location:../login.php');
}

$id = $_SESSION['id'];

?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8"/>
    <title>وحدة التدريب التعاوني</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard" name="description"/>
    <meta content="Themesbrand" name="author"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="images/logo.jpeg">

    <!-- Bootstrap Css -->
    <link href="css/bootstrap-rtl.min.css" id="bootstrap-style" rel="stylesheet" type="text/css"/>
    <!-- Icons Css -->
    <link href="css/icons-rtl.min.css" rel="stylesheet" type="text/css"/>
    <!-- App Css-->
    <link href="css/app-rtl.min.css" id="app-style" rel="stylesheet" type="text/css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300&display=swap" rel="stylesheet">
    <style>
    *{
        font-family: 'IBM Plex Sans Arabic', sans-serif;
    }
    </style>
</head>

<body data-sidebar="dark" cz-shortcut-listen="true">

<!-- Begin page -->
<div id="layout-wrapper">

    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="../index.php" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="images/logo.png" alt="" height="22">
                                </span>
                        <span class="logo-lg">
                                    <img src="images/logo.png" alt="" height="20">
                                </span>
                    </a>

                    <a href="../index.php" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="images/logo.png" alt="" style="height: 60px;width: 60px" height="22">
                                </span>
                        <span class="logo-lg">
                                    <img src="images/logo.png" alt=""  height="20">
                                </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
                    <i class="fa fa-fw fa-bars"></i>
                </button>

                <!-- App Search-->
                <div class="ms-5 my-auto">
                    <?php

                        include('../connect.php');  
                        $sql1 = $con->prepare("SELECT * FROM unit_admins WHERE account_id='$id'");      
                        $sql1->execute();
                        $rows1 = $sql1->fetch();
                        

                    ?> 
                    <span>مرحبا بك</span>, <b><?php echo $rows1['name']; ?></b>
                </div>

            </div>

            <div class="d-flex">

                <!-- <div class="dropdown d-inline-block">
                    <button style="cursor: default" type="button" class="btn header-item waves-effect"  data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user" src="images/sa.png" alt="Header Avatar">
                    </button>
                </div> -->

                
                
                <div class="dropdown d-inline-block">
                    <button type="button" style="cursor: default" class="btn header-item" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        
                        <span  class="d-none d-xl-inline-block ms-1 fw-medium font-size-15">مشرف الوحدة</span>
                    </button>
                </div>

                <div class="dropdown d-inline-block">
                    <button type="button"  data-bs-toggle="modal" data-bs-target="#logout"
                            class="btn header-item waves-effect"
                            aria-haspopup="true" aria-expanded="false">
                        <span class="d-none d-xl-inline-block ms-1 fw-medium font-size-15 text-danger">تسجيل الخروج <i class="fas fa-sign-out-alt ms-1" style="scale: -1;"></i></span>
                    </button>
                </div>

            </div>
        </div>

    </header>
    <div class="modal fade" id="logout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تسجيل الخروج !</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    هل أنت متأكد من تسجيل الخروج ؟
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">تراجع</button>
                    <a href="../logout.php" type="button" class="btn btn-danger">تسجيل خروج</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ========== Left Sidebar Start ========== -->
    <div class="vertical-menu mm-active">

        <!-- LOGO -->
        <div class="navbar-brand-box">

            <div>
                <a href="../index.php" class="logo logo-light">
                <span class="logo-lg">
                    <img src="images/logo.png" style="display: block;
                        margin-left: auto;
                        margin-right: auto;
                        height: 100px;">
                </span>
                </a>
            </div>
        </div>

        <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
            <i class="fa fa-fw fa-bars"></i>
        </button>

        <div data-simplebar="init" class="sidebar-menu-scroll mm-show">
            <div class="simplebar-wrapper" style="margin: 0px;">
                <div class="simplebar-height-auto-observer-wrapper">
                    <div class="simplebar-height-auto-observer"></div>
                </div>
                <div class="simplebar-mask" style="margin-top: 30px">
                    <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                        <div class="simplebar-content-wrapper"
                             style="height: 100%; overflow: hidden; padding-right: 0px; padding-bottom: 0px;">
                            <div class="simplebar-content" style="padding: 0px;">

                                <!--- Sidemenu -->
                                <div id="sidebar-menu" class="mm-active">
                                    <!-- Left Menu Start -->
                                    <ul class="metismenu list-unstyled mm-show" id="side-menu">

                                        <li class="">
                                            <a href="home.php" class="active" aria-expanded="false">
                                                <i class="fas fa-home"></i>
                                                <span>الصفحة الرئيسية</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="unit_admins_create.php" class="active" aria-expanded="false">
                                                <i class="fas fa-user-plus"></i>
                                                <span>تعيين مشرف وحدة جديد</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="profile.php" class="active" aria-expanded="false">
                                                <i class="fas fa-user-edit"></i>
                                                <span>تعديل الملف الشخصي</span>
                                            </a>
                                        </li>

                                        <li class="">
                                            <a href="#" class="active">
                                                <small class="text-muted">الادارة</small>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="index.php" class="active" aria-expanded="false">
                                                <i class="fas fa-file-alt"></i>
                                                <span>ادارة الشعب</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="training_agencies.php" class="active" aria-expanded="false">
                                                <i class="fas fa-university"></i>
                                                <span>ادارة الجهات التدريبية</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="academic_admins.php" class="active" aria-expanded="false">
                                                <i class="fas fa-user-tie"></i>
                                                <span>ادارة المشرفين الأكاديميين</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="training_admins.php" class="active" aria-expanded="false">
                                                <i class="fas fa-user-tie"></i>
                                                <span>ادارة المشرفين الميدانيين</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="students.php" class="active" aria-expanded="false">
                                                <i class="fas fa-user-graduate"></i>
                                                <span>معالجة طلبات الطلاب</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="student_mang.php" class="active" aria-expanded="false">
                                                <i class="fas fa-users"></i>
                                                <span>ادارة الطلاب</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="desires.php" class="active" aria-expanded="false">
                                                <i class="fas fa-list-ul"></i>
                                                <span>ادارة رغبات الطلاب</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="active">
                                                <small class="text-muted">التقارير</small>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="students_report.php" class="active" aria-expanded="false">
                                                <i class="fas fa-chart-pie"></i>
                                                <span>تقرير المتدربين</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="training_agencies_report.php" class="active" aria-expanded="false">
                                                <i class="fas fa-chart-pie"></i>
                                                <span>تقرير الجهات التدريبية</span>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                                <!-- Sidebar -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="simplebar-placeholder" style="width: auto; height: 169px;"></div>
            </div>
            <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
            </div>
            <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                <div class="simplebar-scrollbar"
                     style="height: 519px; transform: translate3d(0px, 0px, 0px); display: none;"></div>
            </div>
        </div>
    </div>
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item active">ادارة الجهات التدريبية</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <!-- end row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h4 class="card-title">كل الجهات التدريبية</h4>
                                    <div>
                                        <a href="training_agencies_create.php" class="btn btn-success"><i class="fa fa-plus"></i> اضافة جهة تدريبية</a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap mb-0">
                                        <thead class="table-light">
                                        <tr>
                                            <th>رقم الجهة</th>
                                            <th>الاسم</th>
                                            <th>البريد الالكتروني</th>
                                            <th>رقم الهاتف</th>
                                            <th>العنوان</th>
                                            <th>عدد الفرص</th>
                                            <th>إجراء</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                        include('../connect.php');  
                                        $sql = $con->prepare("SELECT * FROM training_agencies");      
                                        $sql->execute();
                                        $rows = $sql->fetchAll();

                                        foreach($rows as $pat)
                                        {

                                        ?>      
                                        <tr>
                                            <td><?php echo $pat['id']; ?></td>
                                            <td><?php echo $pat['name']; ?></td>
                                            <td><?php echo $pat['email']; ?></td>
                                            <td><?php echo $pat['phone']; ?></td>
                                            <td><?php echo $pat['address']; ?></td>
                                            <td><?php echo $pat['max_chances']; ?></td>
                                            <td>
                                                <a href="training_agencies_edit.php?agency_id=<?php echo $pat['id']; ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                                <a onclick="return confirm('هل أنت متأكد من عملية الحذف ؟');" href="delete_agency.php?agency_id=<?php echo $pat['id']; ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php } ?>    
                                        
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table-responsive -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div>
        </div>
        <!-- End Page-content -->


        <footer class="footer">
           <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        2024 © وحدة التدريب التعاوني.
                    </div>
                </div>
            </div>
        </footer> 
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->


<!-- JAVASCRIPT -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/metisMenu.min.js"></script>


<script src="js/dashboard.init.js"></script>

<!-- App js -->
<script src="js/app.js"></script>

</body>
</html>