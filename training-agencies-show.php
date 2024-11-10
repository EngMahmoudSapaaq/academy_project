<?php
session_start();
if(isset($_SESSION['password'])){
    if($_SESSION['type'] == "unit_admin"){
        $id = $_SESSION['id'];
    } elseif($_SESSION['type'] == "trainning_supervisor"){
        $id = $_SESSION['id'];
    } elseif($_SESSION['type'] == "student"){
        $id = $_SESSION['id'];
    } elseif($_SESSION['type'] == "academic_supervisor"){
        $id = $_SESSION['id'];
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
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="css/bootstrap-icons.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400&display=swap" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/swiper.min.css">
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
                    <?php
                    if(isset($_SESSION['password'])){
                        if($_SESSION['type'] == "unit_admin"){ ?>
                            <a href="unit_admin/home.php" class="btn btn-primary">صفحتي</a>
                        <?php } elseif($_SESSION['type'] == "trainning_supervisor"){ ?>
                            <a href="training_admin/index.php" class="btn btn-primary">صفحتي</a>
                        <?php } elseif($_SESSION['type'] == "student"){ ?>
                            <a href="user/index.php" class="btn btn-primary">صفحتي</a>
                        <?php } elseif($_SESSION['type'] == "academic_supervisor"){ ?>
                            <a href="academic_admin/index.php" class="btn btn-primary">صفحتي</a>
                        <?php }
                    } else { ?>
                        <a href="login.php" class="btn btn-primary">تسجيل دخول</a>
                        <a href="register.php" class="btn btn-primary">تسجيل جديد</a>
                    <?php }
                    ?>
                </div>
            </div>
        </div>
    </nav>

    <?php
    $agency_id = isset($_GET['agency_id']) && is_numeric($_GET['agency_id']) ? intval($_GET['agency_id']) : 0;  
    include('connect.php');    
    $sql = $con->prepare("SELECT * FROM training_agencies WHERE id='$agency_id'");      
    $sql->execute();
    $rows = $sql->fetch();
    $count = $sql->rowCount();
    ?>  

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

    <section class="page-section" id="about">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-12 text-center">
                    <h2 class="mt-0">الجهة التدريبية</h2>
                    <hr class="divider divider-primary" />
                    <div class="row">
                        <div class="col-6" style="min-height: 400px; background: linear-gradient(to bottom, rgba(44,108,152, 0.8) 0%, rgba(44,108,152, 0.8) 100%), url('assets/img/majors/cs.webp'); background-position: center; background-size: cover;">
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

    <footer class="bg-light py-5 border-top border-primary">
        <div class="container px-4 px-lg-5">
            <div class="small text-center text-dark">جميع الحقوق محفوظة &copy; 2024 - وحدة التدريب التعاوني</div>
        </div>
    </footer>

    <script src="js/jquery.3.7.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
