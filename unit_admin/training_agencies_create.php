<?php
session_start();
if (!(isset($_SESSION['password']))) {
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
    <link rel="shortcut icon" href="images/logo.jpeg">
    <link href="css/bootstrap-rtl.min.css" id="bootstrap-style" rel="stylesheet" type="text/css"/>
    <link href="css/icons-rtl.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/app-rtl.min.css" id="app-style" rel="stylesheet" type="text/css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'IBM Plex Sans Arabic', sans-serif;
        }
    </style>
</head>

<body data-sidebar="dark">

<!-- Begin page -->
<div id="layout-wrapper">

    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <div class="navbar-brand-box">
                    <a href="../index.php" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="images/logo.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="images/logo.png" alt="" height="20">
                        </span>
                    </a>
                </div>
                <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
                    <i class="fa fa-fw fa-bars"></i>
                </button>

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
                <div class="dropdown d-inline-block">
                    <button type="button" style="cursor: default" class="btn header-item" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-none d-xl-inline-block ms-1 fw-medium font-size-15">مشرف الوحدة</span>
                    </button>
                </div>

                <div class="dropdown d-inline-block">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#logout"
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

    <div class="vertical-menu mm-active">
        <div class="navbar-brand-box">
            <div>
                <a href="../index.php" class="logo logo-light">
                    <span class="logo-lg">
                        <img src="images/logo.png" style="display: block; margin-left: auto; margin-right: auto; height: 100px;">
                    </span>
                </a>
            </div>
        </div>

        <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
            <i class="fa fa-fw fa-bars"></i>
        </button>

        <div data-simplebar="init" class="sidebar-menu-scroll mm-show">
            <div class="simplebar-wrapper" style="margin: 0px;">
                <div class="simplebar-mask" style="margin-top: 30px">
                    <div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden;">
                        <div class="simplebar-content" style="padding: 0px;">
                            <div id="sidebar-menu" class="mm-active">
                                <ul class="metismenu list-unstyled mm-show" id="side-menu">
                                    <li><a href="home.php" class="active" aria-expanded="false"><i class="fas fa-home"></i><span>الصفحة الرئيسية</span></a></li>
                                    <li><a href="unit_admins_create.php" class="active" aria-expanded="false"><i class="fas fa-user-plus"></i><span>تعيين مشرف وحدة جديد</span></a></li>
                                    <li><a href="profile.php" class="active" aria-expanded="false"><i class="fas fa-user-edit"></i><span>تعديل الملف الشخصي</span></a></li>
                                    <li><a href="index.php" class="active" aria-expanded="false"><i class="fas fa-file-alt"></i><span>ادارة الشعب</span></a></li>
                                    <li><a href="training_agencies.php" class="active" aria-expanded="false"><i class="fas fa-university"></i><span>ادارة الجهات التدريبية</span></a></li>
                                    <li><a href="academic_admins.php" class="active" aria-expanded="false"><i class="fas fa-user-tie"></i><span>ادارة المشرفين الأكاديميين</span></a></li>
                                    <li><a href="training_admins.php" class="active" aria-expanded="false"><i class="fas fa-user-tie"></i><span>ادارة المشرفين الميدانيين</span></a></li>
                                    <li><a href="students.php" class="active" aria-expanded="false"><i class="fas fa-user-graduate"></i><span>معالجة طلبات الطلاب</span></a></li>
                                    <li><a href="student_mang.php" class="active" aria-expanded="false"><i class="fas fa-users"></i><span>ادارة الطلاب</span></a></li>
                                    <li><a href="desires.php" class="active" aria-expanded="false"><i class="fas fa-list-ul"></i><span>ادارة رغبات الطلاب</span></a></li>
                                    <li><a href="students_report.php" class="active" aria-expanded="false"><i class="fas fa-chart-pie"></i><span>تقرير المتدربين</span></a></li>
                                    <li><a href="training_agencies_report.php" class="active" aria-expanded="false"><i class="fas fa-chart-pie"></i><span>تقرير الجهات التدريبية</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item">ادارة الجهات التدريبية</li>
                                    <li class="breadcrumb-item active">اضافة</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row h-100">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <?php
                                        if (isset($_POST['add'])) {
                                            $chances = $_POST['chances'];
                                            $name = $_POST['name'];
                                            $phone = $_POST['phone'];
                                            $email = $_POST['email'];
                                            $address = $_POST['address'];
                                            $term = $_POST['term'];
                                            $conditions = $_POST['conditions']; // إضافة متغير الشروط

                                            include('../connect.php');

                                            // التحقق من عدم تكرار البريد الإلكتروني أو الهاتف في جدول training_agencies
                                            $sqlPL = $con->prepare("SELECT * FROM training_agencies WHERE email = ? OR phone = ?");
                                            $sqlPL->execute([$email, $phone]);
                                            $countPL = $sqlPL->rowCount();

                                            if ($countPL > 0) {
                                                echo '
                                                    <div class="container" dir="rtl" style="margin-top:80px;color:#000">
                                                        <div class="alert alert-danger" role="alert" style="color:#000">
                                                            هذه الجهة موجودة من قبل
                                                        </div>
                                                    </div>';
                                            } else {
                                                // إدخال بيانات الجهة التدريبية الجديدة
                                                $sql = "INSERT INTO training_agencies (name, email, phone, address, max_chances, type, conditions) VALUES (?, ?, ?, ?, ?, ?, ?)"; // تحديث الاستعلام
                                                $stmt = $con->prepare($sql);
                                                $stmt->execute([$name, $email, $phone, $address, $chances, $term, $conditions]); // إضافة الشروط هنا

                                                echo '
                                                    <div class="container" dir="rtl" style="margin-top:80px;color:#000">
                                                        <div class="alert alert-success" role="alert" style="color:#000">
                                                            تم اضافة جهة تدريبية جديدة بنجاح
                                                        </div>
                                                    </div>';
                                            }
                                        }
                                        ?>

                                        <form method="post" class="form">
                                            <div class="d-flex flex-column justify-content-around gap-4">
                                                <div>
                                                    <h4 class="form-label" for="name">اسم الجهة</h4>
                                                    <input type="text" class="form-control" style="text-align: right" name="name" id="name" required
                                                           placeholder="أدخل اسم الجهة">
                                                </div>

                                                <div>
                                                    <h4 class="form-label" for="email">البريد الالكتروني</h4>
                                                    <input type="text" class="form-control" style="text-align: right" name="email" id="email" required
                                                           placeholder="أدخل البريد الالكتروني">
                                                </div>

                                                <div>
                                                    <h4 class="form-label" for="phone">رقم الهاتف</h4>
                                                    <input type="text" class="form-control" style="text-align: right" name="phone" id="phone" required
                                                           placeholder="أدخل رقم الهاتف">
                                                    <div id="phone-error" style="color:red;"></div> <!-- عنصر عرض خطأ الهاتف -->
                                                </div>

                                                <div>
                                                    <h4 class="form-label" for="address">عنوان الجهة</h4>
                                                    <input type="text" class="form-control" style="text-align: right" name="address" id="address" required
                                                           placeholder="أدخل عنوان الجهة">
                                                </div>

                                                <div>
                                                    <h4 class="form-label" for="term">نوع الجهة</h4>
                                                    <select name="term" id="term" style="text-align: right" class="form-control"
                                                            required>
                                                        <option value="1">قطاع عام</option>
                                                        <option value="2">قطاع خاص</option>
                                                    </select>
                                                </div>

                                                <div>
                                                    <h4 class="form-label" for="chances">عدد الفرص المتاحة</h4>
                                                    <input type="number" min="0" class="form-control" style="text-align: right" name="chances" id="chances" required
                                                           placeholder="أدخل عدد الفرص المتاحة">
                                                </div>

                                                <div>
                                                    <h4 class="form-label" for="conditions">الشروط</h4>
                                                    <textarea class="form-control" style="text-align: right" name="conditions" id="conditions" rows="3" placeholder="أدخل الشروط"></textarea>
                                                </div>

                                                <div class="d-flex flex-wrap gap-3 mt-3">
                                                    <button type="submit" name="add" class="btn btn-success waves-effect waves-light w-md">
                                                        اضافة
                                                    </button>
                                                    <button type="reset" class="btn btn-outline-danger waves-effect waves-light w-md">
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
    <!-- end main content -->

