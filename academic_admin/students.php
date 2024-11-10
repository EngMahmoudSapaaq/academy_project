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
                        $sql1 = $con->prepare("SELECT * FROM academic_admins WHERE account_id='$id'");      
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
                        
                        <span  class="d-none d-xl-inline-block ms-1 fw-medium font-size-15">مشرف اكاديمي</span>
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
                                            <a href="weekly_reports.php" class="active" aria-expanded="false">
                                                <i class="fas fa-file-alt"></i>
                                                <span>التقارير الأسبوعية</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="training_admins.php" class="active" aria-expanded="false">
                                                <i class="fas fa-user-tie"></i>
                                                <span>نماذج المشرفين الميدانيين</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="active">
                                                <small class="text-muted">اخرى</small>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="active" aria-expanded="false"
                                                data-bs-toggle="modal" data-bs-target="#notification">
                                                <i class="fas fa-bell"></i>
                                                <span>ارسال اعلان لكل الطلاب</span>
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
                 <?php
                  
                if(isset($_POST['add_ads'])){

                $ads = $_POST['ads'];
                $sql1 = $con->prepare("SELECT * FROM academic_admins WHERE account_id='$id'");      
                $sql1->execute();
                $rows1 = $sql1->fetch();
                $acad_id = $rows1['id']; 
                 
                 include('../connect.php');

                 $sql1 = "INSERT INTO advertisments (ads , academic_id) VALUES ('$ads' , '$acad_id')";

                  $con->exec($sql1);

              echo '
                <div class="container" dir="rtl" style="margin-top:80px;color:#000">
                    <div class="alert alert-success role="alert" style="color:#000">
                        تم ارسال الاعلان لكل الطلاب بنجاح
                    </div>
                </div>';



                }


              ?>
                <form method="post">
                <div class="modal-body">
                    
                        <div>
                            <h4 class="form-label" for="name">محتوى الاعلان</h4>
                            <textarea type="text" class="form-control" style="text-align: right" name="ads" id="name" required
                                    placeholder="أدخل محتوى الاعلان المراد ارساله" rows="5"></textarea>
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">تراجع</button>
                    <button type="submit" name="add_ads" class="btn btn-success">ارسال <i class="fa fa-paper-plane"></i></button>
                </div>
                </form>    
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
                                    <li class="breadcrumb-item active">بيانات الطلاب</li>
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
                                            <th>اسم المستخدم</th>
                                            <th>الجنس</th>
                                            <th>التقييم العام</th>
                                            <th>الحضور:الغياب:الكل (الأيام)</th>
                                            <th>إجراء</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                       <?php

                                        include('../connect.php');  
                                        include 'config.php';
                                        $sql = $con->prepare("SELECT students.* , accounts.username FROM students INNER JOIN accounts ON accounts.id=students.account_id WHERE accounts.status='activated'");      
                                        $sql->execute();
                                        $rows = $sql->fetchAll();

                                        foreach($rows as $pat)
                                        {
                                            
                                        $train_id = $pat['training_admin_id'];
                                        $student_id = $pat['id'];        
                                            
                                        $sql1 = $con->prepare("SELECT * FROM training_admins WHERE id='$train_id'");      
                                        $sql1->execute();
                                        $rows1 = $sql1->fetch();    
                                            
                                        $sql2 = $con->prepare("SELECT * FROM student_attends WHERE student_id='$student_id' AND is_attended='1'");      
                                        $sql2->execute();
                                        $rows2 = $sql2->fetchAll(); 
                                        $count2 = $sql2->rowCount();   
                                            
                                        $sql3 = $con->prepare("SELECT * FROM student_attends WHERE student_id='$student_id' AND is_attended='2'");      
                                        $sql3->execute();
                                        $rows3 = $sql3->fetchAll(); 
                                        $count3 = $sql3->rowCount();   
                                            
                                        $sql4 = $con->prepare("SELECT * FROM student_attends WHERE student_id='$student_id'");      
                                        $sql4->execute();
                                        $rows4 = $sql4->fetchAll(); 
                                        $count4 = $sql4->rowCount();  
                                            
                                        $sum = 0;    
                                        $sql5 = $con->prepare("SELECT * FROM student_scores WHERE student_id='$student_id'");      
                                        $sql5->execute();
                                        $rows5 = $sql5->fetchAll(); 
                                        $count5 = $sql5->rowCount(); 
                                        if($count5 > 0){
                                            
                                            foreach($rows5 as $patt){
                                                
                                                $sum += $patt['evaluation_score'];
                                            }
                                            
                                        }    

                                        ?>     
                                        <tr>
                                            <td><?php echo $pat['id']; ?></td>
                                            <td><?php echo $pat['name']; ?></td>
                                            <td><?php echo $pat['email']; ?></td>
                                            <td><?php echo $pat['phone']; ?></td>
                                            <td><?php echo $pat['username']; ?></td>
                                            <?php if($pat['gender'] == "m"){ ?>
                                              <td><span class="text-primary"><i class="fa fa-mars fa-lg"></i></span></td>
                                            <?php }elseif($pat['gender'] == "f"){ ?>
                                              <td><span class="text-danger"><i class="fa fa-venus fa-lg"></i></span></td>
                                            <?php } ?>
                                            <td><?php echo $sum; ?></td>
                                            <td><?php echo $count4; ?>:<?php echo $count3; ?>:<?php echo $count2; ?></td>
                                            <td>
                                                <span class="d-inline-block" data-bs-toggle="tooltip" title="التقييمات">
                                                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ratings" data-studentname="<?php echo $pat['name']; ?>" 
                                                       data-adminname="<?php echo $rows1['name']; ?>" 
                                                       data-studentid="<?php echo $pat['id']; ?>">
                                                        <i class="fas fa-list"></i>
                                                    </a>
                                                </span>
                                                <span class="d-inline-block" data-bs-toggle="tooltip" title="الحضور & الغياب">
                                                    <a class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#absence" data-studentid="<?php echo $pat['id']; ?>">
                                                        <i class="fas fa-user-check"></i>
                                                    </a>
                                                </span>
                                                <span class="d-inline-block" data-bs-toggle="tooltip" title="المحادثات">
                                                     <a href="chat.php?student_id=<?php echo $pat['id']; ?>" class="btn btn-info"><i class="fas fa-comment"></i></a>
                                                
                                                    </a>
                                                </span>
											   <span class="d-inline-block" data-bs-toggle="tooltip" title="جميع النماذج">
                                                    <a class="btn btn-info" data-bs-toggle="modal" data-bs-target="#all" data-student-id="<?php echo $pat['id']; ?>">
                                                        <i class="fas fa-file-alt"></i>
                                                    </a>
                                                </span>
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

        <div class="modal fade" id="ratings" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <div class="mb-2">تقييمات الطالب: <span id="student-name"></span></div>
                            <div class="text-muted fs-6">المشرف الميداني: أ/ <span id="admin-name"></span></div>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>عناصر التقييم</th>
                                        <th>درجة التقييم</th>
                                    </tr>
                                </thead>
                                <tbody id="scores-table-body">
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>المجموع النهائي</th>
                                        <td></td>
                                        <th id="final-score">0</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">اغلاق</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="absence" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <div class="mb-2">جدول حضور/غياب الطالب: <span id="student-nameee1"></span></div>
                        <div class="text-muted fs-6">المشرف الميداني: أ/ <span id="supervisor-name"></span></div>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

  <div class="row" style="margin: 10px">
    <div class="col-lg-5">
        <label class="form-label" for="from-date">من تاريخ</label>
        <input type="date" class="form-control" name="from_date" id="from_date">
    </div>
    <div class="col-lg-5">
        <label class="form-label" for="to-date">إلى تاريخ</label>
        <input type="date" class="form-control" name="to_date" id="to_date">
    </div>
    <div class="col-lg-2">
        <div class="modal-footer" style="margin-top:15px">
            <button type="button" id="filter-btn" class="btn btn-outline-dark">فرز</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var fromDate = document.getElementById('from_date');
    var toDate = document.getElementById('to_date');

    fromDate.addEventListener('change', function () {
        toDate.min = fromDate.value;
    });
});
</script>

                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>التاريخ</th>
                                    <th>حالة الحضور/الغياب</th>
                                </tr>
                            </thead>
                            <tbody id="attendance-table">
                                <!-- سيتم ملء الجدول هنا -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>الحضور:الغياب:الكل</th>
                                    <td id="attendance-summary">0:0:0</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">اغلاق</button>
                </div>
            </div>
        </div>
    </div>


        <div class="modal fade" id="all" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <div class="mb-2">نماذج الطالب</div>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">
                            
                            
                        </ul>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">اغلاق</button>
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
    var ratingsModal = document.getElementById('ratings');
    ratingsModal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        var button = event.relatedTarget;

        // Extract info from data-* attributes
        var studentName = button.getAttribute('data-studentname');
        var adminName = button.getAttribute('data-adminname');

        // Update the modal's content
        var modalTitleStudent = document.getElementById('student-name');
        var modalTitleAdmin = document.getElementById('admin-name');
        var studentId = button.getAttribute('data-studentid');
        
        modalTitleStudent.textContent = studentName;
        modalTitleAdmin.textContent = adminName;
        fetchScores(studentId);
        
    });
});
</script>    
<script>
    function fetchScores(studentId) {
    // هنا يمكنك استخدام AJAX للحصول على بيانات الدرجات من السيرفر
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "fetch_student_scores.php?student_id=" + studentId, true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            var scores = JSON.parse(xhr.responseText);
            var tableBody = document.getElementById('scores-table-body');
            var totalScore = 0;
            tableBody.innerHTML = ''; // تنظيف الجدول

            scores.forEach(function (score, index) {
                var row = `<tr>
                    <td>${index + 1}</td>
                    <td>${score.evaluation_element}</td>
                    <td>${score.evaluation_score}</td>
                </tr>`;
                tableBody.innerHTML += row;
                totalScore += parseInt(score.evaluation_score);
            });
            document.getElementById('final-score').textContent = totalScore;
        }
    };
    xhr.send();
}
</script>
 <script>
     document.addEventListener('DOMContentLoaded', function () {
    var absenceModal = document.getElementById('absence');
    absenceModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var studentId = button.getAttribute('data-studentid');
        console.log(studentId);
        fetchAttendance(studentId); // جلب البيانات عند فتح المودال
    });
         
    var absenceModal = document.getElementById('absence');
    absenceModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // الزر الذي تم النقر عليه لفتح المودال
        var studentId = button.getAttribute('data-studentid'); // جلب رقم الطالب من الزر
        this.setAttribute('data-studentid', studentId); // تعيين رقم الطالب في المودال
    });     

    document.getElementById('filter-btn').addEventListener('click', function () {
    var absenceModal = document.getElementById('absence'); // جلب المودال
    var studentId = absenceModal.getAttribute('data-studentid'); // الحصول على رقم الطالب من المودال
    var fromDate = document.querySelector('input[name="from_date"]').value; // جلب تاريخ البداية
    var toDate = document.querySelector('input[name="to_date"]').value; // جلب تاريخ النهاية

    console.log(fromDate); // عرض تاريخ البداية
    console.log(toDate);   // عرض تاريخ النهاية
    console.log(studentId); // عرض رقم الطالب

    fetchAttendance(studentId, fromDate, toDate); // جلب البيانات بعد الفلترة
   });
});

