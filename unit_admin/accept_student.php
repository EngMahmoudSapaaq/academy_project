<?php
include('../connect.php');  

// التحقق من account_id من الرابط
$account_id = isset($_GET['account_id']) && is_numeric($_GET['account_id']) ? intval($_GET['account_id']) : 0;

if ($account_id > 0) {
    // 1. تحديث حالة الطالب إلى "activated" في جدول student_registeration_requests
    $updateStatus = $con->prepare("UPDATE student_registeration_requests SET status = 'activated' WHERE id = ?");
    $updateStatus->execute([$account_id]);

    // جلب بيانات الطالب من جدول student_registeration_requests
    $stmt = $con->prepare("SELECT * FROM student_registeration_requests WHERE id = ?");
    $stmt->execute([$account_id]);
    $studentData = $stmt->fetch();

    if ($studentData) {
        // 2. إضافة بيانات الطالب في جدول accounts
        $insertAccount = $con->prepare("INSERT INTO accounts (username, password, status, type) VALUES (?, ?, 'activated', 'student')");
        $insertAccount->execute([$studentData['username'], $studentData['password']]);
        $newAccountId = $con->lastInsertId();

        // 3. إضافة بيانات الطالب في جدول students وربطه بـ account_id
        $insertStudent = $con->prepare("INSERT INTO students (email, name, phone, gender, citizen_number, account_id, level) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insertStudent->execute([
            $studentData['email'], 
            $studentData['name'], 
            $studentData['phone_number'], 
            $studentData['gender'], 
            $studentData['national_id'], 
            $newAccountId, 
            $studentData['level']
        ]);

        // رسالة النجاح وإعادة التوجيه
        echo '<script>
                alert("تمت الإضافة بنجاح");
                window.location.href = "students.php";
              </script>';
    } else {
        echo '<div class="alert alert-danger">حدث خطأ: الطالب غير موجود.</div>';
    }
} else {
    echo '<div class="alert alert-danger">حدث خطأ: المعرف غير صالح.</div>';
}
?>
