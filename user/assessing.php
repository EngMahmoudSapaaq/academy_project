<?php
include 'config.php';
session_start();
$account_id = $_SESSION['id'];
$password = $_SESSION['password'];
if (!isset($account_id)) {
    header('location:../index.php');
}
if (!isset($password)) {
    header('location:../index.php');
}

$students = mysqli_query($conn, "SELECT * FROM `students` WHERE account_id = '$account_id'") or die('Query failed: ' . mysqli_error($conn));
$student = mysqli_fetch_assoc($students);

$student_id = $student['id'] ?? null;
$training_agency_id = $student['training_agency_id'] ?? null;
//------------------------------------------
$training_agencies = mysqli_query($conn, "SELECT * FROM `training_agencies` WHERE id = '$training_agency_id'") or die('Query failed: ' . mysqli_error($conn));
$training_agencie = mysqli_fetch_assoc($training_agencies);
if (isset($_POST['submit'])) {
    $quality = $_POST['quality'];
    $quality1 = $_POST['quality1'];
    $quality2 = $_POST['quality2'];
    $quality3 = $_POST['quality3'];
    $quality4 = $_POST['quality4'];
    $quality5 = $_POST['quality5'];
    $quality6 = $_POST['quality6'];
    $quality7 = $_POST['quality7'];
    $quality8 = $_POST['quality8'];
    $quality9 = $_POST['quality9'];
    $total_score=0;
    $total_score+=$quality+$quality1+$quality2+$quality3+$quality4+$quality5+$quality6+$quality7+$quality8+$quality9;

    
    if ($quality>0 &&$quality1>0&&$quality2>0&&$quality3>0&&$quality4>0&&$quality5>0&&$quality6>0&&$quality7>0&&$quality8>0&&$quality9>0){
        $insert = mysqli_query($conn, "UPDATE students SET  entity_evaluation = '$total_score' WHERE id = '$student_id'") or die('query failed');
     if ($insert){
          $_SESSION['message'] = 'تم التقييم بنجاح';
    header('Location: assessing.php');
    exit;
     } else {
          $_SESSION['message'] = 'هناك خطأفي التقييم';
    header('Location: assessing.php');
    exit;
     }
    } else {
         $_SESSION['message'] = 'يجب تقييم جميع الاسئلة';
    header('Location: assessing.php');
    exit;
    }
     
    
    
    
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
     <style>
    

.containers {
    display: flex;
    flex-direction: row;
    width: 90%;
    max-width: 1200px;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.header {
    width: 30%;
    text-align: center;
    background-color: #E7D2FF;
    padding: 20px;
}

.logo {
    max-height: 50px;
}

.evaluation-form {
    flex: 3;
    padding: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    font-size: 1.2rem;
    margin-bottom: 5px;
    display: block;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.evaluation-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.evaluation-table th, .evaluation-table td {
    border: 1px solid #000;
    padding: 10px;
    text-align: center;
    color: #FFF;
}

.evaluation-table th {
    background-color: #044E84;
}

.submit-btn {
    text-align: center;
}

.submit-btn button {
    padding: 10px 20px;
    background-color: #044E84;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
    color: #FFF;
}

.sidebar {
    flex: 1;
    background-color: #044E84;
    padding: 20px;
    color: white;
}

.sidebar ul {
    list-style: none;
}

.sidebar ul li {
    margin-bottom: 15px;
}

.sidebar ul li a {
    text-decoration: none;
    color: white;
    font-size: 1.1rem;
}

     </style>
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

    <!-- farmers-->
    <section class="page-section" id="about" style="margin-top: 70px;">
        <div class="container px-4 px-lg-5">
            <div class="containers">
               
                <form method="post" enctype="multipart/form-data" class="evaluation-form">
                    <h4 style="background-color: #044E84;padding: 5px;color: #FFF;text-align: center;margin-bottom: 40px;">تقييم الجهة التدريبية</h4>
                    <div class="form-group">
                        <label style="text-align: right;" for="training-place">اسم الجهة التدريبية</label>
                        <input readonly style="text-align: center;border: 2px solid #044E84;border-radius: 10px;" type="text" id="training-place" placeholder="<?=  $training_agencie['name']   ?>">
                    </div>
                     <?php if (!empty($_SESSION['message'])): ?>
                            <div class="alert alert-success" role="alert">
                                <?= $_SESSION['message'];
                                unset($_SESSION['message']);
                                ?>
                            </div>
<?php endif; ?>
        
                    <table class="evaluation-table">
                        <thead>
                            <tr>
                                <th rowspan="2">#</th>
                                <th rowspan="2">عناصر التقييم</th>
                                <th colspan="5">درجة التقييم</th>
                            </tr>
                            <tr>
                                <th>ممتاز</th>
                                <th>جيد جدا</th>
                                <th>جيد</th>
                                <th>مقبول</th>
                                <th>ضعيف</th>
                              </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="color: #000;text-align: right;">1</td>
                                <td style="color: #000;text-align: right;">جدية التدريب</td>
                                <td><input type="radio" name="quality" value="10"></td>
                                <td><input type="radio" name="quality" value="8"></td>
                                <td><input type="radio" name="quality" value="6"></td>
                                <td><input type="radio" name="quality" value="4"></td>
                                <td><input type="radio" name="quality" value="2"></td>
                            </tr>
                            <tr>
                                <td style="color: #000;text-align: right;">2</td>
                                <td style="color: #000;text-align: right;">الخبرة التي يقدمها التدريب</td>
                                <td><input type="radio" name="quality1" value="10"></td>
                                <td><input type="radio" name="quality1" value="8"></td>
                                <td><input type="radio" name="quality1" value="6"></td>
                                <td><input type="radio" name="quality1" value="4"></td>
                                <td><input type="radio" name="quality1" value="2"></td>
                            </tr>
                            <tr>
                                <td style="color: #000;text-align: right;">3</td>
                                <td style="color: #000;text-align: right;">مناسبة مكان التدريب</td>
                                <td><input type="radio" name="quality2" value="10"></td>
                                <td><input type="radio" name="quality2" value="8"></td>
                                <td><input type="radio" name="quality2" value="6"></td>
                                <td><input type="radio" name="quality2" value="4"></td>
                                <td><input type="radio" name="quality2" value="2"></td>
                            </tr>
                            <tr>
                                <td style="color: #000;text-align: right;">4</td>
                                <td style="color: #000;text-align: right;">خبرة مسؤولة التدريب</td>
                                <td><input type="radio" name="quality3" value="10"></td>
                                <td><input type="radio" name="quality3" value="8"></td>
                                <td><input type="radio" name="quality3" value="6"></td>
                                <td><input type="radio" name="quality3" value="4"></td>
                                <td><input type="radio" name="quality3" value="2"></td>
                            </tr>
                            <tr>
                                <td style="color: #000;text-align: right;">5</td>
                                <td style="color: #000;text-align: right;">جدية مسؤولة التدريب</td>
                                <td><input type="radio" name="quality4" value="10"></td>
                                <td><input type="radio" name="quality4" value="8"></td>
                                <td><input type="radio" name="quality4" value="6"></td>
                                <td><input type="radio" name="quality4" value="4"></td>
                                <td><input type="radio" name="quality4" value="2"></td>
                            </tr>
                            <tr>
                                <td style="color: #000;text-align: right;">6</td>
                                <td style="color: #000;text-align: right;">الوقت المخصص للتدريب</td>
                                <td><input type="radio" name="quality5" value="10"></td>
                                <td><input type="radio" name="quality5" value="8"></td>
                                <td><input type="radio" name="quality5" value="6"></td>
                                <td><input type="radio" name="quality5" value="4"></td>
                                <td><input type="radio" name="quality5" value="2"></td>
                            </tr>
                            <tr>
                                <td style="color: #000;text-align: right;">7</td>
                                <td style="color: #000;text-align: right;">متابعة خطة التدريب</td>
                                <td><input type="radio" name="quality6" value="10"></td>
                                <td><input type="radio" name="quality6" value="8"></td>
                                <td><input type="radio" name="quality6" value="6"></td>
                                <td><input type="radio" name="quality6" value="4"></td>
                                <td><input type="radio" name="quality6" value="2"></td>
                            </tr>
                            <tr>
                                <td style="color: #000;text-align: right;">8</td>
                                <td style="color: #000;text-align: right;">مساعدة موظفات الجهة المدربة</td>
                                <td><input type="radio" name="quality7" value="10"></td>
                                <td><input type="radio" name="quality7" value="8"></td>
                                <td><input type="radio" name="quality7" value="6"></td>
                                <td><input type="radio" name="quality7" value="4"></td>
                                <td><input type="radio" name="quality7" value="2"></td>
                            </tr>
                            <tr>
                                <td style="color: #000;text-align: right;">9</td>
                                <td style="color: #000;text-align: right;">الاستفادة من برنامج التدريب العملي</td>
                                <td><input type="radio" name="quality8" value="10"></td>
                                <td><input type="radio" name="quality8" value="8"></td>
                                <td><input type="radio" name="quality8" value="6"></td>
                                <td><input type="radio" name="quality8" value="4"></td>
                                <td><input type="radio" name="quality8" value="2"></td>
                            </tr>
                            <tr>
                                <td style="color: #000;text-align: right;">10</td>
                                <td style="color: #000;text-align: right;">مدى توافق البرنامج التدريبي مع التخصص</td>
                                <td><input type="radio" name="quality9" value="10"></td>
                                <td><input type="radio" name="quality9" value="8"></td>
                                <td><input type="radio" name="quality9" value="6"></td>
                                <td><input type="radio" name="quality9" value="4"></td>
                                <td><input type="radio" name="quality9" value="2"></td>
                            </tr>
                            <!-- Repeat similar rows for other evaluation criteria -->
                        </tbody>
                    </table>
        
                    <div class="submit-btn">
                        <button type="submit" name="submit">حفظ</button>
                    </div>
                </form>
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