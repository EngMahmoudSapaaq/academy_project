<?php
include '../connect.php'; // تأكد من تضمين اتصال قاعدة البيانات

$train_id = $_GET['train_id'];

// استعلام لجلب النماذج الخاصة بالطالب
$query = "SELECT modeling FROM trainners_models WHERE trainner_id = :trainner_id";
$stmt = $con->prepare($query);
$stmt->bindParam(':trainner_id', $train_id, PDO::PARAM_INT); // استخدام bindParam هنا
$stmt->execute();

$models = $stmt->fetchAll(PDO::FETCH_ASSOC); // جلب جميع الصفوف كصفيف

echo json_encode(['models' => $models]);
