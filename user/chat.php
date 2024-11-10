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

//------------------------------------------
$major_id=$student['major_id'] ?? null;
$majors = mysqli_query($conn, "SELECT * FROM `majors` WHERE id = '$major_id'") or die('Query failed: ' . mysqli_error($conn));
$major = mysqli_fetch_assoc($majors);
$academic_admin_id=$major['academic_admin_id'] ?? null;

$chats = null;

    $academic_admins = mysqli_query($conn, "SELECT * FROM `academic_admins` WHERE id = '$academic_admin_id'") or die('Query failed: ' . mysqli_error($conn));
    $academic_admin = mysqli_fetch_assoc($academic_admins);
    
    
    $query = "SELECT * FROM `messages_a_to_s`
          WHERE (academic_supervisor_id = ? AND student_id = ?)
          ORDER BY student_id DESC";

    $stmt = $conn->prepare($query);

    $stmt->bind_param("ss", $academic_admin_id, $student_id);

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
            $insert = mysqli_query($conn, "INSERT INTO `messages_a_to_s`(content, academic_supervisor_id, student_id, message_date,medication_time,type) VALUES('$massege', '$academic_admin_id','$student_id', '$date', '$time', 'S_To_A')") or die('query failed');
            header('location: chat.php');
        } else {
            header('location: chat.php');
        }
    }

?>


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

    <!-- Services-->
    <section class="page-section mt-5 d-flex justify-content-center align-items-center" style="min-height: 100vh;" id="services">
        <div class="container px-4 px-lg-5">
            <h2 class="text-center mt-0">محادثة مع أ/ <?php echo $academic_admin['name'];   ?></h2>
            <hr class="divider" />
            <div class="row gx-4 gx-lg-5 justify-content-center align-items-center">
                <div class="col-12 text-center">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">تفاصيل المحادثة مع <strong><?php echo $academic_admin['name'];   ?></strong></h4>

                            <div id="chat_messages"  class="chat-container">
                                <?php
                                            if ($chats && mysqli_num_rows($chats) > 0) {
                                                while ($chat = mysqli_fetch_assoc($chats)) {
                                                    $type = $chat['type'];


                                                    if ($type == 'S_To_A') {
                                                        echo '<div class="chat-message bg-primary text-end py-5 px-3 rounded my-2" style="color: white">
                                        <strong>أنا:</strong>' . $chat['content'] . '
                                    </div>';
                                                    } elseif ($type == 'A_To_S') {
                                                        echo '<div class="chat-message bg-light text-end py-5 px-3 rounded my-2" style="color: white">
                                        <strong>' . $academic_admin['name'] . ':</strong>' . $chat['content'] . '
                                    </div>';
                                                    }
                                                }
                                            } else {
                                                echo ' <div class="chat-message bg-primary text-end py-5 px-3 rounded my-2">
                                        <strong>لا يوجد محادثات بعد .</strong> 
                                    </div>';
                                            }
                                            ?>

                                <form method="post" enctype="multipart/form-data"  class="form d-flex align-items-center justify-content-between gap-2">
                                                <input type="text" name="massege" placeholder="اكتب رسالتك هنا..." class="form-control text-end" required>
                                                <button type="submit" name="submit" class="btn btn-success text-nowrap">ارسال <i class="fa fa-paper-plane"></i></button>
                                            </form>
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