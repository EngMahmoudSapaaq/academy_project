<?php
include('../connect.php');

if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    // جلب الدرجات من جدول students_scores بناءً على student_id
    $sql = $con->prepare("SELECT * FROM student_scores WHERE student_id = ?");
    $sql->execute([$student_id]);
    $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

    // إرجاع البيانات بصيغة JSON
    echo json_encode($rows);
}
