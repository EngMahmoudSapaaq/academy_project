<?php
include('../connect.php');
include('config.php');
session_start();



$message = '';
$account_id = $_SESSION['id'];



$training_admins = mysqli_query($conn, "SELECT * FROM `training_admins` WHERE account_id = '$account_id'") or die('Query failed: ' . mysqli_error($conn));
$training_admin = mysqli_fetch_assoc($training_admins);

$training_admin_id = $training_admin['id'] ?? null;
$students = mysqli_query($conn, "SELECT * FROM `students` WHERE training_admin_id = '$training_admin_id'") or die('Query failed: ' . mysqli_error($conn));

// File upload handling
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['modeling'])) {
    $modeling = $_FILES['modeling']['name'];
    $modeling_tmp_name = $_FILES['modeling']['tmp_name'];
    $academic_id = mysqli_real_escape_string($conn, $_POST['academic_id']);
    $training_admin_id = mysqli_real_escape_string($conn, $training_admin_id); // Ensure training_admin_id is sanitized
    // Define upload folder and full file path
    $upload_directory = 'uploads/';
    $modeling_folder = $upload_directory . basename($modeling);

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO `trainners_models` (modeling, trainner_id, academic_id) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $modeling, $training_admin_id, $academic_id);

    // Execute the statement and handle file upload only if insert succeeds
    if ($stmt->execute()) {
        if (move_uploaded_file($modeling_tmp_name, $modeling_folder)) {
            $message = "تم رفع النموذج بنجاح!";
        } else {
            $message = "فشل في رفع الملف إلى الخادم.";
        }
    } else {
        $message = "فشل في رفع الملف إلى قاعدة البيانات.";
    }
    $stmt->close();
}
?>

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
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>

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
            <!-- Left Sidebar End -->

            <div class="modal fade" id="notification" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">ارسال اعلان لكل الطلاب</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="#">
                                <div>
                                    <h4 class="form-label" for="name">محتوى الاعلان</h4>
                                    <textarea  type="text" class="form-control" style="text-align: right" name="name" id="name" required
                                               placeholder="أدخل محتوى الاعلان المراد ارساله" rows="5"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">تراجع</button>
                            <a href="../index.php" type="button" class="btn btn-success">ارسال <i class="fa fa-paper-plane"></i></a>
                        </div>
                    </div>
                </div>
            </div>

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
                                            <li class="breadcrumb-item active">المشرفين الاكاديميين</li>
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
                                            <h4 class="card-title">المشرفين الأكاديميين</h4>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-centered table-nowrap mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>رقم المشرف</th>
                                                        <th>الاسم</th>
                                                        <th>البريد الالكتروني</th>
                                                        <th>رقم الهاتف</th>
                                                        <th>اسم المستخدم</th>
                                                        <th>الجنس</th>
                                                        <th>إجراء</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (isset($students) && mysqli_num_rows($students) > 0) {
                                                        while ($student = mysqli_fetch_assoc($students)) {
                                                            $major_id = $student['major_id'];
                                                            $majors = mysqli_query($conn, "SELECT * FROM `majors` WHERE id = '$major_id'") or die('Query failed: ' . mysqli_error($conn));
                                                            $major = mysqli_fetch_assoc($majors);
                                                            $academic_id = $major['academic_admin_id'];

                                                            $academic_admins = mysqli_query($conn, "SELECT * FROM `academic_admins` WHERE id = '$academic_id'") or die('Query failed: ' . mysqli_error($conn));
                                                            $academic_admin = mysqli_fetch_assoc($academic_admins);
                                                            $account_id = $academic_admin['account_id'];

                                                            $accounts = mysqli_query($conn, "SELECT * FROM `accounts` WHERE id = '$account_id'") or die('Query failed: ' . mysqli_error($conn));
                                                            $account = mysqli_fetch_assoc($accounts);

                                                            $query = "SELECT `modeling` FROM `trainners_models` WHERE `trainner_id` = :trainner_id AND `academic_id` = :academic_id";
                                                            $stmt = $con->prepare($query);
                                                            $stmt->execute(['trainner_id' => $training_admin_id, 'academic_id' => $academic_id]);
                                                            $models = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                            // Pass JSON encoded models with JSON_HEX_APOS to avoid issues with quotes
                                                            $models_json = htmlspecialchars(json_encode($models, JSON_HEX_APOS), ENT_QUOTES, 'UTF-8');
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $academic_admin['id']; ?></td>
                                                                <td><?php echo $academic_admin['name']; ?></td>
                                                                <td><?php echo $academic_admin['email']; ?></td>
                                                                <td><?php echo $academic_admin['phone']; ?></td>

                                                                <td>@<?php echo $academic_admin['account_id']; ?></td>
                                                                <td>
                                                                    <?php if ($academic_admin['gender'] == "m"): ?>
                                                                        <span class="text-primary"><i class="fa fa-mars fa-lg"></i></span>
                                                                    <?php elseif ($academic_admin['gender'] == "f"): ?>
                                                                        <span class="text-danger"><i class="fa fa-venus fa-lg"></i></span>
                                                                    <?php else: ?>
                                                                        <span class="text-muted">غير محدد</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-primary view-models" 
                                                                            data-academic-id="<?php echo $academic_admin['id']; ?>" 
                                                                            data-academic-name="<?php echo htmlspecialchars($academic_admin['name']); ?>" 
                                                                            data-models="<?php echo $models_json; ?>" 
                                                                            data-bs-toggle="modal" 
                                                                            data-bs-target="#all">
                                                                        <i class="fas fa-file-alt"></i>
                                                                    </button>
                                                                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#upload" data-academic-id="<?php echo htmlspecialchars($academic_admin['id']); ?>">
                                                                        <i class="fas fa-upload"></i>
                                                                    </a>
                                                                    <a href="chat.php?academic_id=<?php echo $academic_admin['id']; ?>" class="btn btn-info"><i class="fas fa-comment"></i></a>
                                                                </td>
                                                            </tr>
                                                        <?php }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>


                                        </div>
                                        <!-- end table-responsive -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="modal fade" id="upload" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">
                                            <div class="mb-2">رفع نموذج</div>
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <input type="hidden" name="academic_id" id="academic_id" value="" />
                                            <div class="d-flex justify-content-around align-items-center gap-2">
                                                <div class="text-nowrap"><strong>اختر النموذج</strong></div>
                                                <input type="file" name="modeling" class="form-control" required />
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">اغلاق</button>
                                            <button type="submit" class="btn btn-success">ارسال <i class="fa fa-paper-plane"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="all" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">النماذج للمشرف الأكاديمي: <span id="modalAcademicName"></span></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="list-group" id="modelList"></ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">اغلاق</button>
                                    </div>
                                </div>
                            </div>
                        </div>









                        <script>
                            document.querySelectorAll('.view-models').forEach(function (button) {
                                button.addEventListener('click', function () {
                                    const academicName = this.getAttribute('data-academic-name');
                                    const modelsData = this.getAttribute('data-models');
                                    let models = [];

                                    try {
                                        models = JSON.parse(modelsData);
                                    } catch (e) {
                                        console.error("Failed to parse JSON data:", e);
                                    }

                                    const modelList = document.getElementById('modelList');
                                    const modalAcademicName = document.getElementById('modalAcademicName');

                                    modalAcademicName.innerText = academicName;
                                    modelList.innerHTML = '';

                                    if (models.length > 0) {
                                        models.forEach(function (model) {
                                            const listItem = document.createElement('li');
                                            listItem.className = 'list-group-item';
                                            listItem.innerHTML = `<a href="uploads/${model.modeling}" class="text-decoration-none" target="_blank">
                        ${model.modeling} <i class="fa fa-download"></i></a>`;
                                            modelList.appendChild(listItem);
                                        });
                                    } else {
                                        modelList.innerHTML = '<li class="list-group-item">لا توجد نماذج مرفوعة بعد.</li>';
                                    }
                                });
                            });
                        </script>






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
        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const uploadModal = document.getElementById('upload');
                                uploadModal.addEventListener('show.bs.modal', function (event) {
                                    const button = event.relatedTarget;
                                    const academicId = button.getAttribute('data-academic-id');
                                    const academicIdInput = uploadModal.querySelector('#academic_id');
                                    academicIdInput.value = academicId;
                                });
                            });
        </script>




    </body>
</html>