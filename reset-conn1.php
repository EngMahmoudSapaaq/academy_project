<?php
session_start();
ob_start();
include('connect.php');

if ($_POST) {
    $otp = $_POST['code'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    // التحقق من الرمز وتأكيد كلمة المرور
    if ($_SESSION['otp'] == $otp && $password == $confirm) {
        
        // التحقق من شروط كلمة المرور: حرف كبير، حرف صغير، رقم، رمز، و8 حروف على الأقل
        if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
            $user_id = $_SESSION['admin'] ?? $_SESSION['academic'] ?? $_SESSION['training'] ?? $_SESSION['student'];
            
            // تحديث كلمة المرور إذا كانت الشروط مستوفاة
            $update_stmt = $con->prepare("UPDATE accounts SET password = ? WHERE id = ?");
            $update_stmt->execute([$password, $user_id]);
            
            echo '<div class="alert alert-success">تم تحديث كلمة المرور بنجاح.</div>';
        } else {
            echo '<div class="alert alert-danger">يجب أن تحتوي كلمة المرور على حرف كبير، حرف صغير، رقم، رمز، وأن تكون على الأقل 8 حروف.</div>';
        }
    } else {
        echo '<div class="alert alert-danger">رمز التحقق أو تأكيد كلمة المرور غير صحيح.</div>';
    }
}
ob_end_flush();
?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>وحدة التدريب التعاوني</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="css/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400&display=swap" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/swiper.min.css">
    <link rel="stylesheet" href="css/star-rating-svg.css">
</head>
<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php"><img src="assets/img/logo3.jpeg" width="100"> وحدة التدريب التعاوني</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto my-2 my-lg-0">
                    <li class="nav-item"><a class="nav-link px-3" href="index.php">الصفحة الرئيسية</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="training-agencies.php">الجهات التدريبية</a></li>
                </ul>
                <a href="login.php" class="btn btn-primary">تسجيل دخول</a>
                <a href="register.php" class="btn btn-primary">تسجيل جديد</a>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <header class="masthead" style="display: flex; flex-direction: column; justify-content: center;">
        <div class="container px-4 px-lg-5 h-100">
            <h1 class="text-white font-weight-bold">تغيير كلمة المرور</h1>
            <hr class="divider divider-light" />
            <form method="post" class="form p-5 rounded border border-primary" style="background-color: rgba(255, 255, 255, .1);">
                <div class="mb-3">
                    <label for="code" class="text-light">الكود المرسل للبريد الالكتروني *</label>
                    <input type="text" class="form-control" id="code" name="code" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="text-light">كلمة المرور الجديدة *</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="text-light">تأكيد كلمة المرور *</label>
                    <input type="password" class="form-control" name="confirm" id="password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-primary">حفظ</button>
            </form>
        </div>
    </header>

    <!-- Footer -->
    <footer class="bg-light py-5 border-top border-primary">
        <div class="container px-4 px-lg-5 text-center">
            <div class="small text-dark">جميع الحقوق محفوظة &copy; 2024 - وحدة التدريب التعاوني</div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="js/jquery.3.7.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
