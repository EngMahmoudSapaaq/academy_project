<?php
include('../connect.php');

if (isset($_GET['acad_id'])) {
    $acad_id = $_GET['acad_id'];
    
    $sql = $con->prepare("SELECT email, phone, gender FROM academic_admins WHERE id = :acad_id");
    $sql->bindParam(':acad_id', $acad_id, PDO::PARAM_INT);
    $sql->execute();
    
    $admin = $sql->fetch(PDO::FETCH_ASSOC);
    
    if ($admin) {
        echo json_encode([
            'success' => true,
            'email' => $admin['email'],
            'phone' => $admin['phone'],
            'gender' => $admin['gender']
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No data found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
