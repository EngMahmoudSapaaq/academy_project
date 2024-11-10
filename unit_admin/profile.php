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
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
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
                            <h4 class="mb-0">تعديل الملف الشخصي</h4>
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



                                          $email = $_POST['email']; 
                                          $phone = $_POST['phone']; 
                                          $username = $_POST['username'];  
                                          $admin_id = $_POST['admin_id'];   
                                            

                                          include('../connect.php');  
                                          $sql = $con->prepare("SELECT * FROM unit_admins WHERE ((email='$email' AND phone='$phone') OR (email='$email' OR phone='$phone')) AND id !='$admin_id'");      
                                          $sql->execute();
                                          $rowsVVV = $sql->fetch();
                                          $count=$sql->rowCount();
                                          if($count <= 0){


                                              if(!empty($_POST['password']) && !empty($_POST['confirm'])){
                                                  
                                                  if($_POST['password'] == $_POST['confirm']){
                                                      
                                                      $stmt = $con->prepare("UPDATE unit_admins SET email = ? , phone = ? WHERE id = ?");
                                                        $stmt->execute(array($email , $phone , $admin_id));
                                                      
                                                      $stmt1 = $con->prepare("UPDATE accounts SET username = ? , password = ? WHERE id = ?");
                                                        $stmt1->execute(array($username , $_POST['password'] , $id));

                                                        echo '<div class="container" dir="rtl" style="margin-top:30px;color:#FFF;margin-bottom:30px;font-family:cairo">
                                                                  <div class="alert alert-success role="alert" style="color:#FFF;text-align:center;margin-bottom:40px;font-family:cairo">
                                                                      تم تحديث ملفك الشخصي بنجاح
                                                                  </div>
                                                              </div>';

                                                  
                                                  }else{
                                                  
                                                      echo '<div class="container" dir="rtl" style="margin-top:30px;color:#FFF;margin-bottom:30px;font-family:cairo">
                                                                  <div class="alert alert-success role="alert" style="color:#FFF;text-align:center;margin-bottom:40px;font-family:cairo">
                                                                      كلمة المرور غير متطابقة
                                                                  </div>
                                                              </div>';
                                                  
                                                  
                                                  }

                                                
                                              }else{

                                                $stmt = $con->prepare("UPDATE unit_admins SET email = ? , phone = ? WHERE id = ?");
                                                $stmt->execute(array($email , $phone , $admin_id));

                                              $stmt1 = $con->prepare("UPDATE accounts SET username = ? WHERE id = ?");
                                                $stmt1->execute(array($username , $id));

                                                echo '<div class="container" dir="rtl" style="margin-top:30px;color:#FFF;margin-bottom:30px;font-family:cairo">
                                                          <div class="alert alert-success role="alert" style="color:#FFF;text-align:center;margin-bottom:40px;font-family:cairo">
                                                              تم تحديث ملفك الشخصي بنجاح
                                                          </div>
                                                      </div>';


                                              }


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

                                        include('../connect.php');
                                        $stmt = $con->prepare("SELECT * FROM unit_admins WHERE account_id='$id'");  
                                        $stmt->execute();
                                        $rowsSpec = $stmt->fetch();
                                        $count = $stmt->rowCount();
                                        
                                        
                                        $stmt1 = $con->prepare("SELECT * FROM accounts WHERE id='$id'");  
                                        $stmt1->execute();
                                        $rowsSpec1 = $stmt1->fetch();
                                        $count1 = $stmt1->rowCount();

                                      ?> 
                                        <form method="post" class="form">
                                            <input type="hidden" name="admin_id" value="<?php echo $rowsSpec['id']; ?>"/>
                                            <div class="d-flex flex-column justify-content-around gap-4">
                                                <div>
                                                    <h4 class="form-label" for="name">الاسم</h4>
                                                    <input  type="text" class="form-control" style="text-align: right" name="name" id="name" required
                                                            placeholder="" value="<?php echo $rowsSpec['name']; ?>" readonly>
                                                </div>

                                                <div>
                                                    <h4 class="form-label" for="email">البريد الالكتروني</h4>
                                                    <input  type="email" class="form-control" style="text-align: right" name="email" id="email" required
                                                            placeholder="أدخل البريد الالكتروني" value="<?php echo $rowsSpec['email']; ?>">
                                                </div>

                                                <div>
                                                    <h4 class="form-label" for="phone">رقم الهاتف</h4>
                                                    <input  pattern="(?:\+?0*?966)?0?5[0-9]{8}" title="Phone Must Start 05 And Contains 10 Numbers" type="text" class="form-control" style="text-align: right" name="phone" id="phone" required
                                                            placeholder="أدخل رقم الهاتف" value="<?php echo $rowsSpec['phone']; ?>">
                                                </div>

                                                <div>
                                                    <h4 class="form-label" for="phone">الجنس</h4>
                                                    <div class="form-control" id="gender-radio"
                                                        style="display: flex; flex-direction: row; justify-content: start; column-gap: 15px; text-align: right;">
                                                        <?php if($rowsSpec['gender'] == 'm'){ ?>
                                                        <label for="male" class="my-auto">
                                                            ذكر <i class="fa fa-mars fa-lg"></i>
                                                            <input type="radio" id="male" name="gender" checked disabled required>
                                                        </label>
                                                        <label for="female" class="my-auto">
                                                            انثى <i class="fa fa-venus fa-lg"></i>
                                                            <input type="radio" id="female" name="gender" disabled required>
                                                        </label>
                                                        <?php }else{ ?>
                                                        <label for="male" class="my-auto">
                                                            ذكر <i class="fa fa-mars fa-lg"></i>
                                                            <input type="radio" id="male" name="gender" disabled required>
                                                        </label>
                                                        <label for="female" class="my-auto">
                                                            انثى <i class="fa fa-venus fa-lg"></i>
                                                            <input type="radio" id="female" name="gender" checked disabled required>
                                                        </label>
                                                        <?php  } ?>
                                                    </div>
                                                </div>

                                                <div>
                                                    <h4 class="form-label" for="username">اسم المستخدم</h4>
                                                    <div class="row">
                                                        <div class="col-lg-1">
                                                            <span class="input-group-text" id="">@</span>
                                                        </div>
                                                        <div class="col-lg-11" style="margin-right:-25px">
                                                            <input pattern=".{3,}" title="يرجى إدخال 3 رموز على الأقل" type="text" class="form-control" style="text-align: right" name="username" id="username" required
                                                                placeholder="أدخل اسم المستخدم" value="<?php echo $rowsSpec1['username']; ?>">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div>
                                                    <h4 class="form-label" for="term">الفصل الدراسي</h4>
                                                    <select name="term" id="term" style="text-align: right" class="form-control" disabled
                                                        required>
                                                        <?php if($rowsSpec['term'] == 'first'){ ?>
                                                            <option value="first" selected>الأول</option>
                                                            <option value="second">الثاني</option>
                                                        <?php  }else{ ?>
                                                         <option value="first">الأول</option>
                                                         <option value="second" selected>الثاني</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div>
                                                    <h4 class="form-label" for="name">العام الدراسي</h4>
                                                    <input  type="text" class="form-control" style="text-align: right" name="name" id="name" required
                                                            placeholder="أدخل العام الدراسي" value="<?php echo $rowsSpec['year'];  ?>" readonly>
                                                </div>

                                                <div style="display: none;" id="password_container">
                                                    <div class="mb-4">
                                                        <h4 class="form-label"
                                                            for="password">كلمة المرور الجديدة</h4>
                                                        <small class="text-info">* ادخل فقط اذا اردت تعديل كلمة المرور (اختياري)</small>
                                                        <input pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="يجب أن تحتوي كلمة المرور علي الأقل علي حرف كبير وحرف صغير ورقم وعلي الأقل 8 حروف وأرقام" type="password" style="text-align: right" class="form-control"
                                                            id="password" name="password"
                                                            placeholder="أدخل كلمة المرور الجديدة">
                                                    </div>

                                                    <div>
                                                        <h4 class="form-label"
                                                            for="password_confirmation">تأكيد كلمة المرور الجديدة</h4>
                                                        <input  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="يجب أن تحتوي كلمة المرور علي الأقل علي حرف كبير وحرف صغير ورقم وعلي الأقل 8 حروف وأرقام" type="password" style="text-align: right" class="form-control"
                                                                id="password_confirmation" name="confirm"
                                                                placeholder="أعد إدخال كلمة المرور">
                                                    </div>
                                                </div>

                                                <div>
                                                    <a href="#" onclick="$('#password_container').fadeIn(); $(this).hide()">هل تريد تعديل كلمة المرور؟</a>
                                                </div>

                                                <div class="d-flex flex-wrap gap-3 mt-3">
                                                    <button name="edit" type="submit"
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
                <!-- End Form Layout -->

                <!-- Start Form Sizing -->

                <!-- End Form Sizing -->


                <!-- end row -->


                <!-- end row -->

            </div> <!-- container-fluid -->
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


<!-- Right Sidebar -->
<div class="right-bar">
    <div data-simplebar="init" class="h-100">
        <div class="simplebar-wrapper" style="margin: 0px;">
            <div class="simplebar-height-auto-observer-wrapper">
                <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask">
                <div class="simplebar-offset" style="right: -20px; bottom: 0px;">
                    <div class="simplebar-content-wrapper"
                         style="height: 100%; overflow: hidden scroll; padding-right: 20px; padding-bottom: 0px;">
                        <div class="simplebar-content" style="padding: 0px;">
                            <div class="rightbar-title d-flex align-items-center p-3">

                                <h5 class="m-0 me-2">Settings</h5>

                                <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                                    <i class="mdi mdi-close noti-icon"></i>
                                </a>
                            </div>

                            <!-- Settings -->
                            <hr class="m-0">

                            <div class="p-4">
                                <h6 class="mb-3">Layout</h6>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="layout" id="layout-vertical"
                                           value="vertical">
                                    <label class="form-check-label" for="layout-vertical">Vertical</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="layout" id="layout-horizontal"
                                           value="horizontal">
                                    <label class="form-check-label" for="layout-horizontal">Horizontal</label>
                                </div>

                                <h6 class="mt-4 mb-3 pt-2">Layout Mode</h6>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="layout-mode"
                                           id="layout-mode-light" value="light">
                                    <label class="form-check-label" for="layout-mode-light">Light</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="layout-mode"
                                           id="layout-mode-dark" value="dark">
                                    <label class="form-check-label" for="layout-mode-dark">Dark</label>
                                </div>

                                <h6 class="mt-4 mb-3 pt-2">Layout Width</h6>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="layout-width"
                                           id="layout-width-fuild" value="fuild"
                                           onchange="document.body.setAttribute('data-layout-size', 'fluid')">
                                    <label class="form-check-label" for="layout-width-fuild">Fluid</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="layout-width"
                                           id="layout-width-boxed" value="boxed"
                                           onchange="document.body.setAttribute('data-layout-size', 'boxed')">
                                    <label class="form-check-label" for="layout-width-boxed">Boxed</label>
                                </div>

                                <h6 class="mt-4 mb-3 pt-2">Layout Position</h6>

                                <h6 class="mt-4 mb-3 pt-2">Topbar Color</h6>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="topbar-color"
                                           id="topbar-color-light" value="light"
                                           onchange="document.body.setAttribute('data-topbar', 'light')">
                                    <label class="form-check-label" for="topbar-color-light">Light</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="topbar-color"
                                           id="topbar-color-dark" value="dark"
                                           onchange="document.body.setAttribute('data-topbar', 'dark')">
                                    <label class="form-check-label" for="topbar-color-dark">Dark</label>
                                </div>

                                <h6 class="mt-4 mb-3 pt-2 sidebar-setting">Sidebar Size</h6>

                                <div class="form-check sidebar-setting">
                                    <input class="form-check-input" type="radio" name="sidebar-size"
                                           id="sidebar-size-default" value="default"
                                           onchange="document.body.setAttribute('data-sidebar-size', 'lg')">
                                    <label class="form-check-label" for="sidebar-size-default">Default</label>
                                </div>
                                <div class="form-check sidebar-setting">
                                    <input class="form-check-input" type="radio" name="sidebar-size"
                                           id="sidebar-size-compact" value="compact"
                                           onchange="document.body.setAttribute('data-sidebar-size', 'small')">
                                    <label class="form-check-label" for="sidebar-size-compact">Compact</label>
                                </div>
                                <div class="form-check sidebar-setting">
                                    <input class="form-check-input" type="radio" name="sidebar-size"
                                           id="sidebar-size-small" value="small"
                                           onchange="document.body.setAttribute('data-sidebar-size', 'sm')">
                                    <label class="form-check-label" for="sidebar-size-small">Small (Icon View)</label>
                                </div>

                                <h6 class="mt-4 mb-3 pt-2 sidebar-setting">Sidebar Color</h6>

                                <div class="form-check sidebar-setting">
                                    <input class="form-check-input" type="radio" name="sidebar-color"
                                           id="sidebar-color-light" value="light"
                                           onchange="document.body.setAttribute('data-sidebar', 'light')">
                                    <label class="form-check-label" for="sidebar-color-light">Light</label>
                                </div>
                                <div class="form-check sidebar-setting">
                                    <input class="form-check-input" type="radio" name="sidebar-color"
                                           id="sidebar-color-dark" value="dark"
                                           onchange="document.body.setAttribute('data-sidebar', 'dark')">
                                    <label class="form-check-label" for="sidebar-color-dark">Dark</label>
                                </div>
                                <div class="form-check sidebar-setting">
                                    <input class="form-check-input" type="radio" name="sidebar-color"
                                           id="sidebar-color-colored" value="colored"
                                           onchange="document.body.setAttribute('data-sidebar', 'colored')">
                                    <label class="form-check-label" for="sidebar-color-colored">Colored</label>
                                </div>

                                <h6 class="mt-4 mb-3 pt-2">Direction</h6>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="layout-direction"
                                           id="layout-direction-ltr" value="ltr">
                                    <label class="form-check-label" for="layout-direction-ltr">LTR</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="layout-direction"
                                           id="layout-direction-rtl" value="rtl">
                                    <label class="form-check-label" for="layout-direction-rtl">RTL</label>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="simplebar-placeholder" style="width: auto; height: 817px;"></div>
        </div>
        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
            <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
        </div>
        <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
            <div class="simplebar-scrollbar"
                 style="height: 422px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
        </div>
    </div> <!-- end slimscroll-menu-->
</div>
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- JAVASCRIPT -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/metisMenu.min.js"></script>


<!-- apexcharts -->

<script src="js/dashboard.init.js"></script>

<!-- App js -->
<script src="js/app.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Name validation (at least 3 characters)
        $('#name').on('input', function () {
            let name = $(this).val();
            if (name.length < 3) {
                $(this).next('.error').remove();
                $(this).after('<span class="error" style="color:red;">يجب إدخال 3 حروف على الأقل</span>');
            } else {
                $(this).next('.error').remove();
            }
        });

        // Email validation (standard email format)
        $('#email').on('input', function () {
            let email = $(this).val();
            let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                $(this).next('.error').remove();
                $(this).after('<span class="error" style="color:red;">يرجى إدخال بريد إلكتروني صحيح</span>');
            } else {
                $(this).next('.error').remove();
            }
        });

        // Username validation (at least 3 characters)
        $('#username').on('input', function () {
            let username = $(this).val();
            if (username.length < 3) {
                $(this).next('.error').remove();
                $(this).after('<span class="error" style="color:red;">يجب إدخال 3 رموز على الأقل</span>');
            } else {
                $(this).next('.error').remove();
            }
        });

        // Phone validation (exactly 10 digits)
        $('#phone').on('input', function () {
            let phone = $(this).val();
            let phonePattern = /^\d{10}$/;
            if (!phonePattern.test(phone)) {
                $(this).next('.error').remove();
                $(this).after('<span class="error" style="color:red;">يجب أن يحتوي رقم الهاتف على 10 أرقام</span>');
            } else {
                $(this).next('.error').remove();
            }
        });

        // Civil ID validation (exactly 10 digits)
        $('#civil_id').on('input', function () {
            let civilId = $(this).val();
            let civilIdPattern = /^\d{10}$/;
            if (!civilIdPattern.test(civilId)) {
                $(this).next('.error').remove();
                $(this).after('<span class="error" style="color:red;">يجب أن يحتوي رقم السجل المدني على 10 أرقام</span>');
            } else {
                $(this).next('.error').remove();
            }
        });

        // Password validation (at least 8 characters, 1 uppercase, 1 lowercase, 1 number)
        $('#password').on('input', function () {
            let password = $(this).val();
            let passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
            if (!passwordPattern.test(password)) {
                $(this).next('.error').remove();
                $(this).after('<span class="error" style="color:red;">يجب أن تحتوي كلمة المرور على الأقل على 8 رموز، حرف كبير، حرف صغير، ورقم</span>');
            } else {
                $(this).next('.error').remove();
            }
        });

        // Password confirmation validation
        $('#password_confirmation').on('input', function () {
            let password = $('#password').val();
            let confirmPassword = $(this).val();
            if (confirmPassword !== password) {
                $(this).next('.error').remove();
                $(this).after('<span class="error" style="color:red;">كلمة المرور غير متطابقة</span>');
            } else {
                $(this).next('.error').remove();
            }
        });

        // Form submission validation
        $('form').on('submit', function (e) {
            if ($('.error').length > 0) {
                e.preventDefault();
                alert('يرجى تصحيح الأخطاء قبل الإرسال.');
            }
        });
    });
</script>


</body>
</html>