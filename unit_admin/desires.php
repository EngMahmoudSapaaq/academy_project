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
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
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
                    <a href="../index.php" class="logo logo-light">
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
                    $sql1 = $con->prepare("SELECT * FROM unit_admins WHERE account_id=:id");
                    $sql1->bindParam(':id', $id, PDO::PARAM_INT);
                    $sql1->execute();
                    $rows1 = $sql1->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <span>مرحبا بك</span>, <b><?php echo htmlspecialchars($rows1['name']); ?></b>
                </div>
            </div>

            <div class="d-flex">
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-none d-xl-inline-block ms-1 fw-medium font-size-15">مشرف الوحدة</span>
                    </button>
                </div>

                <div class="dropdown d-inline-block">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#logout" class="btn header-item waves-effect" aria-haspopup="true" aria-expanded="false">
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
                <div class="simplebar-content">
                    <div id="sidebar-menu" class="mm-active">
                        <ul class="metismenu list-unstyled mm-show" id="side-menu">
                            <li><a href="home.php" class="active"><i class="fas fa-home"></i><span>الصفحة الرئيسية</span></a></li>
                            <li><a href="unit_admins_create.php" class="active"><i class="fas fa-user-plus"></i><span>تعيين مشرف وحدة جديد</span></a></li>
                            <li><a href="profile.php" class="active"><i class="fas fa-user-edit"></i><span>تعديل الملف الشخصي</span></a></li>
                            <li><a href="#" class="active"><small class="text-muted">الادارة</small></a></li>
                            <li><a href="index.php" class="active"><i class="fas fa-file-alt"></i><span>ادارة الشعب</span></a></li>
                            <li><a href="training_agencies.php" class="active"><i class="fas fa-university"></i><span>ادارة الجهات التدريبية</span></a></li>
                            <li><a href="academic_admins.php" class="active"><i class="fas fa-user-tie"></i><span>ادارة المشرفين الأكاديميين</span></a></li>
                            <li><a href="training_admins.php" class="active"><i class="fas fa-user-tie"></i><span>ادارة المشرفين الميدانيين</span></a></li>
                            <li><a href="students.php" class="active"><i class="fas fa-user-graduate"></i><span>معالجة طلبات الطلاب</span></a></li>
                            <li><a href="student_mang.php" class="active"><i class="fas fa-users"></i><span>ادارة الطلاب</span></a></li>
                            <li><a href="desires.php" class="active"><i class="fas fa-list-ul"></i><span>ادارة رغبات الطلاب</span></a></li>
                            <li><a href="#" class="active"><small class="text-muted">التقارير</small></a></li>
                            <li><a href="students_report.php" class="active"><i class="fas fa-chart-pie"></i><span>تقرير المتدربين</span></a></li>
                            <li><a href="training_agencies_report.php" class="active"><i class="fas fa-chart-pie"></i><span>تقرير الجهات التدريبية</span></a></li>
                        </ul>
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
                                    <li class="breadcrumb-item active">ادارة الرغبات</li>
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
                                    <h4 class="card-title">كل الرغبات</h4>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap mb-0">
                                        <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>اسم الطالب</th>
                                            <th>الرغبة الأولى</th>
                                            <th>الرغبة الثانية</th>
                                            <th>الرغبة الثالثة</th>
                                            <th>تاريخ التقديم</th>
                                            <th>إجراء</th>
                                        </tr>
                                        </thead>
                                        <tbody>
<?php
include('../connect.php'); // تأكد من الاتصال بقاعدة البيانات

// إعداد الاستعلام لجلب الرغبات وأسماء الجهات التدريبية لكل رغبة
$sql = "SELECT sd1.id AS first_desire_id, s.id AS student_id, s.name AS student_name,
        ta1.name AS first_desire_name, sd1.notes AS first_note,
        ta2.name AS second_desire_name, sd2.notes AS second_note,
        ta3.name AS third_desire_name, sd3.notes AS third_note,
        sd1.application_date
        FROM students s
        LEFT JOIN student_desires sd1 ON s.id = sd1.student_id AND sd1.order = 'first'
        LEFT JOIN training_agencies ta1 ON sd1.training_agency_id = ta1.id
        LEFT JOIN student_desires sd2 ON s.id = sd2.student_id AND sd2.order = 'second'
        LEFT JOIN training_agencies ta2 ON sd2.training_agency_id = ta2.id
        LEFT JOIN student_desires sd3 ON s.id = sd3.student_id AND sd3.order = 'third'
        LEFT JOIN training_agencies ta3 ON sd3.training_agency_id = ta3.id
        WHERE sd1.status = 'pending' OR sd2.status = 'pending' OR sd3.status = 'pending'
        GROUP BY s.id";

