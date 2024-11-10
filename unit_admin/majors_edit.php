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
                    <span>مرحبا بك</span>, <b>أحمد</b>
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
                                    <li class="breadcrumb-item">ادارة الشعب</li>
                                    <li class="breadcrumb-item active">تعديل</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <!-- end row -->

                <div class="row h-100">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                         <?php
                  
                                            if(isset($_POST['edit'])){


                                              $chances = $_POST['chances'];
                                              $level = $_POST['level']; 
                                              $term = $_POST['term'];  
                                              $year = $_POST['year']; 
                                              $major_id = $_POST['major_id']; 

                                              include('../connect.php');  
                                              $sql = $con->prepare("SELECT * FROM majors WHERE ((term='$term' AND year='$year') OR (term='$term' OR year='$year')) AND id !='$major_id'");      
                                              $sql->execute();
                                              $rowsVVV = $sql->fetch();
                                              $count=$sql->rowCount();
                                              if($count <= 0){


                                                  $stmt = $con->prepare("UPDATE majors SET  term = ? , year = ? , number_of_students = ? , academic_admin_id = ? WHERE id = ?");
                                                    $stmt->execute(array($term , $year , $chances , $level , $major_id));

                                                    echo '<div class="container" dir="rtl" style="margin-top:30px;color:#FFF;margin-bottom:30px;font-family:cairo">
                                                              <div class="alert alert-success role="alert" style="color:#FFF;text-align:center;margin-bottom:40px;font-family:cairo">
                                                                  تم تحديث بيانات الشعبة بنجاح
                                                              </div>
                                                          </div>';

                                              }else{


                                                  echo '<div class="container" dir="rtl" style="margin-top:30px;color:#FFF;margin-bottom:30px;font-family:cairo">
                                                        <div class="alert alert-danger role="alert" style="color:#FFF;text-align:center;margin-bottom:40px;font-family:cairo">
                                                            هذه البيانات موجودة من قبل
                                                        </div>
                                                    </div>';


                                              }


                                            }


                                        ?>
                                          <?php

                                            $major_id = isset($_GET['major_id']) && is_numeric($_GET['major_id']) ? intval($_GET['major_id']) : 0;

                                            include('../connect.php');
                                            $stmt = $con->prepare("SELECT * FROM majors WHERE id='$major_id'");  
                                            $stmt->execute();
                                            $rowsSpec = $stmt->fetch();
                                            $count = $stmt->rowCount();

                                          ?> 
                                        <form method="post" class="form">
                                            <input type="hidden" name="major_id" value="<?php echo $major_id; ?>"/>
                                            <div class="d-flex flex-column justify-content-around gap-4">
                                                

                                                <div>
                                                    <h4 class="form-label" for="chances">عدد طلاب الشعبة</h4>
                                                    <input  type="number" min="0" class="form-control" style="text-align: right" name="chances" id="chances" required
                                                            placeholder="أدخل عدد طلاب الشعبة" value="<?php echo $rowsSpec['number_of_students']; ?>">
                                                </div>

                                                <div>
                                                    <h4 class="form-label" for="term">الفصل الدراسي</h4>
                                                    <select name="term" id="term" style="text-align: right" class="form-control"
                                                        required>
                                                        <?php if($rowsSpec['term'] == "first"){ ?>
                                                        <option value="first" selected>الأول</option>
                                                        <option value="second">الثاني</option>
                                                        <?php  }elseif($rowsSpec['term'] == "second"){ ?>
                                                        <option value="first">الأول</option>
                                                        <option selected value="second">الثاني</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div>
                                                    <h4 class="form-label" for="name">العام الدراسي</h4>
                                                    <input  type="text" class="form-control" style="text-align: right" name="year" id="name" required
                                                            placeholder="أدخل العام الدراسي" value="<?php echo $rowsSpec['year']; ?>">
                                                </div>
                                                <div>
                                                    <h4 class="form-label" for="name">اسناد مشرف اكاديمي</h4>
                                                    <select type="number" onchange="" min="1" class="form-control text-start" id="level" name="level" required>
                                                        <option value="" disabled>-- اختر مشرف --</option>
                                                        <?php

                                                        include('../connect.php'); 
                                                        
                                                        $ad_id = $rowsSpec['academic_admin_id'];
                                                        
                                                        $sql1 = $con->prepare("SELECT * FROM academic_admins WHERE id='$ad_id'");      
                                                        $sql1->execute();
                                                        $rows1 = $sql1->fetch();
                                                        
                                                         ?>
                                                        
                                                        <option selected value="<?php echo $rows1['id']; ?>">م. <?php echo $rows1['name']; ?></option>
                                                        
                                                       <?php $sql = $con->prepare("SELECT * FROM academic_admins");      
                                                        $sql->execute();
                                                        $rows = $sql->fetchAll();

                                                        foreach($rows as $pat)
                                                        {
                                                            if($pat['id'] !== $ad_id){

                                                        ?> 
                                                        <option value="<?php echo $pat['id']; ?>">م. <?php echo $pat['name']; ?></option>
                                                        <?php }} ?>
                                                        
                                                    </select>
                                                </div>

                                                <div class="d-flex flex-wrap gap-3 mt-3">
                                                    <button type="submit" name="edit"
                                                            class="btn btn-success waves-effect waves-light w-md">
                                                        تعديل
                                                    </button>
                                                    <button type="reset"
                                                            class="btn btn-outline-danger waves-effect waves-light w-md">
                                                        إلغاء
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>


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