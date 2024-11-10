<?php
include('../connect.php'); 
session_start();

if (!isset($_SESSION['id'])) {
    die("خطأ: لم يتم العثور على ID المستخدم في الجلسة.");
}

$academic_id = isset($_GET['academic_id']) ? $_GET['academic_id'] : null;

if ($academic_id !== null) {
    $query_current_models = "
        SELECT `modeling`
        FROM `trainners_models`
        WHERE `academic_id` = :academic_id
    ";
    $stmt_current_models = $con->prepare($query_current_models);
    $stmt_current_models->execute(['academic_id' => $academic_id]);
    $current_models = $stmt_current_models->fetchAll(PDO::FETCH_ASSOC); 

    echo json_encode(['models' => $current_models]);
} else {
    echo json_encode(['models' => []]);
}
?>
