<?php
include '../connect.php'; // تأكد من تضمين اتصال قاعدة البيانات

$student_id = $_GET['student_id'];

// استعلام لجلب النماذج الخاصة بالطالب
$query = "SELECT modeling FROM students_models WHERE student_id = :student_id";
$stmt = $con->prepare($query);
$stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT); // استخدام bindParam هنا
$stmt->execute();

$models = $stmt->fetchAll(PDO::FETCH_ASSOC); // جلب جميع الصفوف كصفيف

echo json_encode(['models' => $models]);
