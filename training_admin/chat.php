<?php
include 'config.php';
session_start();
$account_id = $_SESSION['id'];

if (!isset($account_id)) {
    header('location:../index.php');
}
$training_admins = mysqli_query($conn, "SELECT * FROM `training_admins` WHERE account_id = '$account_id'") or die('Query failed: ' . mysqli_error($conn));
$training_admin = mysqli_fetch_assoc($training_admins);

$training_admin_id = $training_admin['id'] ?? null;

$chats = null;

if (isset($_GET['academic_id'])) {
    $academic_supervisor_id = $_GET['academic_id'] ?? null;
    $academic_admins = mysqli_query($conn, "SELECT * FROM `academic_admins` WHERE id = '$academic_supervisor_id'") or die('Query failed: ' . mysqli_error($conn));
    $academic_admin = mysqli_fetch_assoc($academic_admins);
    
    $academic_admins = mysqli_query($conn, "SELECT * FROM `academic_admins` WHERE id = '$academic_supervisor_id'") or die('Query failed: ' . mysqli_error($conn));
    
    $query = "SELECT * FROM `messages_a_to_t`
          WHERE (trainning_supervisor_id = ? AND academic_supervisor_id = ?)
          ORDER BY academic_supervisor_id DESC";

    $stmt = $conn->prepare($query);

    $stmt->bind_param("ss", $training_admin_id, $academic_supervisor_id);

    $stmt->execute();

    $chats = $stmt->get_result();

    if ($chats === false) {
        die('Query failed: ' . $conn->error);
    }



    if (isset($_POST['submit'])) {
        $massege = mysqli_real_escape_string($conn, $_POST['massege']);
        $date= date('Y-m-d');
        $time = date('H:i:s');
        if (isset($massege) && $massege > 0) {
            $insert = mysqli_query($conn, "INSERT INTO `messages_a_to_t`(content, trainning_supervisor_id, academic_supervisor_id, message_date,message_time,type) VALUES('$massege', '$training_admin_id','$academic_supervisor_id', '$date', '$time', 'A_To_T')") or die('query failed');
            header('location: chat.php?academic_id=' . $academic_supervisor_id . '');
        } else {
            header('location: chat.php?academic_id=' . $academic_supervisor_id . '');
        }
    }
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
            .chat-container {
            max-height: 480px; /* Set a maximum height for the chat container */
            overflow-y: auto;  /* Enable vertical scrolling */
            border: 1px solid #ccc; /* Optional: Add a border for visual clarity */
            padding: 10px; /* Optional: Add some padding */
            border-radius: 5px; /* Optional: Rounded corners */
            background-color: #f8f9fa; /* Optional: Background color */
            margin-bottom: 20px
        }
        
        .chat-message {
            margin-bottom: 15px; /* Add space between messages */
        }
        </style>
         <script>
        function swapChat(swapper) {
            const chatMessages = document.querySelectorAll('.chat-message');
            chatMessages.forEach(message => message.style.display = 'none');
            const selectedChatIndex = swapper.value;
            if (selectedChatIndex !== "") {
                document.querySelectorAll('.chat-message')[selectedChatIndex].style.display = 'block';
            }
        }
    </script>
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
                            <span>مرحبا بك</span>, <b><?php echo $training_admin['name'];  ?></b>
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

           \

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item active">المحادثة</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">تفاصيل المحادثة مع <strong>المشرف الاكاديمي أ/ <?php echo $academic_admin['name'];   ?></strong></h4>

                                        <div  id="chat_messages" class="chat-container">
                                            <?php
                                            if ($chats && mysqli_num_rows($chats) > 0) {
                                                while ($chat = mysqli_fetch_assoc($chats)) {
                                                    $type = $chat['type'];


                                                    if ($type == 'A_To_T') {
                                                        echo '<div class="chat-message bg-primary text-light py-5 px-3 rounded my-2">
                                        <strong>أنا:</strong>' . $chat['content'] . '
                                    </div>';
                                                    } elseif ($type == 'T_To_A') {
                                                        echo '<div class="chat-message bg-light text-dark py-5 px-3 rounded my-2">
                                        <strong>' . $academic_admin['name'] . ':</strong>' . $chat['content'] . '
                                    </div>';
                                                    }
                                                }
                                            } else {
                                                echo ' <div class="chat-message bg-primary text-light py-5 px-3 rounded my-2">
                                        <strong>لا يوجد محادثات بعد .</strong> 
                                    </div>';
                                            }
                                            ?>


                                            
                                        </div>
                                        <form method="post" enctype="multipart/form-data" class="form d-flex align-items-center justify-content-between gap-2">
                                                <input type="text" name="massege" placeholder="اكتب رسالتك هنا..." class="form-control text-start" required>
                                                <button type="submit" name="submit" class="btn btn-success text-nowrap">ارسال <i class="fa fa-paper-plane"></i></button>
                                            </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> <!-- container-fluid -->
                </div> <!-- page-content -->
            </div> <!-- main-content -->

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