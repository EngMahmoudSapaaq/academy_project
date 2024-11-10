<?php
session_start(); // بدء جلسة العمل
include('../connect.php'); // الاتصال بقاعدة البيانات

// التحقق من وجود ID الحساب في الجلسة
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// الحصول على ID الحساب من الجلسة
$account_id = $_SESSION['id'];

// استعلام للحصول على رقم المدرب من جدول الحسابات
$admin_query = "SELECT `id` FROM `training_admins` WHERE `account_id` = ?";
$stmt = $con->prepare($admin_query);
$stmt->bindValue(1, $account_id, PDO::PARAM_INT);
$stmt->execute();
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

// استخدام ID المدرب من جدول المدربين
$training_admin_id = $admin['id'];

// استعلام لجلب بيانات الطلاب مع سجلات الحضور والغياب باستخدام JOIN
$query = "
    SELECT 
        s.id AS student_id, 
        s.name, 
        s.email, 
        s.phone, 
        s.gender, 
        COUNT(a.is_attended) AS attendance_count, 
        SUM(CASE WHEN a.is_attended = 1 THEN 1 ELSE 0 END) AS present_count,
        SUM(CASE WHEN a.is_attended = 0 THEN 1 ELSE 0 END) AS absent_count
    FROM 
        students s 
    LEFT JOIN 
        student_attends a ON s.id = a.student_id 
    WHERE 
        s.training_admin_id = ? 
    GROUP BY 
        s.id
";
$stmt = $con->prepare($query);
$stmt->bindValue(1, $training_admin_id, PDO::PARAM_INT);
$stmt->execute();
$students_with_attendance = $stmt->fetchAll(PDO::FETCH_ASSOC);

// دالة لحساب التقييم العام للطالب
function getOverallEvaluation($student_id, $con) {
    $stmt = $con->prepare("SELECT SUM(`evaluation_score`) AS total_score FROM `student_scores` WHERE `student_id` = ?");
    $stmt->bindValue(1, $student_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC)['total_score'] ?: 0; // إرجاع 0 إذا لم توجد درجات
}
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

<body data-sidebar="dark" cz-shortcut-listen="true">
<!-- Begin page -->
<div id="layout-wrapper">
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <div class="navbar-brand-box">
                    <a href="index.php" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="images/logo.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="images/logo.png" alt="" height="20">
                        </span>
                    </a>
                    <a href="index.php" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="images/logo.png" alt="" style="height: 60px;width: 60px" height="22">
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
                        $sql1 = $con->prepare("SELECT * FROM training_admins WHERE account_id='$account_id'");      
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
                        <span class="d-none d-xl-inline-block ms-1 fw-medium font-size-15">مشرف ميداني</span>
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
                <a href="index.php" class="logo logo-light">
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
                <div class="simplebar-height-auto-observer-wrapper">
                    <div class="simplebar-height-auto-observer"></div>
                </div>
                <div class="simplebar-mask" style="margin-top: 30px">
                    <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                        <div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden; padding-right: 0px; padding-bottom: 0px;">
                            <div class="simplebar-content" style="padding: 0px;">
                                <div id="sidebar-menu" class="mm-active">
                                    <ul class="metismenu list-unstyled mm-show" id="side-menu">
                                        <li class="">
                                            <a href="index.php" class="active" aria-expanded="false">
                                                <i class="fas fa-home"></i>
                                                <span>الصفحة الرئيسية</span>
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
                                            <a href="students.php" class="active" aria-expanded="false">
                                                <i class="fas fa-file-alt"></i>
                                                <span>بيانات الطلاب</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="academic_admins.php" class="active" aria-expanded="false">
                                                <i class="fas fa-user-tie"></i>
                                                <span>المشرفين الاكاديميين</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="absences.php" class="active" aria-expanded="false">
                                                <i class="fas fa-users"></i>
                                                <span>حضور وغياب الطلاب</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="active">
                                                <small class="text-muted">اخرى</small>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="chats.php" class="active" aria-expanded="false">
                                                <i class="fas fa-comments"></i>
                                                <span>المحادثات</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="simplebar-placeholder" style="width: auto; height: 169px;"></div>
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
                                    <li class="breadcrumb-item active">بيانات الطلاب</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h4 class="card-title">بيانات الطلاب</h4>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap mb-0">
                     <thead class="table-light">
    <tr>
        <th>رقم الطالب</th>
        <th>الاسم</th>
        <th>البريد الالكتروني</th>
        <th>رقم الهاتف</th>
        <th>الجنس</th>
        <th>التقييم العام</th>
        <th>عدد الحضور | عدد الغياب | عدد كل الأيام</th>
        <th>إجراء</th>
    </tr>
</thead>
<tbody>
<?php foreach ($students_with_attendance as $student): ?>
    <tr>
        <td><?php echo $student['student_id']; ?></td>
        <td><?php echo $student['name']; ?></td>
        <td><?php echo $student['email']; ?></td>
        <td><?php echo $student['phone']; ?></td>
        <td>
            <?php if ($student['gender'] == "m"): ?>
                <span class="text-primary"><i class="fa fa-mars fa-lg"></i></span>
            <?php elseif ($student['gender'] == "f"): ?>
                <span class="text-danger"><i class="fa fa-venus fa-lg"></i></span>
            <?php else: ?>
                <span class="text-muted">غير محدد</span>
            <?php endif; ?>
        </td>
        <td><?php echo getOverallEvaluation($student['student_id'], $con); ?></td>
        <td><?php echo $student['present_count'] . ' | ' . $student['absent_count'] . ' | ' . ($student['present_count'] + $student['absent_count']); ?></td>
       <td>
    <span class="d-inline-block" data-bs-toggle="tooltip" title="التقييمات">
        <a class="btn btn-primary" href="evaluate_student.php?student_id=<?php echo $student['student_id']; ?>">
            <i class="fas fa-list"></i>
        </a>
    </span>
</td>

    </tr>
<?php endforeach; ?>
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
<script src="js/app.js"></script>

</body>
</html>