$stmt = $con->prepare($sql);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $student_id = isset($row['student_id']) ? $row['student_id'] : 'غير متوفر';
        $first_desire_id = isset($row['first_desire_id']) ? $row['first_desire_id'] : 'غير متوفر';
        
        echo "<tr>
                <td>" . htmlspecialchars($student_id) . "</td>
                <td>" . htmlspecialchars($row['student_name']) . "</td>
                <td>" . (isset($row['first_desire_name']) ? htmlspecialchars($row['first_desire_name']) : 'غير متوفر') . "</td>
                <td>" . (isset($row['second_desire_name']) ? htmlspecialchars($row['second_desire_name']) : 'غير متوفر') . "</td>
                <td>" . (isset($row['third_desire_name']) ? htmlspecialchars($row['third_desire_name']) : 'غير متوفر') . "</td>
                <td>" . htmlspecialchars($row['application_date']) . "</td>
                <td>
                    <!-- زر القبول -->
                    <a href='#' class='btn btn-success' data-bs-target='#desire_accept' data-bs-toggle='modal'
                       onclick='showSelectedDesires(" . htmlspecialchars($first_desire_id) . ", " . htmlspecialchars($student_id) . ", \"" . htmlspecialchars($row['first_desire_name']) . "\", \"" . htmlspecialchars($row['first_note']) . "\", \"" . htmlspecialchars($row['second_desire_name']) . "\", \"" . htmlspecialchars($row['second_note']) . "\", \"" . htmlspecialchars($row['third_desire_name']) . "\", \"" . htmlspecialchars($row['third_note']) . "\")'>
                       <i class='fa fa-check'></i> قبول
                    </a>
                    <!-- زر اختيار جهة -->
                    <a href='#' class='btn btn-primary' data-bs-target='#desire_select_agency' data-bs-toggle='modal'
                       onclick='selectAvailableAgency(" . htmlspecialchars($student_id) . ")'>
                       <i class='fas fa-arrow-right'></i> اختيار جهة
                    </a>
                </td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='7'>لا توجد رغبات.</td></tr>";
}
?>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

              <div class="modal fade" id="desire_accept" tabindex="-1" data-bs-backdrop="static" aria-labelledby="desire_accept_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="desire_accept_label">قبول الرغبات !</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
           <form action="desires_accept.php" method="POST">
    <!-- حقل لإرسال ID الطلب -->
    <input type="hidden" id="desire_id" name="desire_id"> <!-- To store the desire ID -->
    <!-- حقل لإرسال ID الطالب -->
    <input type="hidden" id="student_id" name="student_id"> <!-- To store the student ID -->
    <!-- حقل مخفي لتخزين ID الجهة المختارة -->
    <input type="hidden" id="accepted_desire" name="accepted_desire">

    <div class="d-flex flex-column justify-content-around gap-4">
        <!-- الرغبة الأولى -->
        <div class="row">
            <div class="col-lg-6">
                <div>
                    <h4 class="form-label">الرغبة الأولى</h4>
                    <div style="margin-bottom: 5px;">
                  <input type="radio" name="accepted_desire_radio" id="first_desire" value="1" onclick="setAcceptedDesire(this.value)" required>
<label for="first_desire" style="margin-left:10px;" id="first_desire_label">أرامكو</label>
</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div>
                    <h4 class="form-label">ملاحظات</h4>
                    <input type="text" class="form-control" style="border:none;" name="first_note" id="first_note" readonly value="ملاحظات ملاحظات">
                </div>
            </div>
        </div>

        <!-- الرغبة الثانية -->
        <div class="row">
            <div class="col-lg-6">
                <div>
                    <h4 class="form-label">الرغبة الثانية</h4>
                    <div style="margin-bottom: 5px;">
                  <input type="radio" name="accepted_desire_radio" id="second_desire" value="2" onclick="setAcceptedDesire(this.value)" required>
<label for="second_desire" style="margin-left:10px;" id="second_desire_label">سدايا</label>
</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div>
                    <h4 class="form-label">ملاحظات</h4>
                    <input type="text" class="form-control" style="border:none;" name="second_note" id="second_note" readonly value="ملاحظات ملاحظات">
                </div>
            </div>
        </div>

        <!-- الرغبة الثالثة -->
        <div class="row">
            <div class="col-lg-6">
                <div>
                    <h4 class="form-label">الرغبة الثالثة</h4>
                    <div style="margin-bottom: 5px;">
                  
