<?php
include 'config.php';
session_start();
if (!(isset($_SESSION['password']))) {
    header('Location:../login.php');
}

$id = $_SESSION['id'];
$message = "";

include('../connect.php');

$trainingAdmin = [];
$trainingAgency = [];


function isValidPassword($password) {
    return preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/', $password);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'] ?? null;
    $passwordConfirmation = $_POST['password_confirmation'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $accounts = mysqli_query($conn, "SELECT * FROM `accounts` WHERE username = '$username'") or die('query failed');
    $training_admins = mysqli_query($conn, "SELECT * FROM `training_admins` WHERE email = '$email' AND phone = '$phone'") or die('query failed');
    
    
    if (!empty($password) && $password !== $passwordConfirmation) {
        $message = "<span style='color: red;'>كلمتا المرور غير متطابقتين</span>";
    } elseif (!empty($password) && (!isValidPassword($password) || !isValidPassword($passwordConfirmation))) {
        $message = "<span style='color: red;'>يجب أن تحتوي كلمة المرور علي الأقل علي حرف كبير وحرف صغير ورقم وعلي الأقل 8 حروف وأرقام</span>";
    } elseif (mysqli_num_rows($accounts) > 0) {
         $_SESSION['message'] = 'اسم المستخدم موجود بالفعل';
        header('Location: profile.php'); 
        exit;
        } elseif (mysqli_num_rows($training_admins) > 0) {
        $_SESSION['message'] = 'الايميل او رقم الهاتف موجود بالفعل';
        header('Location: profile.php'); 
        exit;
       } else {
        $stmt = $con->prepare("UPDATE training_admins SET name = ?, email = ?, phone = ?, gender = ? WHERE account_id = ?");
        $stmt->execute([$name, $email, $phone, $gender, $id]);

        if (!empty($password) && $password === $passwordConfirmation) {
            $stmt1 = $con->prepare("UPDATE accounts SET username = ?, password = ? WHERE id = ?");
            $stmt1->execute([$username,$password, $id]);
        } else {
            $stmt1 = $con->prepare("UPDATE accounts SET username = ? WHERE id = ?");
            $stmt1->execute([$username, $id]);
        }

        $_SESSION['message'] = 'تم تحديث الملف الشخصي بنجاح';
        header('Location: profile.php'); 
        exit;
    }
}


