<?php

if (isset($_POST['add'])) {
	
    $acad_id = $_POST['acad_id'];

    // جلب بيانات المشرف الأكاديمي الحالي وتحديث حالته إلى "rejected"
    $sqle = $con->prepare("SELECT academic_admins.* , accounts.username FROM academic_admins INNER JOIN accounts ON accounts.id=academic_admins.account_id WHERE accounts.status='activated' AND academic_admins.id='$acad_id'");
    $sqle->execute();
    $rowse = $sqle->fetch();
    
    $name = $rowse['name'];
    $account_id = $rowse['account_id'];

    // تحديث حالة المشرف الحالي
    $stmt12 = $con->prepare("UPDATE accounts SET status = 'rejected' WHERE id = ?");
    $stmt12->execute(array($account_id));

    // متابعة تنفيذ باقي كود الإدخال
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    $username = $_POST['username'];
    $gender = $_POST['gender'];
    $term = $_POST['term'];
    $year = $_POST['year'];
    
    if ($password == $confirm) {
        include('../connect.php');
        
        // التحقق من عدم تكرار البريد الإلكتروني أو رقم الهاتف أو اسم المستخدم
        $sqlPL = $con->prepare("SELECT * FROM unit_admins WHERE (email='$email' AND phone='$phone') OR (email='$email' OR phone='$phone')");
        $sqlPL->execute();
        $countPL = $sqlPL->rowCount();

        // التحقق من عدم تكرار اسم المستخدم
        $sqlUserCheck = $con->prepare("SELECT * FROM accounts WHERE username = ?");
        $sqlUserCheck->execute([$username]);
        $userExists = $sqlUserCheck->rowCount() > 0;

        if ($countPL > 0 || $userExists) {
            echo '
                <div class="container" dir="rtl" style="margin-top:80px;color:#000">
                    <div class="alert alert-danger role="alert" style="color:#000">
                        هذا المشرف موجود من قبل أو اسم المستخدم مستخدم بالفعل
                    </div>
                </div>';
        } else {
            // إضافة حساب المشرف الجديد في جدول accounts
            $sql = "INSERT INTO accounts (username, password, status, type) VALUES ('$username', '$password', 'activated', 'unit_admin')";
            $con->exec($sql);

            // جلب آخر معرف تم إنشاؤه للمشرف الجديد في جدول accounts
            $sqlccuu = $con->prepare("SELECT id FROM accounts ORDER BY id DESC LIMIT 1");
            $sqlccuu->execute();
            $rowshh = $sqlccuu->fetch();
            $account_id = $rowshh['id'];

            // إضافة المشرف الجديد في جدول unit_admins باستخدام account_id
            $sql1 = "INSERT INTO unit_admins (name, email, phone, gender, term, year, account_id) VALUES ('$name', '$email', '$phone', '$gender', '$term', '$year', '$account_id')";
            $con->exec($sql1);

            // إظهار التنبيه وتسجيل الخروج
            echo '
                <script>
                    alert("تم تعيين مشرف جديد، ونخبرك أنه مع الأسف تم تعطيل حسابك الحالي.");
                    window.location.href = "../logout.php";
                </script>';
        }
    } else {
        echo '
            <div class="container" dir="rtl" style="margin-top:80px;color:#000">
                <div class="alert alert-danger role="alert" style="color:#000">
                    كلمة المرور غير متطابقة
                </div>
            </div>';
    }
}

?>