<input type="radio" name="accepted_desire_radio" id="third_desire" value="3" onclick="setAcceptedDesire(this.value)" required>
<label for="third_desire" style="margin-left:10px;" id="third_desire_label">الشركة السعودية للكهرباء</label>
 </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div>
                    <h4 class="form-label">ملاحظات</h4>
                    <input type="text" class="form-control" style="border:none;" name="third_note" id="third_note" readonly value="ملاحظات ملاحظات">
                </div>
            </div>
        </div>

        <!-- اختيار المشرف الميداني -->
        <div>
            <h4 class="form-label">اسناد الي مشرف ميداني</h4>
            <select name="field_supervisor" id="field_supervisor" class="form-control" required>
                <option value="">-- اختر المشرف الميداني --</option>
                <?php
                // Fetching field supervisors from the database
                include('../connect.php');
                $supervisors_query = "SELECT id, name FROM training_admins";
                $stmt_supervisors = $con->prepare($supervisors_query);
                $stmt_supervisors->execute();

                while ($supervisor = $stmt_supervisors->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$supervisor['id']}'>{$supervisor['name']}</option>";
                }
                ?>
            </select>
        </div>

        <!-- أزرار الحفظ والإلغاء -->
        <div class="modal-footer d-flex flex-wrap gap-3 mt-3">
            <button type="submit" class="btn btn-success waves-effect waves-light w-md">حفظ</button>
            <button type="reset" data-bs-dismiss="modal" class="btn btn-outline-danger waves-effect waves-light w-md">إلغاء</button>
        </div>
    </div>
</form>

            </div>
        </div>
    </div>
</div>
<?php
// تحقق من متغير GET "status" لإظهار رسالة النجاح
if (isset($_GET['status']) && $_GET['status'] == 'success') {
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'تم قبول الطالب!',
                text: 'تم قبول الطالب في الرغبة المحددة بنجاح.',
                icon: 'success',
                confirmButtonText: 'موافق'
            });
        });
    </script>
    ";
}
?>


                <!-- Modal for selecting available agency -->
                <div class="modal fade" id="desire_select_agency" tabindex="-1" aria-labelledby="desire_select_agency_label" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="desire_select_agency_label">اختيار جهة من الجهات المتاحة</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                           
                             <form action="assign_agency.php" method="POST">
    <!-- تأكد من تضمين رقم الطالب -->
    <input type="hidden" id="student_id" name="student_id" value="<?php echo $student_id; ?>">
    <label for="assigned_agency">اختيار الجهة:</label>
    <select name="assigned_agency" id="assigned_agency" class="form-control" required>
        <option value="">-- اختر الجهة المتاحة --</option>
        <?php
        // جلب الجهات التدريبية المتاحة من قاعدة البيانات
        include('../connect.php');
        $sql = "SELECT id, name FROM training_agencies";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
        ?>
    </select>
    <label for="field_supervisor_agency">اختيار المشرف الميداني:</label>
    <select name="field_supervisor_agency" id="field_supervisor_agency" class="form-control" required>
        <option value="">-- اختر المشرف --</option>
        <?php
        // جلب المشرفين المتاحين من قاعدة البيانات
        $supervisors_query = "SELECT id, name FROM training_admins";
        $stmt_supervisors = $con->prepare($supervisors_query);
        $stmt_supervisors->execute();
        while ($supervisor = $stmt_supervisors->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='{$supervisor['id']}'>{$supervisor['name']}</option>";
        }
        ?>
    </select>
    <button type="submit" class="btn btn-primary mt-3">اعتماد</button>
</form>

      
                            
                        </div>
                    </div>
                </div>

            </div>
        </div>

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
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/metisMenu.min.js"></script>
<script src="js/dashboard.init.js"></script>
<script src="js/app.js"></script>

<!-- جزء JavaScript لتعيين قيم الرغبات والملاحظات -->
<script>
function showSelectedDesires(requestId, studentId, firstDesire, firstNote, secondDesire, secondNote, thirdDesire, thirdNote) {
    // تأكيد تعيين رقم الطلب والطالب
    document.getElementById('desire_id').value = requestId; // تعيين رقم الطلب
    document.getElementById('student_id').value = studentId; // تعيين رقم الطالب

    // تعيين الرغبات والملاحظات في المودال
    document.getElementById('first_desire_label').innerText = firstDesire || 'غير متوفر';
    document.getElementById('first_note').value = firstNote || 'لا توجد ملاحظات';
    document.getElementById('second_desire_label').innerText = secondDesire || 'غير متوفر';
    document.getElementById('second_note').value = secondNote || 'لا توجد ملاحظات';
    document.getElementById('third_desire_label').innerText = thirdDesire || 'غير متوفر';
    document.getElementById('third_note').value = thirdNote || 'لا توجد ملاحظات';
}


function selectAvailableAgency(studentId) {
    document.getElementById('agency_request_id').value = studentId;
}

function setAcceptedDesire(value) {
    document.getElementById('accepted_desire').value = value; // تعيين رقم الجهة المختارة
}
</script>


</body>
</html>
