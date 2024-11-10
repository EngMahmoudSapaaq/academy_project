<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>وحدة التدريب التعاوني</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap Icons-->
    <link href="css/bootstrap-icons.css" rel="stylesheet" />
    <!-- Google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400&display=swap" rel="stylesheet">
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <!-- swiper CSS -->
    <link rel="stylesheet" href="css/swiper.min.css">
    <!-- rating -->
    <link rel="stylesheet" href="css/star-rating-svg.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.6.1/toastify.min.css" integrity="sha512-UiKdzM5DL+I+2YFxK+7TDedVyVm7HMp/bN85NeWMJNYortoll+Nd6PU9ZDrZiaOsdarOyk9egQm6LOJZi36L2g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
        .error-message {
            color: red;
            font-size: 0.9em;
        }
    </style></head>

<body id="page-top">


    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php">وحدة التدريب التعاوني</a>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto my-2 my-lg-0">
                    <li class="nav-item"><a class="nav-link px-3" href="index.php">الصفحة الرئيسية</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="training-agencies.php">الجهات التدريبية</a></li>
                </ul>
                <div><a href="login.php" class="btn btn-primary">تسجيل دخول</a></div>
            </div>
        </div>
    </nav>

    <!-- Masthead-->
    <header class="masthead masthead-login h-auto pb-5">
        <div class="container px-4 px-lg-5 h-100">
            <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8 align-self-end">
                    <h1 class="text-white font-weight-bold">تسجيل حساب متدرب جديد</h1>
                    <hr class="divider divider-light" />
                </div>
<?php
    if (isset($_POST['register'])) {
        include('connect.php');
        
        // بيانات الإدخال
        $name = $_POST["name"];    
        $email = $_POST["email"];    
        $password = $_POST["password"];
        $national = $_POST["national"]; 
        $gender = $_POST["gender"]; 
        $level = $_POST["level"]; 
        $phone = $_POST["phone"]; 
        $username = $_POST["username"]; 
        $registerDate = date('Y-m-d H:i:s'); // الحصول على التاريخ الحالي

        // التحقق من التكرار في جداول accounts و students
        $checkStmt = $con->prepare("SELECT * FROM accounts JOIN students ON accounts.id = students.account_id WHERE accounts.username = ? OR students.phone = ? OR students.email = ? OR students.citizen_number = ?");
        $checkStmt->execute([$username, $phone, $email, $national]);
        $existing = $checkStmt->fetch();

        if ($existing) {
            echo '<div class="alert alert-danger">اسم المستخدم، رقم الهاتف، البريد الإلكتروني، أو السجل المدني موجود بالفعل. الرجاء استخدام بيانات مختلفة.</div>';
        } else {
            // إدخال البيانات في جدول student_registeration_requests فقط
            $sql = "INSERT INTO student_registeration_requests (name, email, phone_number, gender, national_id, level, username, password, status, regsiter_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending', ?)";
            $stmt = $con->prepare($sql);
            $stmt->execute([$name, $email, $phone, $gender, $national, $level, $username, $password, $registerDate]);

            echo '<div class="alert alert-success">تم انشاء حساب جديد بنجاح</div>';
        }
    }
