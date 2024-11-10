<?php

ob_start();

?>
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
</head>

<body id="page-top">

    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.html">
                <img src="assets/img/logo3.jpeg" width="100">
            </a>
            <a class="navbar-brand" href="home.php">وحدة التدريب التعاوني</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto my-2 my-lg-0">
                    <li class="nav-item"><a class="nav-link px-3" href="home.php">الصفحة الرئيسية</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="training-agencies.php">الجهات التدريبية</a></li>
                    
                </ul>
                <div>
                    <a href="register.php" class="btn btn-primary">تسجيل جديد</a>
                </div>
                <div style="position: fixed; left: 0; top: 30%;"
                    onmousemove="this.querySelectorAll('.slide-btn .content').forEach((elem) => {elem.classList.remove('d-none')})"
                    onmouseleave="this.querySelectorAll('.slide-btn .content').forEach((elem) => {elem.classList.add('d-none')})">
                    <!-- <a href="login.php" class="btn btn-primary px-3 py-2">تسجيل الدخول</a> -->
                    <a href="login.php" class="btn btn-primary px-3 py-2 slide-btn d-block border-bottom" style="border-radius: 0; line-height: 1.5; vertical-align: middle;">
                        <i class="bi bi-lock" style="font-size: larger;"></i>
                        <span class="content d-none">تسجيل الدخول</span>
                    </a>
                    <a href="register.php" class="btn btn-primary px-3 py-2 slide-btn d-block border-bottom" style="border-radius: 0; line-height: 1.5; vertical-align: middle;">
                        <i class="bi bi-person-plus" style="font-size: larger;"></i>
                        <span class="content d-none">تسجيل جديد</span>
                    </a>
                    <a href="home.php#about" class="btn btn-primary px-3 py-2 slide-btn d-block" style="border-radius: 0; line-height: 1.5; vertical-align: middle;">
                        <i class="bi bi-question-circle" style="font-size: larger;"></i>
                        <span class="content d-none">من نحن</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Masthead-->
    <header class="masthead masthead-login" style="display: flex; flex-direction: column; justify-content: space-around;">
        <div class="container px-4 px-lg-5 h-100">
            <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8 align-self-end">
                    <h1 class="text-white font-weight-bold">تسجيل الدخول</h1>
                    <hr class="divider divider-light" />
                </div>
<?php
ob_start();
session_start();
include('connect.php');

if (isset($_POST['login'])) {
    $email = $_POST['username'];
    $password = $_POST['password'];
    $type = $_POST['type'];

    if (!empty($email) && !empty($password) && in_array($type, ['student', 'unit_admin', 'academic_supervisor', 'trainning_supervisor'])) {
        $sql = $con->prepare("SELECT * FROM accounts WHERE username = ? AND password = ? AND type = ?");
        $sql->execute([$email, $password, $type]);
        $user = $sql->fetch();

        if ($user) {
            if ($user['status'] == 'activated') {
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['password'] = $password;
                $_SESSION['type'] = $type;

                $redirects = [
                    'student' => 'user/index.php',
                    'unit_admin' => 'unit_admin/home.php',
                    'academic_supervisor' => 'academic_admin/index.php',
                    'trainning_supervisor' => 'training_admin/index.php',
                ];
                header('Location: ' . $redirects[$type]);
                exit;
            } else {
                $statusMessages = [
                    'pending' => 'أنت قيد المعالجة من قبل مدير النظام',
                    'rejected' => 'أنت مرفوض من قبل مدير النظام'
                ];
                echo '<div class="container" style="margin-top:80px;"><div class="alert alert-danger">' . $statusMessages[$user['status']] . '</div></div>';
            }
        } else {
            echo '<div class="container" style="margin-top:80px;"><div class="alert alert-danger">اسم المستخدم، كلمة المرور، أو نوع الحساب غير صحيح. يرجى المحاولة مرة أخرى.</div></div>';
        }
    }
}
?>



                <div class="col-lg-8 align-self-baseline" style="text-align: right !important;">
                    <form method="post" id="form" style="background-color: rgba(255, 255, 255, .1);" class="form p-5 rounded border border-primary">
                        
                        
                        
                        <div>
                            <label for="username" class="text-light col-form-label">نوع الحساب *</label>
                            <select type="text" name="type" class="form-control" required>
                                <option>اختر نوع الحساب</option>
                                <option value="student">متدرب</option>
                                <option value="unit_admin">مشرف وحدة</option>
                                <option value="academic_supervisor">مشرف اكاديمي</option>
                                <option value="trainning_supervisor">مشرف ميداني</option>
                            </select>
                        </div>

                        <div>
                            <label for="username" class="text-light col-form-label">اسم المستخدم *</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>

                        <div>
                            <label for="password" class="text-light col-form-label">كلمة المرور *</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                            <a href="password-forget-email.php" class="link-light">هل نسيت كلمة المرور؟</a>
                        </div>
                        
                        <div class="mt-3">
                            <button type="submit" name="login" class="btn btn-primary">تسجيل الدخول</button>
                            &nbsp;
                            <a href="register.php" class="link-light">ليس لديك حساب؟</a>
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

    <script src="js/jquery.3.7.min.js"></script>
    <script src="js/jquery.star-rating-svg.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.6.1/toastify.min.js" integrity="sha512-79j1YQOJuI8mLseq9icSQKT6bLlLtWknKwj1OpJZMdPt2pFBry3vQTt+NZuJw7NSd1pHhZlu0s12Ngqfa371EA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Bootstrap core JS-->
    <script src="js/bootstrap.bundle.min.js"></script>
    <!-- SimpleLightbox plugin JS-->
    <script src="js/smipleLightbox.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/jquery.validate.additional-methods.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <script src="js/swiper.min.js"></script>

    <script>
        const swiper = new Swiper('.swiper', {
            // Optional parameters
            direction: 'horizontal',

            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
            },

            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

            // And if we need scrollbar
            scrollbar: {
                el: '.swiper-scrollbar',
            },

            autoplay: {
                delay: 5000,
            },

            slidesPerView: 3,
            spaceBetween: 20,
        });

        $(".my-rating-4").starRating({
            totalStars: 5,
            starShape: 'rounded',
            starSize: 40,
            emptyColor: 'lightgray',
            hoverColor: '#c34e2e',
            activeColor: '#8c98bb',
            useGradient: false,
            readOnly: true,
        });

        function toast() {
            Toastify({
                text: "سجل دخولك اولا",
                duration: 3000,
                destination: "login.php",
                newWindow: false,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                  background: "linear-gradient(to right, rgba(44,108,152, 0.8), rgba(44,108,152, 0.8))",
                },
                onClick: function(){} // Callback after click
            }).showToast();
        }
    
        function changeAction(user_type) {
            switch (user_type) {
                case 'unit_admin':
                    $('#form').attr('action', './unit_admin/home.php');
                    break;
                case 'academic_admin':
                    $('#form').attr('action', './academic_admin/home.php');
                    break;
                case 'training_admin':
                    $('#form').attr('action', './training_admin/index.php');
                    break;
                case 'user':
                    $('#form').attr('action', './academic_admin/index.php');
                    break;
                default:
                    $('#form').attr('action', './home.php');
                    break;
            }
        }
    </script>
</body>

</html>
<?php

ob_end_flush();

?>