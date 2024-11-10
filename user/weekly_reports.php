<?php
include 'config.php';
session_start();

// Redirect if not logged in
function checkAuthentication() {
    if (!isset($_SESSION['id']) || !isset($_SESSION['password'])) {
        header('Location: ../index.php');
        exit;
    }
}

// Fetch student information based on account ID using prepared statements
function getStudentInfo($conn, $account_id) {
    $stmt = $conn->prepare("SELECT * FROM `students` WHERE account_id = ?");
    $stmt->bind_param("s", $account_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Fetch weekly reports for a student using prepared statements
function getWeeklyReports($conn, $student_id, $training_admin_id) {
    $stmt = $conn->prepare("SELECT * FROM `student_weekly_reports` WHERE student_id = ? AND trainning_supevisor_id = ?");
    $stmt->bind_param("ii", $student_id, $training_admin_id);
    $stmt->execute();
    return $stmt->get_result();
}

// Insert a new weekly report using prepared statements
function insertWeeklyReport($conn, $student_id, $training_admin_id, $title, $file, $notes) {
    $date = date('Y-m-d');
    $stmt = $conn->prepare("INSERT INTO `student_weekly_reports` (title, attachments, notes, student_id, report_date, trainning_supevisor_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssisi", $title, $file, $notes, $student_id, $date, $training_admin_id);
    return $stmt->execute();
}

checkAuthentication();
$account_id = $_SESSION['id'];
$student = getStudentInfo($conn, $account_id);
$student_id = $student['id'] ?? null;
$training_admin_id = $student['training_admin_id'] ?? null;
$student_weekly_reports = getWeeklyReports($conn, $student_id, $training_admin_id);

// Handle form submission
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $notes = $_POST['notes'];
    $file = $_FILES['file']['name'];
    $file_tmp_name = $_FILES['file']['tmp_name'];
    $file_folder = '../files/' . $file;

    if (insertWeeklyReport($conn, $student_id, $training_admin_id, $title, $file, $notes)) {
        if (move_uploaded_file($file_tmp_name, $file_folder)) {
            $_SESSION['message'] = 'تم رفع التقرير الاسبوعي بنجاح';
        } else {
            $_SESSION['message'] = 'حدث خطأ في تحميل الملف.';
        }
    } else {
        $_SESSION['message'] = 'حدث خطأ في الرفع.';
    }
    header('Location: weekly_reports.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>وحدة التدريب التعاوني</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link href="css/bootstrap-icons.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="css/swiper.min.css">
        <link rel="stylesheet" href="css/star-rating-svg.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.6.1/toastify.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>

    <body id="page-top">
        <!-- Navigation and other HTML content here -->
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
                         onmousemove="this.querySelectorAll('.slide-btn .content').forEach((elem) => {
                                     elem.classList.remove('d-none')
                                 })"
                         onmouseleave="this.querySelectorAll('.slide-btn .content').forEach((elem) => {elem.classList.add('d-none')})">
                        <a href="index.php#about" class="btn btn-primary px-3 py-2 slide-btn d-block" style="border-radius: 0; line-height: 1.5; vertical-align: middle;">
                            <i class="bi bi-question-circle" style="font-size: larger;"></i>
                            <span class="content d-none">من نحن</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Services Section -->
        <section class="page-section mt-5 d-flex justify-content-center align-items-center" style="min-height: 100vh;" id="services">
            <div class="container px-4 px-lg-5">
                <h2 class="text-center mt-0">رفع التقارير الاسبوعية</h2>
                <hr class="divider" />
                <div class="row gx-4 gx-lg-5 justify-content-center align-items-center">
                    <div class="col-lg-4 col-md-6 col-12 text-center">
                        <?php if (isset($_SESSION['message'])): ?>
                            <div class="alert alert-success text-center" role="alert">
                                <?=
                                $_SESSION['message'];
                                unset($_SESSION['message']);
                                ?>
                            </div>
<?php endif; ?>
                        <form method="post" class="form p-5 rounded text-end" enctype="multipart/form-data">
                            <fieldset>
                                <div>
                                    <label for="title" class="text-dark col-form-label">عنوان التقرير *</label>
                                    <input type="text" name="title" class="form-control" id="title" required>
                                </div>
                                <div>
                                    <label for="file" class="text-dark col-form-label">المرفقات *</label>
                                    <input type="file" class="form-control" id="file" name="file" required>
                                </div>
                                <div>
                                    <label for="notes" class="text-dark col-form-label">الملاحظات</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="5"></textarea>
                                </div>
                            </fieldset>
                            <div class="mt-3">
                                <button type="submit" name="submit" class="btn btn-primary">ارسال <i class="bi bi-save"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-8 col-md-6 col-12 text-center">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr class="table-light">
                                        <th>#</th>
                                        <th>عنوان التقرير</th>
                                        <th>المرفقات</th>
                                        <th>تاريخ الارفاق</th>
                                        <th>الملاحظات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($student_weekly_reports->num_rows > 0): ?>
    <?php while ($report = $student_weekly_reports->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= $report['id']; ?></td>
                                                <td><?= htmlspecialchars($report['title']); ?></td>
                                                <td>
                                                    <a href="../files/<?= htmlspecialchars($report['attachments']); ?>" class="btn btn-primary" download="<?= htmlspecialchars($report['attachments']); ?>">
                                                        التقرير.pdf <i class="bi bi-download"></i>
                                                    </a>
                                                </td>
                                                <td><?= $report['report_date']; ?></td>
                                                <td><?= !empty($report['notes']) ? htmlspecialchars($report['notes']) : 'لا يوجد ملاحظات'; ?></td>
                                            </tr>
                                        <?php endwhile; ?>
<?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">لا يوجد تقارير متوفرة</td>
                                        </tr>
<?php endif; ?>
                                </tbody>
                            </table>
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
                                     onClick: function () {} // Callback after click
                                 }).showToast();
                             }
        </script>
    </body>

</html>