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
                                    <li class="breadcrumb-item">ادارة المشرفين الأكاديميين</li>
                                    <li class="breadcrumb-item active">اضافة</li>
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
if(isset($_POST['add'])){
    $name = $_POST['name'];
    $email = $_POST['email']; 
    $phone = $_POST['phone'];
    $password = $_POST['password']; 
    $confirm = $_POST['confirm'];     
    $username = $_POST['username'];
    $gender = $_POST['gender']; 

    if($password == $confirm){  
        include('../connect.php');  
        
        // التحقق من عدم تكرار البريد الإلكتروني أو اسم المستخدم أو رقم الهاتف
        $checkStmt = $con->prepare("SELECT * FROM academic_admins 
                                    JOIN accounts ON academic_admins.account_id = accounts.id
                                    WHERE academic_admins.email = :email 
                                    OR academic_admins.phone = :phone 
                                    OR accounts.username = :username");
        $checkStmt->execute([
            ':email' => $email,
            ':phone' => $phone,
            ':username' => $username
        ]);
        
        if($checkStmt->rowCount() > 0){ 
            // إذا كانت هناك نتائج، عرض رسالة خطأ
            echo '
                <div class="container" dir="rtl" style="margin-top:80px;color:#000">
                    <div class="alert alert-danger" role="alert" style="color:#000">
                        البريد الإلكتروني، أو اسم المستخدم، أو رقم الهاتف مسجل مسبقاً.
                    </div>
                </div>';
        } else {
            // إذا لم يكن هناك تكرار، متابعة الإضافة
            // إدخال البيانات في جدول accounts
            $sql = "INSERT INTO accounts (username, password, status, type) VALUES (:username, :password, 'activated', 'academic_supervisor')";
            $insertAccount = $con->prepare($sql);
            $insertAccount->execute([':username' => $username, ':password' => $password]);
            
            // الحصول على آخر id تم إضافته في جدول accounts
            $accountId = $con->lastInsertId();

            // إدخال البيانات في جدول academic_admins
            $sql1 = "INSERT INTO academic_admins (name, email, phone, gender, account_id) VALUES (:name, :email, :phone, :gender, :account_id)";
            $insertAdmin = $con->prepare($sql1);
            $insertAdmin->execute([
                ':name' => $name,
                ':email' => $email,
                ':phone' => $phone,
                ':gender' => $gender,
                ':account_id' => $accountId
            ]);

            echo '
                <div class="container" dir="rtl" style="margin-top:80px;color:#000">
                    <div class="alert alert-success" role="alert" style="color:#000">
                        تم اضافة المشرف الاكاديمي بنجاح
                    </div>
                </div>';
        }
    } else {
        // إذا لم تتطابق كلمة المرور
        echo '
            <div class="container" dir="rtl" style="margin-top:80px;color:#000">
                <div class="alert alert-danger" role="alert" style="color:#000">
                    كلمة المرور غير متطابقة
                </div>
            </div>';
    }
}
?>

                                        <form method="post" class="form">
                                            <div class="d-flex flex-column justify-content-around gap-4">

                                                <div>
                                                    <h4 class="form-label" for="email">الاسم</h4>
                                                    <input  type="text" class="form-control" style="text-align: right" name="name" id="name" required
                                                            placeholder="أدخل الاسم" value="">
                                                </div>

                                                <div>
                                                    <h4 class="form-label" for="email">البريد الالكتروني</h4>
                                                    <input  type="email" class="form-control" style="text-align: right" name="email" id="email" required
                                                            placeholder="أدخل البريد الالكتروني" value="">
                                                </div>

                                              <div>
                                                    <h4 class="form-label" for="phone">رقم الهاتف</h4>
                                                    <input type="text" class="form-control" style="text-align: right" name="phone" id="phone" required
                                                           placeholder="أدخل رقم الهاتف">
                                                    <div id="phone-error" style="color:red;"></div> <!-- عنصر عرض خطأ الهاتف -->
                                                </div>

                                                <div>
                                                    <h4 class="form-label" for="phone">الجنس</h4>
                                                    <div class="form-control" id="gender-radio"
                                                        style="display: flex; flex-direction: row; justify-content: start; column-gap: 15px; text-align: right;">
                                                        <label for="male" class="my-auto">
                                                            ذكر <i class="fa fa-mars fa-lg"></i>
                                                            <input type="radio" id="male" value="m" name="gender" required>
                                                        </label>
                                                        <label for="female" class="my-auto">
                                                            انثى <i class="fa fa-venus fa-lg"></i>
                                                            <input type="radio" id="female" value="f" name="gender" required>
                                                        </label>
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
                                                                placeholder="أدخل اسم المستخدم">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <h4 class="form-label"
                                                        for="password">كلمة المرور</h4>
                                                    <input pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="يجب أن تحتوي كلمة المرور علي الأقل علي حرف كبير وحرف صغير ورقم وعلي الأقل 8 حروف وأرقام" type="password" style="text-align: right" class="form-control"
                                                           id="password" name="password" required
                                                           placeholder=" أدخل كلمة المرور">
                                                </div>

                                                <div>
                                                    <h4 class="form-label"
                                                        for="password_confirmation">تأكيد كلمة المرور</h4>
                                                    <input pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="يجب أن تحتوي كلمة المرور علي الأقل علي حرف كبير وحرف صغير ورقم وعلي الأقل 8 حروف وأرقام" type="password" style="text-align: right" class="form-control"
                                                            id="password_confirmation" required name="confirm"
                                                            placeholder="أعد إدخال كلمة المرور">
                                                </div>

                                                <div class="d-flex flex-wrap gap-3 mt-3">
                                                    <button type="submit" name="add"
                                                            class="btn btn-success waves-effect waves-light w-md">
                                                        اضافة
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

        // Phone validation (starts with 05 and has 10 digits)
        $('#phone').on('input', function () {
            let phone = $(this).val();
            let phonePattern = /^05\d{8}$/; // تحقق من أن الرقم يبدأ بـ 05 ويتكون من 10 أرقام
            if (!phonePattern.test(phone)) {
                $('#phone-error').text('يجب أن يحتوي رقم الهاتف على 10 أرقام ويبدأ بـ 05').css('color', 'red');
            } else {
                $('#phone-error').text('');
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
            // Check for errors in all fields
            if ($('.error').length > 0 || $('#phone-error').text().length > 0) {
                e.preventDefault();
                alert('يرجى تصحيح الأخطاء قبل الإرسال.');
            }
        });
    });
</script>



</body>
</html>