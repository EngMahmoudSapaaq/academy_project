<?php
include('../connect.php'); // الاتصال بقاعدة البيانات

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $assigned_agency = $_POST['assigned_agency'];
    $field_supervisor_agency = $_POST['field_supervisor_agency'];

    try {
        // التحقق من وجود الطالب والجهة في النظام
        $stmt_check_student = $con->prepare("SELECT id FROM students WHERE id = :student_id");
        $stmt_check_student->execute([':student_id' => $student_id]);

        $stmt_check_agency = $con->prepare("SELECT id FROM training_agencies WHERE id = :assigned_agency");
        $stmt_check_agency->execute([':assigned_agency' => $assigned_agency]);

        if ($stmt_check_student->rowCount() > 0 && $stmt_check_agency->rowCount() > 0) {
            // بدء المعاملة
            $con->beginTransaction();

            // تحديث الطلبات السابقة إلى "rejected"
            $stmt_update_all = $con->prepare("UPDATE student_desires SET status = 'rejected' WHERE student_id = :student_id");
            $stmt_update_all->execute([':student_id' => $student_id]);

            // إضافة سجل جديد كـ "accepted"
            $stmt_insert_new = $con->prepare("INSERT INTO student_desires (application_date, status, `order`, notes, student_id, training_agency_id)
                                              VALUES (NOW(), 'accepted', 'four', NULL, :student_id, :training_agency_id)");
            $stmt_insert_new->execute([
                ':student_id' => $student_id,
                ':training_agency_id' => $assigned_agency
            ]);

            // تحديث جدول الطلاب
            $stmt_update_student = $con->prepare("UPDATE students SET training_agency_id = :training_agency_id, training_admin_id = :training_admin_id WHERE id = :student_id");
            $stmt_update_student->execute([
                ':training_agency_id' => $assigned_agency,
                ':training_admin_id' => $field_supervisor_agency,
                ':student_id' => $student_id
            ]);

            // تأكيد المعاملة
            $con->commit();

            // رسالة النجاح
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'تم إسناد الجهة!',
                        text: 'تم إسناد جهة جديدة بنجاح.',
                        icon: 'success',
                        confirmButtonText: 'موافق'
                    }).then(() => {
                        window.location.href = 'desires.php';
                    });
                });
            </script>
            ";
        } else {
            echo "رقم الطالب أو الجهة غير موجودين.";
        }
    } catch (PDOException $e) {
        $con->rollBack(); // التراجع في حالة حدوث خطأ
        echo "خطأ: " . $e->getMessage();
    }
}
?>
