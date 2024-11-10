<?php
include 'config.php';
session_start();

if (!isset($_SESSION['id'], $_SESSION['password'])) {
    header('location:../index.php');
    exit;
}

$account_id = $_SESSION['id'];

// Retrieve student data
$student = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `students` WHERE account_id = '$account_id'"));
$student_id = $student['id'] ?? null;

// Fetch all training agencies once
$training_agencies = mysqli_query($conn, "SELECT * FROM `training_agencies`");

// Fetch student desires
$student_desires = mysqli_query($conn, "SELECT * FROM `student_desires` WHERE student_id = '$student_id'");

$date = date('Y-m-d');

// Handle form submission
if (isset($_POST['submit'])) {
    // Sanitize inputs
    $desires = [
        ['id' => $_POST['desire1'], 'notice' => $_POST['notice1'], 'order' => 'first'],
        ['id' => $_POST['desire2'], 'notice' => $_POST['notice2'], 'order' => 'second'],
        ['id' => $_POST['desire3'], 'notice' => $_POST['notice3'], 'order' => 'third']
    ];

    // Check if student already has desires
    $existing_desires = mysqli_query($conn, "SELECT * FROM `student_desires` WHERE student_id = '$student_id'");

    if (mysqli_num_rows($existing_desires) > 0) {
        $_SESSION['message'] = 'لا يمكن تسجيل الرغبة مرتين لنفس المستخدم !';
        header('Location: desires.php');
        exit;
    }

    // Insert desires
    foreach ($desires as $desire) {
        $stmt = $conn->prepare("INSERT INTO `student_desires` (application_date, status, `order`, notes, student_id, training_agency_id) VALUES (?, 'pending', ?, ?, ?, ?)");
        $stmt->bind_param('sssss', $date, $desire['order'], $desire['notice'], $student_id, $desire['id']);
        $stmt->execute();
    }

    $_SESSION['message'] = 'تم اضافة الرغبه بنجاح !!';
    header('Location: desires.php');
    exit;
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

        <!-- Services-->
        <section class="page-section mt-5 d-flex justify-content-center align-items-center" style="min-height: 100vh;" id="services">
            <div class="container px-4 px-lg-5">
                <h2 class="text-center mt-0">تقديم الرغبات</h2>
                <hr class="divider" />
                <div class="row gx-4 gx-lg-5 justify-content-center align-items-center">
                    <div class="col-lg-6 col-md-6 col-12 text-center">
                        <?php if (isset($_SESSION['message'])): ?>
                            <div class="alert alert-success text-center" role="alert">
                                <?=
                                $_SESSION['message'];
                                unset($_SESSION['message']);
                                ?>
                            </div>
                        <?php endif; ?>
                        <form method="post" class="form p-5 rounded text-end">
                            <fieldset>
                                <!-- Desire 1 Dropdown -->
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="desire1" class="text-dark col-form-label">الرغبة الاولى *</label>
                                        <select class="form-control desire-dropdown" id="desire1" name="desire1" required>
                                            <option value="">-- اختر الرغبة --</option>
                                            <?php foreach ($training_agencies as $agency): ?>
                                                <option value="<?= $agency['id'] ?>"><?= htmlspecialchars($agency['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="notice1" class="text-dark col-form-label">ملاحظات</label>
                                        <input type="text" name="notice1" class="form-control" placeholder="ملاحظات">
                                    </div>
                                </div>

                                <!-- Desire 2 Dropdown -->
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="desire2" class="text-dark col-form-label">الرغبة الثانية *</label>
                                        <select class="form-control desire-dropdown" id="desire2" name="desire2" required>
                                            <option value="">-- اختر الرغبة --</option>
                                            <?php foreach ($training_agencies as $agency): ?>
                                                <option value="<?= $agency['id'] ?>"><?= htmlspecialchars($agency['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="notice2" class="text-dark col-form-label">ملاحظات</label>
                                        <input type="text" name="notice2" class="form-control" placeholder="ملاحظات">
                                    </div>
                                </div>

                                <!-- Desire 3 Dropdown -->
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="desire3" class="text-dark col-form-label">الرغبة الثالثة *</label>
                                        <select class="form-control desire-dropdown" id="desire3" name="desire3" required>
                                            <option value="">-- اختر الرغبة --</option>
                                            <?php foreach ($training_agencies as $agency): ?>
                                                <option value="<?= $agency['id'] ?>"><?= htmlspecialchars($agency['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="notice3" class="text-dark col-form-label">ملاحظات</label>
                                        <input type="text" name="notice3" class="form-control" placeholder="ملاحظات">
                                    </div>
                                </div>
                            </fieldset>
                            <button type="submit" name="submit" class="btn btn-primary mt-3">ارسال طلب <i class="bi bi-save"></i></button>
                        </form>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12 text-center">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr class="table-light">
                                        <th>الترتيب</th>
                                        <th>الرغبة</th>
                                        <th>تاريخ التقديم</th>
                                        <th>حالة الرغبة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (mysqli_num_rows($student_desires) > 0): ?>
                                        <?php
                                        while ($desire = mysqli_fetch_assoc($student_desires)):
                                            $agency = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name FROM `training_agencies` WHERE id = '{$desire['training_agency_id']}'"));
                                            ?>
                                            <tr>
                                                <td><?= $desire['order'] === 'first' ? 'الاولى' : ($desire['order'] === 'second' ? 'الثانية' : 'الثالثة') ?></td>
                                                <td><?= htmlspecialchars($agency['name'] ?? 'N/A') ?></td>
                                                <td><?= $desire['application_date'] ?></td>
                                                <td><span class="badge bg-<?= $desire['status'] === 'accepted' ? 'primary' : ($desire['status'] === 'rejected' ? 'dark' : 'warning') ?>">
                                                        <?= $desire['status'] === 'accepted' ? 'مقبولة' : ($desire['status'] === 'rejected' ? 'مرفوضة' : 'معلقة') ?>
                                                    </span></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr><td colspan="4" class="text-center">لم يتم تسجيل الرغبات بعد</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 row justify-content-center">
                        <a href="training-agencies.php" class="btn btn-primary py-2 col-7">
                            الجهات التدريبية
                        </a>
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
document.addEventListener("DOMContentLoaded", function () {
    const desireDropdowns = document.querySelectorAll(".desire-dropdown");

    desireDropdowns.forEach(dropdown => {
        dropdown.addEventListener("change", function () {
            updateDropdownOptions();
        });
    });

    function updateDropdownOptions() {
        // Gather selected values from each dropdown
        const selectedValues = Array.from(desireDropdowns).map(dropdown => dropdown.value);

        desireDropdowns.forEach(dropdown => {
            const currentValue = dropdown.value;

            // Remove all options except the placeholder
            Array.from(dropdown.options).forEach(option => {
                if (option.value === "") return;
                
                // Show option if not selected in other dropdowns or if it matches current value
                option.hidden = selectedValues.includes(option.value) && option.value !== currentValue;
            });
        });
    }
});
</script>


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