?>

                <div class="col-lg-10 align-self-baseline" style="text-align: right !important;">
                 
				   <form method="post" class="form p-5 rounded border border-primary">
                       <div>
                                <label for="name" class="text-light">الاسم *</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <span id="name-error" class="error-message"></span>
                            </div>

                        <div>
                                <label for="email" class="text-light">البريد الالكتروني *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <span id="email-error" class="error-message"></span>
                            </div>

                        <div>
                                <label for="phone" class="text-light">رقم الهاتف *</label>
                                <input type="text" class="form-control" id="phone" name="phone" required pattern="^05\d{8}$" title="يجب أن يحتوي رقم الهاتف على 10 أرقام ويبدأ بـ 05">
                                <span id="phone-error" class="error-message"></span>
                            </div>

                        <div>
                            <label for="gender" class="text-light col-form-label">الجنس *</label>
                            <div class="form-control" id="gender-radio">
                                <label><input type="radio" name="gender" value="m" required> ذكر</label>
                                <label><input type="radio" name="gender" value="f" required> أنثى</label>
                            </div>
                        </div>

                        <div>
                            <label for="national" class="text-light col-form-label">رقم السجل المدني *</label>
                            <input type="text" class="form-control" id="national" name="national" required pattern="^\d{10}$" title="يجب أن يحتوي رقم السجل المدني على 10 أرقام">
                        </div>

                        <div>
                            <label for="level" class="text-light col-form-label">المستوى *</label>
                            <select class="form-control" id="level" name="level" required>
                                <option value="">-- اختر المستوى --</option>
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?php echo $i; ?>">المستوى <?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div>
                            <label for="username" class="text-light col-form-label">اسم المستخدم *</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
 <div>
                                <label for="password" class="text-light">كلمة المرور *</label>
                                <input type="password" class="form-control" id="password" name="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}" title="يجب أن تحتوي كلمة المرور على 8 رموز على الأقل، حرف كبير، حرف صغير، ورقم، ورمز خاص">
                                <span id="password-error" class="error-message"></span>
                            </div>

                        <div class="mt-3">
                            <button type="submit" name="register" class="btn btn-primary">تسجيل</button>
                            <a href="login.php" class="link-light">لديك حساب بالفعل؟</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Footer-->
    <footer class="bg-light py-5 border-top border-primary">
        <div class="container px-4 px-lg-5">
            <div class="small text-center text-dark">جميع الحقوق محفوظة &copy; 2024 - وحدة التدريب التعاوني</div>
        </div>
    </footer>

    <!-- سكربتات JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // تحقق من الاسم (3 حروف على الأقل)
            $('#name').on('input', function () {
                let name = $(this).val();
                if (name.length < 3) {
                    $('#name-error').text('يجب إدخال 3 حروف على الأقل');
                } else {
                    $('#name-error').text('');
                }
            });

            // تحقق من البريد الإلكتروني
            $('#email').on('input', function () {
                let email = $(this).val();
                let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    $('#email-error').text('يرجى إدخال بريد إلكتروني صحيح');
                } else {
                    $('#email-error').text('');
                }
            });

            // تحقق من اسم المستخدم (3 رموز على الأقل)
            $('#username').on('input', function () {
                let username = $(this).val();
                if (username.length < 3) {
                    $('#username-error').text('يجب إدخال 3 رموز على الأقل');
                } else {
                    $('#username-error').text('');
                }
            });

            // تحقق من رقم الهاتف (10 أرقام يبدأ بـ 05)
            $('#phone').on('input', function () {
                let phone = $(this).val();
                let phonePattern = /^05\d{8}$/;
                if (!phonePattern.test(phone)) {
                    $('#phone-error').text('يجب أن يحتوي رقم الهاتف على 10 أرقام ويبدأ بـ 05');
                } else {
                    $('#phone-error').text('');
                }
            });

            // تحقق من كلمة المرور (8 أحرف، 1 حرف كبير، 1 حرف صغير، 1 رقم، ورمز خاص)
            $('#password').on('input', function () {
                let password = $(this).val();
                let passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}$/;
                if (!passwordPattern.test(password)) {
                    $('#password-error').text('يجب أن تحتوي كلمة المرور على 8 رموز على الأقل، حرف كبير، حرف صغير، ورقم، ورمز خاص');
                } else {
                    $('#password-error').text('');
                }
            });

            // تحقق عند الإرسال
            $('form').on('submit', function (e) {
                if ($('.error-message:empty').length !== $('.error-message').length) {
                    e.preventDefault();
                    alert('يرجى تصحيح الأخطاء قبل الإرسال.');
                }
            });
        });
    </script>

</body>

</html>