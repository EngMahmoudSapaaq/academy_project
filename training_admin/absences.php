<?php
include 'config.php';
session_start();

$account_id = $_SESSION['id'] ?? null;

// Redirect if not logged in
if (!$account_id) {
    header('Location: ../index.php');
    exit;
}

// Fetch training admin ID
$training_admins = mysqli_query($conn, "SELECT * FROM `training_admins` WHERE account_id = '$account_id'") or die('Query failed: ' . mysqli_error($conn));
$training_admin = mysqli_fetch_assoc($training_admins);

$training_admin_id = $training_admin['id'] ?? null;


// Fetch students associated with training admin
$students_result = mysqli_query($conn, "SELECT * FROM `students` WHERE training_admin_id = '$training_admin_id'") or die('Query failed: ' . mysqli_error($conn));
$date = date('Y-m-d');

// Function to handle attendance insertion
function insertAttendance($conn, $date, $is_attended, $student_id, $training_admin_id) {
    $query = "INSERT INTO `student_attends` (date, is_attended, student_id, training_admin_id) 
              VALUES ('$date', '$is_attended', '$student_id', '$training_admin_id')";
    mysqli_query($conn, $query) or die('Query failed: ' . mysqli_error($conn));
}

// Mark all students as present
if (isset($_GET['present'])) {
    while ($student = mysqli_fetch_assoc($students_result)) {
        insertAttendance($conn, $date, 1, $student['id'], $training_admin_id);
    }
    $_SESSION['message'] = 'تم تحضير الجميع بنجاح';
    header('Location: absences.php');
    exit;
}

// Mark all students as absent
if (isset($_GET['absent'])) {
    while ($student = mysqli_fetch_assoc($students_result)) {
        insertAttendance($conn, $date, 0, $student['id'], $training_admin_id);
    }
    $_SESSION['message'] = 'تم تغييب الجميع بنجاح';
    header('Location: absences.php');
    exit;
}

// Process individual attendance
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $attendance_list = $_POST['attends'] ?? [];

    // Reset student result pointer for individual attendance processing
    mysqli_data_seek($students_result, 0);

    while ($student = mysqli_fetch_assoc($students_result)) {
        $student_id = $student['id'];
        $is_attended = in_array($student_id, $attendance_list) ? 0 : 1;
        insertAttendance($conn, $date, $is_attended, $student_id, $training_admin_id);
    }

    $_SESSION['message'] = 'تم اخذ الحضور بنجاح';
    header('Location: absences.php');
    exit;
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
            .message{
                margin:10px 0;
                width: 100%;
                border-radius: 5px;
                padding:10px;
                text-align: center;
                background-color:red;
                color:white;
                font-size: 20px;
            }
            .message1{
                margin:10px 0;
                width: 100%;
                border-radius: 5px;
                padding:10px;
                text-align: center;
                background-color:green;
                color:white;
                font-size: 20px;
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
                                    <img src="images/logo.png" alt=""  height="20">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>

                        <!-- App Search-->
                        <div class="ms-5 my-auto">
                            <span>مرحبا بك</span>, <b><?php echo $training_admin['name']; ?></b>
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

                                <span  class="d-none d-xl-inline-block ms-1 fw-medium font-size-15">مشرف ميداني</span>
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
                        <a href="index.php" class="logo logo-light">
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
                                            <li class="breadcrumb-item active">حضور وغياب الطلاب</li>
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
                                    <div class="card-body" style="position: relative;">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h4 class="card-title">حضور وغياب الطلاب</h4>
                                            <div>
                                                <a href="absences.php?absent" onclick="return confirm('هل انت متأكد من تغييب الجميع؟')" class="btn btn-danger"><i class="fa fa-times"></i> جميع الطلاب غياب</a>
                                                <a href="absences.php?present" onclick="return confirm('هل انت متأكد من تحضير الجميع؟')" class="btn btn-success"><i class="fa fa-check"></i> جميع الطلاب حضور</a>
                                            </div>
                                            <div>
                                                <label class="form-label" for="date">التاريخ</label>
                                                <input type="text" class="form-control" disabled style="text-align: center; width: 150px;" value="<?php echo htmlspecialchars($date); ?>">
                                            </div>
                                        </div>

                                        <?php if (isset($_SESSION['message'])): ?>
                                            <div class="alert alert-success" role="alert">
                                                <?php echo $_SESSION['message'];
                                                unset($_SESSION['message']); ?>
                                            </div>
<?php endif; ?>

                                        <form method="post">
                                            <div class="table-responsive">
                                                <table class="table table-centered table-nowrap mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>اسم الطالب</th>
                                                            <th>الغياب</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 1;
                                                        mysqli_data_seek($students_result, 0); // Reset pointer for reuse in HTML
                                                        if (mysqli_num_rows($students_result) > 0) {
                                                            while ($student = mysqli_fetch_assoc($students_result)) {
                                                                echo '<tr>
                                            <td>' . $i++ . '</td>
                                            <td>' . htmlspecialchars($student['name']) . '</td>
                                            <td><input type="checkbox" name="attends[]" value="' . htmlspecialchars($student['id']) . '" style="width: 20px; height: 20px;"></td>
                                        </tr>';
                                                            }
                                                        } else {
                                                            echo '<tr><td colspan="3">لا يوجد طلاب.</td></tr>';
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <button type="submit" name="submit" class="btn btn-success" style="position: absolute; left: 20px; bottom: 20px;">ارسال</button>
                                        </form>
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