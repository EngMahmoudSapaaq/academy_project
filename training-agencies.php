<?php

session_start();
if(isset($_SESSION['password'])){
	
    if($_SESSION['type'] == "unit_admin"){
        
        $id = $_SESSION['id'];
        
    }elseif($_SESSION['type'] == "trainning_supervisor"){
        
        
        $id = $_SESSION['id'];
        
    }elseif($_SESSION['type'] == "student"){
        
        
        $id = $_SESSION['id'];
        
    }elseif($_SESSION['type'] == "academic_supervisor"){
        
        
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
                   <?php

                       
                        if(isset($_SESSION['password'])){

                            if($_SESSION['type'] == "unit_admin"){ ?>

                                <a href="unit_admin/home.php" class="btn btn-primary">صفحتي</a>

                          <?php  }elseif($_SESSION['type'] == "trainning_supervisor"){ ?>


                                <a href="training_admin/index.php" class="btn btn-primary">صفحتي</a>

                           <?php }elseif($_SESSION['type'] == "student"){ ?>


                                <a href="user/index.php" class="btn btn-primary">صفحتي</a>

                          <?php  }elseif($_SESSION['type'] == "academic_supervisor"){ ?>

                                     <a href="academic_admin/index.php" class="btn btn-primary">صفحتي</a>
                                

                          <?php  }
                        }else{  ?>
                    
                    <a href="login.php" class="btn btn-primary">تسجيل دخول</a>
                    <a href="register.php" class="btn btn-primary">تسجيل جديد</a>
                            
                            
                    <?php    }


                        ?>
                </div>
                <div style="position: fixed; left: 0; top: 30%;"
                    onmousemove="this.querySelectorAll('.slide-btn .content').forEach((elem) => {elem.classList.remove('d-none')})"
                    onmouseleave="this.querySelectorAll('.slide-btn .content').forEach((elem) => {elem.classList.add('d-none')})">
                    <!-- <a href="login.php" class="btn btn-primary px-3 py-2">تسجيل الدخول</a> -->
                         <?php

                        if(isset($_SESSION['password'])){

                            if($_SESSION['type'] == "unit_admin"){ ?>

                                <a href="unit_admin/home.php" class="btn btn-primary px-3 py-2 slide-btn d-block border-bottom" style="border-radius: 0; line-height: 1.5; vertical-align: middle;">
                        <i class="bi bi-person" style="font-size: larger;"></i>
                        <span class="content d-none">صفحتي</span>
                    </a>

                          <?php  }elseif($_SESSION['type'] == "trainning_supervisor"){ ?>


                                <a href="training_admin/index.php" class="btn btn-primary px-3 py-2 slide-btn d-block border-bottom" style="border-radius: 0; line-height: 1.5; vertical-align: middle;">
                        <i class="bi bi-person" style="font-size: larger;"></i>
                        <span class="content d-none">صفحتي</span>
                    </a>

                           <?php }elseif($_SESSION['type'] == "student"){ ?>


                                <a href="user/index.php" class="btn btn-primary px-3 py-2 slide-btn d-block border-bottom" style="border-radius: 0; line-height: 1.5; vertical-align: middle;">
                        <i class="bi bi-person" style="font-size: larger;"></i>
                        <span class="content d-none">صفحتي</span>
                    </a>

                          <?php  }elseif($_SESSION['type'] == "academic_supervisor"){ ?>

                                     <a href="academic_admin/index.php" class="btn btn-primary px-3 py-2 slide-btn d-block border-bottom" style="border-radius: 0; line-height: 1.5; vertical-align: middle;">
                        <i class="bi bi-person" style="font-size: larger;"></i>
                        <span class="content d-none">صفحتي</span>
                    </a>
                                

                          <?php  }
                        }else{  ?>
                    
                    <a href="login.php" class="btn btn-primary px-3 py-2 slide-btn d-block border-bottom" style="border-radius: 0; line-height: 1.5; vertical-align: middle;">
                        <i class="bi bi-lock" style="font-size: larger;"></i>
                        <span class="content d-none">تسجيل الدخول</span>
                    </a>
                    <a href="register.php" class="btn btn-primary px-3 py-2 slide-btn d-block border-bottom" style="border-radius: 0; line-height: 1.5; vertical-align: middle;">
                        <i class="bi bi-person-plus" style="font-size: larger;"></i>
                        <span class="content d-none">تسجيل جديد</span>
                    </a>
                            
                            
                    <?php    }


                        ?>
                    <!-- <a onclick="toast()" class="btn btn-primary px-3 py-2 slide-btn d-block border-bottom" style="border-radius: 0; line-height: 1.5; vertical-align: middle;">
                        <i class="bi bi-chat-dots" style="font-size: larger;"></i>
                        <span class="content d-none">محادثات</span>
                    </a> -->
                    <a href="home.php#about" class="btn btn-primary px-3 py-2 slide-btn d-block" style="border-radius: 0; line-height: 1.5; vertical-align: middle;">
                        <i class="bi bi-question-circle" style="font-size: larger;"></i>
                        <span class="content d-none">من نحن</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Masthead-->
    <header class="masthead masthead-agency">
        <div class="container px-4 px-lg-5 h-100">
            <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8 align-self-end">
                    <h1 class="text-white font-weight-bold">الجهات التدريبية بجامعة نجران</h1>
                    <hr class="divider divider-light" />
                </div>
                <div class="col-lg-8 align-self-baseline">
                    <a class="btn btn-primary btn-xl" href="#agencies">اكتشف المزيد <i class="bi bi-arrow-90deg-down"></i></a>
                </div>                
            </div>
        </div>
    </header>

    <!-- farmers-->
    <section class="page-section" id="agencies">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-12 text-center">
                    <h2 class="mt-0">الجهات التدريبية</h2>
                    <hr class="divider divider-primary" />
                    <!-- Slider main container -->
                    <div class="pb-3">
                        <!-- Additional required wrapper -->
                        <div class="row justify-content-center" style="row-gap: 50px; column-gap: 50px;">
                            <!-- Slides -->
                            <?php

                            include('connect.php');  
                            $sql = $con->prepare("SELECT * FROM training_agencies");      
                            $sql->execute();
                            $rows = $sql->fetchAll();

                            foreach($rows as $pat)
                            {

                            ?>     
                            <div class="card col-5" dir="ltr" style="
                                background: linear-gradient(to bottom, rgba(44,108,152, 0.8) 0%, rgba(44,108,152, 0.8) 100%), url('assets/img/majors/cs.webp');
                                background-position: center;
                                background-size: cover;
                            ">
                                <div class="card-body text-light" style="height: 300px; display: flex; flex-direction: column; justify-content: center;">
                                    <h5 class="card-title"><?php echo $pat['name']; ?></h5>
                                    <a href="training-agencies-show.php?agency_id=<?php echo $pat['id']; ?>" class="btn btn-light">عرض التفاصيل</a>
                                </div>
                            </div>
                            <?php  } ?>

                        </div>

                        <!-- If we need pagination -->
                        <div class="swiper-pagination mt-3" style="position: relative;"></div>

                        <!-- If we need navigation buttons -->
                        <!-- <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div> -->

                        <!-- If we need scrollbar -->
                        <!-- <div class="swiper-scrollbar"></div> -->
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
    </script>
</body>

</html>