function fetchAttendance(studentId, fromDate = null, toDate = null) {
    var xhr = new XMLHttpRequest();
    var url = "fetch_student_attendance.php?student_id=" + studentId;
    if (fromDate && toDate) {
        url += "&from_date=" + fromDate + "&to_date=" + toDate;
    }

    xhr.open("GET", url, true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);

            if (data.error) {
                alert(data.error); // عرض رسالة خطأ إذا لم يتم العثور على الطالب
                return;
            }

            console.log(data.student.name);
            var studentNameElement = document.getElementById('student-name');
            if (studentNameElement) {
            // تحديث اسم الطالب
            studentNameElement.textContent = data.student.name;
            } else {
                console.log('العنصر الذي يحمل id="student-name" غير موجود في DOM');
            }
            // تحديث اسم الطالب واسم المشرف
            document.getElementById('student-nameee1').textContent = data.student.name;
            document.getElementById('supervisor-name').textContent = data.supervisor.name;

            var tableBody = document.getElementById('attendance-table');
            tableBody.innerHTML = ''; // تنظيف الجدول

            var attendanceCount = 0;
            var absenceCount = 0;
            var totalCount = 0;

            if (data.attendance.length > 0) {
                // إدراج البيانات في الجدول وحساب الإجمالي
                data.attendance.forEach(function (entry) {
                    var status = entry.is_attended === '1' ? 'حاضر' : 'غائب';
                    var statusClass = entry.is_attended === '1' ? 'text-success' : 'text-danger';

                    var row = `<tr>
                        <td>${entry.date}</td>
                        <td><span class="${statusClass}">${status}</span></td>
                    </tr>`;
                    tableBody.innerHTML += row;

                    if (entry.is_attended === '1') {
                        attendanceCount++;
                    } else {
                        absenceCount++;
                    }
                    totalCount++;
                });
            } else {
                // في حالة عدم وجود بيانات
                tableBody.innerHTML = '<tr><td colspan="2">لا توجد بيانات في هذا النطاق الزمني</td></tr>';
            }

            // تحديث ملخص الحضور
            document.getElementById('attendance-summary').textContent = `${totalCount}:${absenceCount}:${attendanceCount}`;
        }
    };
    xhr.send();
}


</script>  
<script>
    document.addEventListener('DOMContentLoaded', function () {
    // عند فتح المودال
    var allModal = document.getElementById('all');
    allModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // الزر الذي فتح المودال
        var studentId = button.getAttribute('data-student-id'); // رقم الطالب

        // جلب النماذج الخاصة بالطالب
        fetch(`fetch_student_models.php?student_id=${studentId}`)
            .then(response => response.json())
            .then(data => {
                var ul = allModal.querySelector('.list-group');
                ul.innerHTML = ''; // مسح القائمة الحالية

                // إضافة النماذج إلى القائمة
                data.models.forEach(model => {
                    var li = document.createElement('li');
                    li.className = 'list-group-item';
                    li.innerHTML = `<a href="../files/${model.modeling}" class="text-decoration-none">${model.modeling} <i class="fa fa-download"></i></a>`;
                    ul.appendChild(li);
                });
            })
            .catch(error => console.error('حدث خطأ أثناء جلب النماذج:', error));
    });
});

</script>    


</body>
</html>