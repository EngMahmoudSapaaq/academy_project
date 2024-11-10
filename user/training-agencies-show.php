<?php
include 'config.php';
session_start();
$account_id = $_SESSION['id'];
 $password=$_SESSION['password'];
if (!isset($account_id)) {
    header('location:../index.php');
}

$students = mysqli_query($conn, "SELECT * FROM `students` WHERE account_id = '$account_id'") or die('Query failed: ' . mysqli_error($conn));
$student = mysqli_fetch_assoc($students);

$student_id = $student['id'] ?? null;

if (!isset($password)) {
    header('location:../index.php');
}

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
                    <li class="nav-item"><a class="nav-link px-3" href="desires.php">تقديم الرغبات</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link px-3 dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            الملف الاكاديمي
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-light text-end" aria-labelledby="navbarDarkDropdownMenuLink">
                          <li><a class="dropdown-item border-bottom border-top" href="absence.php">سجل الغياب</a></li>
                          <li><a class="dropdown-item border-bottom" href="weekly_reports.php">التقارير الاسبوعية</a></li>
                          <li><a class="dropdown-item border-bottom" href="ratings.php">نتائج التقييمات</a></li>
                          <li><a class="dropdown-item border-bottom" href="models.php">ارسال نماذج التدريب التعاوني</a></li>
                        </ul>
                    </li>
                </ul>
                <div>

                    <a href="notifications.php" class="btn btn-primary position-relative">
                        <i class="bi bi-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                            <span class="visually-hidden">New alerts</span>
                        </span>
                    </a>
                    <a href="assessing.php" title="تقييم الجهة" class="btn btn-primary"><i class="bi bi-star"></i></a>
                    <a href="chat.php" class="btn btn-primary"><i class="bi bi-chat-dots"></i></a>
                    <a href="profile.php" class="btn btn-primary"><i class="bi bi-person"></i></a>
                    <a href="../logout.php" class="btn btn-danger"><i class="bi bi-box-arrow-left"></i></a>
                </div>
                <div style="position: fixed; left: 0; top: 30%;"
                    onmousemove="this.querySelectorAll('.slide-btn .content').forEach((elem) => {elem.classList.remove('d-none')})"
                    onmouseleave="this.querySelectorAll('.slide-btn .content').forEach((elem) => {elem.classList.add('d-none')})">
                    <a href="index.php#about" class="btn btn-primary px-3 py-2 slide-btn d-block" style="border-radius: 0; line-height: 1.5; vertical-align: middle;">
                        <i class="bi bi-question-circle" style="font-size: larger;"></i>
                        <span class="content d-none">من نحن</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
<?php
    $agency_id = isset($_GET['agency_id']) && is_numeric($_GET['agency_id']) ? intval($_GET['agency_id']) : 0;  
    include('../connect.php');    
    $sql = $con->prepare("SELECT * FROM training_agencies WHERE id='$agency_id'");      
    $sql->execute();
    $rows = $sql->fetch();
    $count = $sql->rowCount();
    ?>  
    <!-- Masthead-->
    <header class="masthead">
        <div class="container px-4 px-lg-5 h-100">
            <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8 align-self-end">
                    <h1 class="text-white font-weight-bold">تفاصيل الجهة التدريبية</h1>
                    <hr class="divider divider-light" />
                </div>
                <div class="col-lg-8 align-self-baseline">
                    <p class="text-white-75 mb-5"><?php echo $rows['name']; ?></p>
                    <a class="btn btn-primary btn-xl" href="#about">اكتشف المزيد <i class="bi bi-arrow-90deg-down"></i></a>
                </div>                    
            </div>
        </div>
    </header>
 
    <!-- farmers-->
    <section class="page-section" id="about">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-12 text-center">
                    <h2 class="mt-0">الجهة التدريبية</h2>
                    <hr class="divider divider-primary" />
                    <div class="row">
                        <div class="col-6" style="
                                min-height: 400px;
                                background: linear-gradient(to bottom, rgba(44,108,152, 0.8) 0%, rgba(44,108,152, 0.8) 100%), url('assets/img/majors/cs.webp');
                                background-position: center;
                                background-size: cover;
                            ">
                        </div>
                        <div class="col-6 text-end" dir="rtl">
                            <div class="container">
                                <h3 class="border-bottom border-dark pb-2"><?php echo $rows['name']; ?></h3>
                                <p><?php echo $rows['address']; ?></p>
                                <h5><i class="bi bi-arrow-left"></i> شروط الالتحاق</h5>
                                <p><?php echo $rows['conditions']; ?></p> <!-- عرض الشروط هنا -->
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
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
            hoverColor: '#044e84',
            activeColor: '#8c98bb',
            useGradient: false,
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
    </script>
</body>

</html>