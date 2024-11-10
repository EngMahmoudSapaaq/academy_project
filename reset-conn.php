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
            <a class="navbar-brand" href="index.php">
                <img src="assets/img/logo3.jpeg" width="100">
            </a>
            <a class="navbar-brand" href="index.php">وحدة التدريب التعاوني</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto my-2 my-lg-0">
                    <li class="nav-item"><a class="nav-link px-3" href="index.php">الصفحة الرئيسية</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="training-agencies.php">الجهات التدريبية</a></li>
                    
                </ul>
                <div>
                    <a href="login.php" class="btn btn-primary">تسجيل دخول</a>
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
                    <!-- <a href="#" onclick="toast()" class="btn btn-primary px-3 py-2 slide-btn d-block border-bottom" style="border-radius: 0; line-height: 1.5; vertical-align: middle;">
                        <i class="bi bi-chat-dots" style="font-size: larger;"></i>
                        <span class="content d-none">محادثات</span>
                    </a> -->
                    <a href="index.php#about" class="btn btn-primary px-3 py-2 slide-btn d-block" style="border-radius: 0; line-height: 1.5; vertical-align: middle;">
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
                    <h1 class="text-white font-weight-bold">تغيير كلمة المرور</h1>
                    <hr class="divider divider-light" />
                </div>
                <?php

                session_start();

                include('connect.php');



                //print_r($_POST);
                $email = $_POST['email'];	
                $sql=$con->prepare("SELECT * FROM students WHERE 
                email=?");
                $sql->execute(array($email));
                $row=$sql->fetch();
                //print_r($row);
                $count=$sql->rowCount();

                //echo "<br>".$count;
                if($email != ""){


                if($count>0){

                $sql = $con->prepare("SELECT * FROM students");
                $sql->execute();
                $rows = $sql->fetchAll();

                foreach($rows as $pat)
                {

                    if($email == $pat["email"])
                    {

                        $_SESSION['student'] = $pat['id'];
                        $_SESSION['student1'] = $pat['account_id'];
                        $_SESSION['academic'] = NULL;
                        $_SESSION['academic1'] = NULL;
                        $_SESSION['training'] = NULL;
                        $_SESSION['training1'] = NULL;
                        $_SESSION['admin'] = NULL;
                        $_SESSION['admin1'] = NULL;
                        
                        $otp = rand(100000,999999);
                        $_SESSION['otp'] = $otp;

                        require "Mail/phpmailer/PHPMailerAutoload.php";
                        $mail = new PHPMailer(true);

                        $mail->isSMTP();
                        $mail->Host='smtp.gmail.com';
                        $mail->Port=587;
                        $mail->SMTPAuth=true;
                        $mail->SMTPSecure='tls';

                        $mail->Username='';
                        $mail->Password='';

                        $mail->setFrom('', 'OTP Verification');
                        $mail->addAddress($pat['email']);

                        $mail->isHTML(true);
                        $mail->Subject="رمز التحقق الخاص بك";
                        $mail->Body="<p>عزيزي الطالب \ ".$pat['name'].", </p> <h3>رمز التحقق الخاص بك هو  $otp <br></h3>
                        <br><br>
                        <p>With regrads,</p>
                        <b>التدريب الميداني</b>";

                        if($mail->send()){
                             header('Location:reset_pass.php');
                        }
                        else{
                            echo '
                <div class="container" dir="rtl" style="margin-top:80px;color:#000">
                    <div class="alert alert-danger role="alert" style="color:#000">
                        فشل ارسال رمز اللتحقق عبر بريدك الالكتروني
                    </div>
                    <div class="col-lg-8 align-self-baseline" style="text-align: right !important;">
                    <form action="reset-conn.php" method="post" id="form" style="background-color: rgba(255, 255, 255, .1);" class="form p-5 rounded border border-primary">

                        <div>
                            <label for="email" class="text-light col-form-label">البريد الالكتروني *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">ارسال</button>
                        </div>
                    </form>
                </div>
                ';
                        }
                        
                    }
                }
                $con=null;
                //echo "wrong password or email";




                } else{




                /* Start Doctor */


                $email = $_POST['email'];	
                $sql=$con->prepare("SELECT * FROM academic_admins WHERE 
                email=?");
                $sql->execute(array($email));
                $row=$sql->fetch();
                //print_r($row);
                $count=$sql->rowCount();

                //echo "<br>".$count;
                if($email != ""){


                if($count>0){

                $sql = $con->prepare("SELECT * FROM academic_admins");
                $sql->execute();
                $rows = $sql->fetchAll();

                foreach($rows as $pat)
                {

                    if($email == $pat["email"])
                    {

                        $_SESSION['student'] = NULL;
                        $_SESSION['student1'] = NULL;
                        $_SESSION['academic'] = $pat['id'];
                        $_SESSION['academic1'] = $pat['account_id'];
                        $_SESSION['training'] = NULL;
                        $_SESSION['training1'] = NULL;
                        $_SESSION['admin'] = NULL;
                        $_SESSION['admin1'] = NULL;

                         $otp = rand(100000,999999);
                        $_SESSION['otp'] = $otp;

                        require "Mail/phpmailer/PHPMailerAutoload.php";
                        $mail = new PHPMailer(true);

                        $mail->isSMTP();
                        $mail->Host='smtp.gmail.com';
                        $mail->Port=587;
                        $mail->SMTPAuth=true;
                        $mail->SMTPSecure='tls';

                        $mail->Username='';
                        $mail->Password='';

                        $mail->setFrom('', 'OTP Verification');
                        $mail->addAddress($pat['email']);

                        $mail->isHTML(true);
                        $mail->Subject="رمز التحقق الخاص بك";
                        $mail->Body="<p>عزيزي المشرف الاكاديمي \ ".$pat['name'].", </p> <h3>رمز التحقق الخاص بك هو  $otp <br></h3>
                        <br><br>
                        <p>With regrads,</p>
                        <b>التدريب الميداني</b>";

                        if($mail->send()){
                             header('Location:reset_pass.php');
                        }
                        else{
                            echo '
                <div class="container" dir="rtl" style="margin-top:80px;color:#000">
                    <div class="alert alert-danger role="alert" style="color:#000">
                        فشل ارسال رمز اللتحقق عبر بريدك الالكتروني
                    </div>
                    <div class="col-lg-8 align-self-baseline" style="text-align: right !important;">
                    <form action="reset-conn.php" method="post" id="form" style="background-color: rgba(255, 255, 255, .1);" class="form p-5 rounded border border-primary">

                        <div>
                            <label for="email" class="text-light col-form-label">البريد الالكتروني *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">ارسال</button>
                        </div>
                    </form>
                </div>
                ';
                        }
                    }
                }
                $con=null;
                //echo "wrong password or email";




                } else{


                /* Start Recep */


                $email = $_POST['email'];	
                $sql=$con->prepare("SELECT * FROM training_admins WHERE 
                email=?");
                $sql->execute(array($email));
                $row=$sql->fetch();
                //print_r($row);
                $count=$sql->rowCount();

                //echo "<br>".$count;
                if($email != ""){


                if($count>0){

                $sql = $con->prepare("SELECT * FROM training_admins");
                $sql->execute();
                $rows = $sql->fetchAll();

                foreach($rows as $pat)
                {

                    if($email == $pat["email"])
                    {

                        $_SESSION['student'] = NULL;
                        $_SESSION['student1'] = NULL;
                        $_SESSION['academic'] = NULL;
                        $_SESSION['academic1'] = NULL;
                        $_SESSION['training'] = $pat['id'];
                        $_SESSION['training1'] = $pat['account_id'];
                        $_SESSION['admin'] = NULL;
                        $_SESSION['admin1'] = NULL;

                         $otp = rand(100000,999999);
                        $_SESSION['otp'] = $otp;

                        require "Mail/phpmailer/PHPMailerAutoload.php";
                        $mail = new PHPMailer(true);

                        $mail->isSMTP();
                        $mail->Host='smtp.gmail.com';
                        $mail->Port=587;
                        $mail->SMTPAuth=true;
                        $mail->SMTPSecure='tls';

                        $mail->Username='';
                        $mail->Password='';

                        $mail->setFrom('', 'OTP Verification');
                        $mail->addAddress($pat['email']);

                        $mail->isHTML(true);
                        $mail->Subject="رمز التحقق الخاص بك";
                        $mail->Body="<p>عزيزي المشرف الميداني \ ".$pat['name'].", </p> <h3>رمز التحقق الخاص بك هو  $otp <br></h3>
                        <br><br>
                        <p>With regrads,</p>
                        <b>التدريب الميداني</b>";

                        if($mail->send()){
                             header('Location:reset_pass.php');
                        }
                        else{
                            echo '
                <div class="container" dir="rtl" style="margin-top:80px;color:#000">
                    <div class="alert alert-danger role="alert" style="color:#000">
                        فشل ارسال رمز اللتحقق عبر بريدك الالكتروني
                    </div>
                    <div class="col-lg-8 align-self-baseline" style="text-align: right !important;">
                    <form action="reset-conn.php" method="post" id="form" style="background-color: rgba(255, 255, 255, .1);" class="form p-5 rounded border border-primary">

                        <div>
                            <label for="email" class="text-light col-form-label">البريد الالكتروني *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">ارسال</button>
                        </div>
                    </form>
                </div>
                ';
                        }
                    }
                }
                $con=null;
                //echo "wrong password or email";




                } else{



                /* Start Recep */


                $email = $_POST['email'];	
                $sql=$con->prepare("SELECT * FROM unit_admins WHERE 
                email=?");
                $sql->execute(array($email));
                $row=$sql->fetch();
                //print_r($row);
                $count=$sql->rowCount();

                //echo "<br>".$count;
                if($email != ""){


                if($count>0){

                $sql = $con->prepare("SELECT * FROM unit_admins");
                $sql->execute();
                $rows = $sql->fetchAll();

                foreach($rows as $pat)
                {

                    if($email == $pat["email"])
                    {

                        $_SESSION['student'] = NULL;
                        $_SESSION['student1'] = NULL;
                        $_SESSION['academic'] = NULL;
                        $_SESSION['academic1'] = NULL;
                        $_SESSION['training'] = NULL;
                        $_SESSION['training1'] = NULL;
                        $_SESSION['admin'] = $pat['id'];
                        $_SESSION['admin1'] = $pat['account_id'];

                         $otp = rand(100000,999999);
                        $_SESSION['otp'] = $otp;

                        require "Mail/phpmailer/PHPMailerAutoload.php";
                        $mail = new PHPMailer(true);

                        $mail->isSMTP();
                        $mail->Host='smtp.gmail.com';
                        $mail->Port=587;
                        $mail->SMTPAuth=true;
                        $mail->SMTPSecure='tls';

                        $mail->Username='';
                        $mail->Password='';

                        $mail->setFrom('', 'OTP Verification');
                        $mail->addAddress($pat['email']);

                        $mail->isHTML(true);
                        $mail->Subject="رمز التحقق الخاص بك";
                        $mail->Body="<p>عزيزي مشرف الوحدة \ ".$pat['name'].", </p> <h3>رمز التحقق الخاص بك هو  $otp <br></h3>
                        <br><br>
                        <p>With regrads,</p>
                        <b>التدريب الميداني</b>";

                        if($mail->send()){
                             header('Location:reset_pass.php');
                        }
                        else{
                            echo '
                <div class="container" dir="rtl" style="margin-top:80px;color:#000">
                    <div class="alert alert-danger role="alert" style="color:#000">
                        فشل ارسال رمز اللتحقق عبر بريدك الالكتروني
                    </div>
                    <div class="col-lg-8 align-self-baseline" style="text-align: right !important;">
                    <form action="reset-conn.php" method="post" id="form" style="background-color: rgba(255, 255, 255, .1);" class="form p-5 rounded border border-primary">

                        <div>
                            <label for="email" class="text-light col-form-label">البريد الالكتروني *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">ارسال</button>
                        </div>
                    </form>
                </div>
                ';
                        }
                    }
                }
                $con=null;
                //echo "wrong password or email";


                }else{



        echo '
                <div class="container" dir="rtl" style="margin-top:80px;color:#000">
                    <div class="alert alert-danger role="alert" style="color:#000">
                        البريد الالكتروني خطأ من فضلك أعد المحاولة مرة أخرى
                    </div>
                    <div class="col-lg-8 align-self-baseline" style="text-align: right !important;">
                    <form action="reset-conn.php" method="post" id="form" style="background-color: rgba(255, 255, 255, .1);" class="form p-5 rounded border border-primary">

                        <div>
                            <label for="email" class="text-light col-form-label">البريد الالكتروني *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">ارسال</button>
                        </div>
                    </form>
                </div>
                ';




                }}else{


                /*include('logout.php');
                include('login.php');*/

                //echo "Not found UserName or password";
                }



                /* End Recep */




                }}else{


                /*include('logout.php');
                include('login.php');*/

                //echo "Not found UserName or password";
                }



                /* End Doctor */








                }}else{


                /*include('logout.php');
                include('login.php');*/

                //echo "Not found UserName or password";
                }}}




                ?>
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
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- <script src="js/sb-forms-0.4.1.js"></script> -->
    <!-- swiper -->
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
                    $('#form').attr('action', './unit_admin/index.php');
                    break;
                default:
                    $('#form').attr('action', './index.php');
                    break;
            }
        }
    </script>
</body>

</html>
<?php

ob_end_flush();

?>