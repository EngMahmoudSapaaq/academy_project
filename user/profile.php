<?php
include 'config.php';
include('../connect.php');
session_start();

$account_id = $_SESSION['id'] ?? null;
$password = $_SESSION['password'] ?? null;

if (!$account_id || !$password) {
    header('location:../index.php');
    exit;
}

// Fetch student information securely
$stmt = $conn->prepare("SELECT * FROM `students` WHERE account_id = ?");
$stmt->bind_param("i", $account_id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

$student_id = $student['id'] ?? null;
$major_id = $student['major_id'] ?? null;

// Fetch major information
$stmtMajor = $conn->prepare("SELECT * FROM `majors` WHERE id = ?");
$stmtMajor->bind_param("i", $major_id);
$stmtMajor->execute();
$major = $stmtMajor->get_result()->fetch_assoc();

function isValidPassword($password) {
    return preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/', $password);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? null;
    $passwordConfirmation = $_POST['password_confirmation'] ?? null;
    $gender = $_POST['gender'] ?? null;

    // Validate password
    if (!empty($password) && $password !== $passwordConfirmation) {
        $message = "<span style='color: red;'>كلمتا المرور غير متطابقتين</span>";
    } elseif (!empty($password) && (!isValidPassword($password) || !isValidPassword($passwordConfirmation))) {
        $message = "<span style='color: red;'>يجب أن تحتوي كلمة المرور علي الأقل علي حرف كبير وحرف صغير ورقم وعلي الأقل 8 حروف وأرقام</span>";
    } else {
        // Update student info
        $stmtUpdate = $conn->prepare("UPDATE students SET name = ?, email = ?, phone = ?, gender = ? WHERE account_id = ?");
        $stmtUpdate->bind_param("ssssi", $name, $email, $phone, $gender, $account_id);
        $stmtUpdate->execute();

        // Update account info
        if (!empty($password) && $password === $passwordConfirmation) {
            $stmtAccount = $conn->prepare("UPDATE accounts SET username = ?, password = ? WHERE id = ?");
            $stmtAccount->bind_param("ssi", $username, $password, $account_id);
        } else {
            $stmtAccount = $conn->prepare("UPDATE accounts SET username = ? WHERE id = ?");
            $stmtAccount->bind_param("si", $username, $account_id);
        }
        $stmtAccount->execute();

        $_SESSION['message'] = 'تم تحديث الملف الشخصي بنجاح';
        header('Location: profile.php');
        exit;
    }
}

// Fetch training agency information
$stmtAgency = $conn->prepare("
    SELECT ta.id, ta.name, ta.email, ta.phone, ta.level, ta.major_id, ta.citizen_number, ta.gender, ta.training_agency_id, a.username 
    FROM students ta 
    INNER JOIN accounts a ON ta.account_id = a.id 
    WHERE ta.account_id = ?
");
$stmtAgency->bind_param("i", $account_id);
$stmtAgency->execute();
$students = $stmtAgency->get_result()->fetch_assoc();

$agencyId = $students['training_agency_id'];
$stmtAgencyName = $conn->prepare("SELECT name FROM training_agencies WHERE id = ?");
$stmtAgencyName->bind_param("i", $agencyId);
$stmtAgencyName->execute();
$trainingAgency = $stmtAgencyName->get_result()->fetch_assoc();
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
                <a class="navbar-brand" href="../index.php">
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
                <h2 class="text-center mt-0">تعديل الملف الشخصي</h2>
                <hr class="divider" />

                <div class="row gx-4 gx-lg-5 justify-content-center align-items-center">
                    <div class="col-10 text-center">
                        <?php if (!empty($_SESSION['message'])): ?>
                            <div class="alert alert-success" role="alert">
                                <?= $_SESSION['message'];
                                unset($_SESSION['message']);
                                ?>
                            </div>
<?php endif; ?>

                        <form method="post" class="form p-5 rounded text-end">
                            <hr>
                            <fieldset>
                                <div>
                                    <label for="name" class="text-dark col-form-label">الاسم *</label>
                                    <input type="text" class="form-control" id="name" name="name" required value="<?= htmlspecialchars($students['name']); ?>" readonly>
                                </div>

                                <div>
                                    <label for="email" class="text-dark col-form-label">البريد الالكتروني *</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($students['email']); ?>" readonly>
                                </div>

                                <div>
                                    <label for="phone" class="text-dark col-form-label">رقم الهاتف *</label>
                                    <input type="text" pattern="(?:\+?0*?966)?0?5[0-9]{8}" title="رقم الهاتف يجب أن يحتوي على 10 أرقام" class="form-control" id="phone" name="phone" required value="<?= htmlspecialchars($students['phone']); ?>" readonly>
                                </div>

                                <div>
                                    <label for="level" class="text-dark col-form-label">المستوى *</label>
                                    <input type="text" class="form-control" id="level" required value="<?= htmlspecialchars($students['level']); ?>" readonly>
                                </div>

                                <div>
                                    <label for="gender" class="text-dark col-form-label">الجنس *</label>
                                    <input type="text" class="form-control" required value="<?= ($students['gender'] == 'm') ? 'ذكر' : 'أنثى'; ?>" readonly>
                                </div>

                                <div>
                                    <label for="citizen_number" class="text-dark col-form-label">السجل المدني *</label>
                                    <input type="text" class="form-control" id="citizen_number" required value="<?= htmlspecialchars($students['citizen_number']); ?>" readonly>
                                </div>

                                <div>
                                    <label for="major" class="text-dark col-form-label">الشعبة *</label>
                                    <input type="text" class="form-control" id="major" required value="<?= htmlspecialchars($major['term']); ?>" readonly>
                                </div>
                            </fieldset>

                            <fieldset>
                                <div>
                                    <label for="username" class="text-dark col-form-label">اسم المستخدم *</label>
                                    <div class="input-group">
                                        <span class="input-group-text rounded-end">@</span>
                                        <input type="text" class="form-control" id="username" name="username" required value="<?= htmlspecialchars($students['username']); ?>">
                                    </div>
                                </div>

                                <div>
                                    <a role="button" class="link-primary" onclick="$('#password_container').fadeIn(); $(this).hide()">هل تريد تعديل كلمة المرور؟</a>
                                </div>

                                <div id="password_container" style="display: none;">
                                    <div>
                                        <label for="password" class="text-dark col-form-label">كلمة المرور *</label>
                                        <input type="password" class="form-control" id="password" name="password" >
                                    </div>
<?php if (!empty($message)) echo $message; ?>
                                    <div>
                                        <label for="password_confirmation" class="text-dark col-form-label">تأكيد كلمة المرور *</label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                    </div>


                                </div>
                            </fieldset>
<?php if (!empty($message)) echo $message; ?>
                            <div class="mt-3">
                                <button type="submit" name="submit" class="btn btn-primary">تعديل <i class="bi bi-pen"></i></button>
                            </div>
                        </form>
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
                                        $(document).ready(function () {
                                        // Name validation (at least 3 characters)
                                        $('#name').on('input', function () {
                                        let name = $(this).val();
                                                if (name.length < 3) {
                                        $(this).next('.error').remove();
                                                $(this).after('<span class="error" style="color:red;">يجب إدخال 3 حروف على الأقل</span>');
                                        } else {
                                        $(this).next('.error').remove();
                                        }
                                        });
                                                // Email validation (standard email format)
                                                $('#email').on('input', function () {
                                        let email = $(this).val();
                                                let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                                                if (!emailPattern.test(email)) {
                                        $(this).next('.error').remove();
                                                $(this).after('<span class="error" style="color:red;">يرجى إدخال بريد إلكتروني صحيح</span>');
                                        } else {
                                        $(this).next('.error').remove();
                                        }
                                        });
                                                // Username validation (at least 3 characters)
                                                $('#username').on('input', function () {
                                        let username = $(this).val();
                                                if (username.length < 3) {
                                        $(this).next('.error').remove();
                                                $(this).after('<span class="error" style="color:red;">يجب إدخال 3 رموز على الأقل</span>');
                                        } else {
                                        $(this).next('.error').remove();
                                        }
                                        });
                                                // Phone validation (exactly 10 digits)
                                                $('#phone').on('input', function () {
                                        let phone = $(this).val();
                                                let phonePattern = /^\d{10}$/;
                                                if (!phonePattern.test(phone)) {
                                        $(this).next('.error').remove();
                                                $(this).after('<span class="error" style="color:red;">يجب أن يحتوي رقم الهاتف على 10 أرقام</span>');
                                        } else {
                                        $(this).next('.error').remove();
                                        }
                                        });
                                                // Civil ID validation (exactly 10 digits)
                                                $('#civil_id').on('input', function () {
                                        let civilId = $(this).val();
                                                let civilIdPattern = /^\d{10}$/;
                                                if (!civilIdPattern.test(civilId)) {
                                        $(this).next('.error').remove();
                                                $(this).after('<span class="error" style="color:red;">يجب أن يحتوي رقم السجل المدني على 10 أرقام</span>');
                                        } else {
                                        $(this).next('.error').remove();
                                        }
                                        });
                                                // Password validation (at least 8 characters, 1 uppercase, 1 lowercase, 1 number)
                                                $('#password').on('input', function () {
                                        let password = $(this).val();
                                                let passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
                                                if (!passwordPattern.test(password)) {
                                        $(this).next('.error').remove();
                                                $(this).after('<span class="error" style="color:red;">يجب أن تحتوي كلمة المرور على الأقل على 8 رموز، حرف كبير، حرف صغير، ورقم</span>');
                                        } else {
                                        $(this).next('.error').remove();
                                        }
                                        });
                                                // Password confirmation validation
                                                $('#password_confirmation').on('input', function () {
                                        let password = $('#password').val();
                                                let confirmPassword = $(this).val();
                                                if (confirmPassword !== password) {
                                        $(this).next('.error').remove();
                                                $(this).after('<span class="error" style="color:red;">كلمة المرور غير متطابقة</span>');
                                        } else {
                                        $(this).next('.error').remove();
                                        }
                                        });
                                                // Form submission validation
                                                $('form').on('submit', function (e) {
                                        if ($('.error').length > 0) {
                                        e.preventDefault();
                                                alert('يرجى تصحيح الأخطاء قبل الإرسال.');
                                        }
                                        });
                                                $(document).ready(function () {
                                        // Show password fields on link click
                                        $('a').on('click', function () {
                                        $('#password_container').show();
                                        });
                                        });
        </script>
    </body>

</html>