$sql = $con->prepare("
    SELECT ta.id, ta.name, ta.email, ta.phone, ta.gender, ta.training_agency_id, a.username 
    FROM training_admins ta 
    INNER JOIN accounts a ON ta.account_id = a.id 
    WHERE ta.account_id = :account_id
");
$sql->bindParam(':account_id', $id);
$sql->execute();
$trainingAdmin = $sql->fetch();


$agencyId = $trainingAdmin['training_agency_id'];
$sqlAgency = $con->prepare("SELECT name FROM training_agencies WHERE id = :agency_id");
$sqlAgency->bindParam(':agency_id', $agencyId);
$sqlAgency->execute();
$trainingAgency = $sqlAgency->fetch();

?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8"/>
    <title>وحدة التدريب التعاوني</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                        <span class="logo-sm"><img src="images/logo.png" alt="" height="22"></span>
                        <span class="logo-lg"><img src="images/logo.png" alt="" height="20"></span>
                    </a>
                    <a href="../index.php" class="logo logo-light">
                        <span class="logo-sm"><img src="images/logo.png" alt="" style="height: 60px;width: 60px" height="22"></span>
                        <span class="logo-lg"><img src="images/logo.png" alt="" height="20"></span>
                    </a>
                </div>
                <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
                <div class="ms-5 my-auto">
                    <span>مرحبا بك</span>, <b><?php echo $trainingAdmin['name']; ?></b>
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
                            class="btn header-item waves-effect" aria-haspopup="true" aria-expanded="false">
                        <span class="d-none d-xl-inline-block ms-1 fw-medium font-size-15 text-danger">تسجيل الخروج
                            <i class="fas fa-sign-out-alt ms-1" style="scale: -1;"></i></span>
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
                    <span class="logo-lg"><img src="images/logo.png" style="display: block; margin-left: auto; margin-right: auto; height: 100px;"></span>
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
                                        <li><a href="index.php" class="active" aria-expanded="false"><i class="fas fa-home"></i><span>الصفحة الرئيسية</span></a></li>
                                        <li><a href="profile.php" class="active" aria-expanded="false"><i class="fas fa-user-edit"></i><span>تعديل الملف الشخصي</span></a></li>
                                        <li><a href="#" class="active"><small class="text-muted">الادارة</small></a></li>
                                        <li><a href="students.php" class="active" aria-expanded="false"><i class="fas fa-file-alt"></i><span>بيانات الطلاب</span></a></li>
                                        <li><a href="academic_admins.php" class="active" aria-expanded="false"><i class="fas fa-user-tie"></i><span>المشرفين الاكاديميين</span></a></li>
                                        <li><a href="absences.php" class="active" aria-expanded="false"><i class="fas fa-users"></i><span>حضور وغياب الطلاب</span></a></li>
                                        <li><a href="chats.php" class="active" aria-expanded="false"><i class="fas fa-comments"></i><span>المحادثات</span></a></li>
                                    </ul>
                                </div>
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
                            <h4 class="mb-0">تعديل الملف الشخصي</h4>
                        </div>
                    </div>
                </div>

                <div class="row h-100">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <?php if (isset($_SESSION['message']) && !empty($_SESSION['message'])): ?>
                                            <div class="alert alert-success" role="alert">
                                                <?php
                                                echo $_SESSION['message'];
                                                unset($_SESSION['message']); // Clear the message after displaying it
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                        <form  method="post" class="form">
                                            <div class="d-flex flex-column justify-content-around gap-4">
                                                <div>
                                                    <h4 class="form-label" for="name">الاسم</h4>
                                                    <input type="text" class="form-control" style="text-align: right" name="name" id="name" required
                                                           placeholder="أدخل الاسم" value="<?php echo htmlspecialchars($trainingAdmin['name']); ?>" readonly>
                                                </div>

                                                <div>
                                                    <h4 class="form-label" for="email">البريد الالكتروني</h4>
                                                    <input type="email" class="form-control" style="text-align: right" name="email" id="email" required
                                                           placeholder="أدخل البريد الالكتروني" value="<?php echo htmlspecialchars($trainingAdmin['email']); ?>" readonly>
                                                </div>

                                                <div>
                                                    <h4 class="form-label" for="phone">رقم الهاتف</h4>
                                                    <input pattern="(?:\+?0*?966)?0?5[0-9]{8}" title="Phone Must Start 05 And Contains 10 Numbers" type="text" class="form-control" style="text-align: right" name="phone" id="phone" required
                                                           placeholder="أدخل رقم الهاتف" value="<?php echo htmlspecialchars($trainingAdmin['phone']); ?>" readonly>
                                                </div>

                                                <div>
                                                    <h4 class="form-label" for="gender">الجنس</h4>
                                                    <div class="form-control" id="gender-radio"
                                                         style="display: flex; flex-direction: row; justify-content: start; column-gap: 15px; text-align: right;">
                                                        <?php if($trainingAdmin['gender'] == 'm'){ ?>
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
                                                                   placeholder="أدخل اسم المستخدم" value="<?php echo htmlspecialchars($trainingAdmin['username']); ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <h4 class="form-label" for="agency">الجهة التدريبية</h4>
                                                    <input type="text" class="form-control" style="text-align: right" name="agency" id="agency" required
                                                           placeholder="الجهة التدريبية" value="<?php echo htmlspecialchars($trainingAgency['name']); ?>" readonly>
                                                </div>

                                                <div style="display: none;" id="password_container">
                                                    <div class="mb-4">
                                                        <h4 class="form-label" for="password">كلمة المرور الجديدة</h4>
                                                        <small class="text-info">* ادخل فقط اذا اردت تعديل كلمة المرور (اختياري)</small>
                                                        <input   type="password" style="text-align: right" class="form-control"
                                                               id="password" name="password" placeholder="أدخل كلمة المرور الجديدة">
                                                    </div>
                                                     <?php if (!empty($message)) echo $message; ?>

                                                    <div>
                                                        <h4 class="form-label" for="password_confirmation">تأكيد كلمة المرور الجديدة</h4>
                                                        <input   type="password" style="text-align: right" class="form-control"
                                                               id="password_confirmation" name="password_confirmation" placeholder="أعد إدخال كلمة المرور">
                                                    </div>
                                                   
                                                </div>
                                                 <?php if (!empty($message)) echo $message; ?>
                                                <div>
                                                    <a href="#" onclick="$('#password_container').fadeIn(); $(this).hide()">هل تريد تعديل كلمة المرور؟</a>
                                                </div>

                                                <div class="d-flex flex-wrap gap-3 mt-3">
                                                    <button type="submit" class="btn btn-success waves-effect waves-light w-md">تعديل</button>
                                                    <button type="reset" class="btn btn-outline-danger waves-effect waves-light w-md">إلغاء</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
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
    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/metisMenu.min.js"></script>
<script src="js/dashboard.init.js"></script>
<script src="js/app.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#name').on('input', function () {
            let name = $(this).val();
            if (name.length < 3) {
                $(this).next('.error').remove();
                $(this).after('<span class="error" style="color:red;">يجب إدخال 3 حروف على الأقل</span>');
            } else {
                $(this).next('.error').remove();
            }
        });

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

        $('#username').on('input', function () {
            let username = $(this).val();
            if (username.length < 3) {
                $(this).next('.error').remove();
                $(this).after('<span class="error" style="color:red;">يجب إدخال 3 رموز على الأقل</span>');
            } else {
                $(this).next('.error').remove();
            }
        });

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

        $('form').on('submit', function (e) {
            if ($('.error').length > 0) {
                e.preventDefault();
                alert('يرجى تصحيح الأخطاء قبل الإرسال.');
            }
        });
        $(document).ready(function () {
        // Show password fields on link click
        $('a').on('click', function () {
            $('#password_container').show();
        });
    });
    });
</script>

</body>
</html>