</div>
<!-- END layout-wrapper -->

<!-- JAVASCRIPT -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/metisMenu.min.js"></script>
<script src="js/dashboard.init.js"></script>
<script src="js/app.js"></script>

<script>
    $(document).ready(function () {
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

        // تحقق من رقم الهاتف عند الكتابة
        $('#phone').on('input', function () {
            let phone = $(this).val();
            let phonePattern = /^05\d{8}$/; // تحقق من أن الرقم يبدأ بـ 05 ويتكون من 10 أرقام
            if (!phonePattern.test(phone)) {
                $('#phone-error').text('يجب أن يحتوي رقم الهاتف على 10 أرقام ويبدأ بـ 05').css('color', 'red');
            } else {
                $('#phone-error').text('');
            }
        });

        // Form submission validation
        $('form').on('submit', function (e) {
            let phone = $('#phone').val();
            let phonePattern = /^05\d{8}$/; // تحقق من أن الرقم يبدأ بـ 05 ويتكون من 10 أرقام
            
            // تحقق من رقم الهاتف
            if (!phonePattern.test(phone)) {
                e.preventDefault(); // منع إرسال النموذج
                $('#phone-error').text('يجب أن يحتوي رقم الهاتف على 10 أرقام ويبدأ بـ 05').css('color', 'red');
            } else {
                $('#phone-error').text(''); // إزالة أي رسالة خطأ سابقة
            }

            // تحقق من الأخطاء الأخرى
            if ($('.error').length > 0) {
                e.preventDefault();
                alert('يرجى تصحيح الأخطاء قبل الإرسال.');
            }
        });
    });
</script>


</body>
</html>
