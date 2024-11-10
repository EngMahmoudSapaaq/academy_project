<?php
include('../connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $request_id = $_POST['desire_id']; // رقم الطلب المختار
    $student_id = $_POST['student_id']; // رقم الطالب
    $accepted_desire = $_POST['accepted_desire']; // رقم الجهة التدريبية
    $field_supervisor = $_POST['field_supervisor']; // رقم المشرف الميداني

    try {
        // التحقق من أن الجهة التدريبية موجودة
        $stmt_check = $con->prepare("SELECT id FROM training_agencies WHERE id = :accepted_desire");
        $stmt_check->execute([':accepted_desire' => $accepted_desire]);

        if ($stmt_check->rowCount() > 0) {
            // بدء المعاملة
            $con->beginTransaction();

            // تحديث حالة الطلب المختار إلى 'accepted'
            $stmt_update_selected = $con->prepare("UPDATE student_desires SET status = 'accepted' WHERE id = :request_id");
            $stmt_update_selected->execute([':request_id' => $request_id]);

            // تحديث حالة جميع الطلبات الأخرى لنفس الطالب إلى 'rejected'
            $stmt_update_other = $con->prepare("UPDATE student_desires SET status = 'rejected' WHERE student_id = :student_id AND id != :request_id");
            $stmt_update_other->execute([':student_id' => $student_id, ':request_id' => $request_id]);

            // تحديث بيانات الطالب في جدول students
            $stmt_update_student = $con->prepare("UPDATE students SET training_agency_id = :training_agency_id, training_admin_id = :training_admin_id WHERE id = :student_id");
            $stmt_update_student->execute([
                ':training_agency_id' => $accepted_desire,
                ':training_admin_id' => $field_supervisor,
                ':student_id' => $student_id
            ]);

            // تأكيد المعاملة
            $con->commit();

            // عرض رسالة نجاح مع إعادة التوجيه إلى صفحة الرغبات بعد عرض الرسالة
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'تم قبول الطالب!',
                        text: 'تم قبول الطالب في الرغبة المحددة بنجاح.',
                        icon: 'success',
                        confirmButtonText: 'موافق'
                    }).then(() => {
                        window.location.href = 'desires.php';
                    });
                });
            </script>
            ";
        } else {
            echo "الجهة التدريبية المحددة غير موجودة.";
        }
    } catch (PDOException $e) {
        $con->rollBack(); // التراجع عن التغييرات في حالة وجود خطأ
        echo "خطأ: " . $e->getMessage();
    }
}
?>
