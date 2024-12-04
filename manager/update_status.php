<?php
session_start();
include '../config/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    echo json_encode(['status' => 'error', 'message' => 'Доступ запрещен']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idOrder'], $_POST['status'])) {
    $idOrder = $_POST['idOrder'];
    $status = $_POST['status'];

    if (in_array($status, ['approved', 'rejected'])) {
        $updateStmt = $pdo->prepare("UPDATE orders SET approvalStatus = :status WHERE idOrder = :idOrder");
        $updateStmt->execute(['status' => $status, 'idOrder' => $idOrder]);

        echo json_encode(['status' => 'success', 'idOrder' => $idOrder, 'newStatus' => $status]);
        exit;
    }
}

echo json_encode(['status' => 'error', 'message' => 'Неверные данные']);
exit;
