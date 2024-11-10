<?php
include('../connect.php');

if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
    $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : null;
    $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : null;

    // جلب معلومات الطالب
    $sqlStudent = $con->prepare("SELECT name FROM students WHERE id = ?");
    $sqlStudent->execute([$student_id]);
    $student = $sqlStudent->fetch(PDO::FETCH_ASSOC);

    // جلب معلومات المشرف
    $sqlSupervisor = $con->prepare("SELECT name FROM training_admins WHERE id = (SELECT training_admin_id FROM students WHERE id = ?)");
    $sqlSupervisor->execute([$student_id]);
    $supervisor = $sqlSupervisor->fetch(PDO::FETCH_ASSOC);

    // جلب الحضور/الغياب بناءً على الفلترة
    $query = "SELECT * FROM student_attends WHERE student_id = ?";
    if ($from_date && $to_date) {
        $query .= " AND date >= ? AND date <= ?";
        $sqlAttendance = $con->prepare($query);
        $sqlAttendance->execute([$student_id, $from_date, $to_date]);
    } else {
        $sqlAttendance = $con->prepare($query);
        $sqlAttendance->execute([$student_id]);
    }

    $attendance = $sqlAttendance->fetchAll(PDO::FETCH_ASSOC);

    // إرسال البيانات كـ JSON
    echo json_encode([
        'student' => $student,
        'supervisor' => $supervisor,
        'attendance' => $attendance
    ]);
}
