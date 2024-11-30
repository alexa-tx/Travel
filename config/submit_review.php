<?php
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Вы не авторизованы.']);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db_connect.php';
    $userId = $_SESSION['user_id'];
    $fullName = $_SESSION['fullName'];
    $reviewTitle = trim($_POST['reviewTitle']);
    $reviewContent = trim($_POST['reviewContent']);
    if (empty($reviewTitle) || empty($reviewContent)) {
        echo json_encode(['success' => false, 'message' => 'Все поля обязательны для заполнения.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO reviews (idReview, fullName, reviewTitle, reviewContent, created_at) VALUES (?, ?, ?, ?, NOW())");
        $result = $stmt->execute([$idReview, $fullName, $reviewTitle, $reviewContent]);

        if ($result) {
            echo json_encode(['success' => true, 'fullName' => $fullName]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Не удалось добавить отзыв.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Ошибка базы данных: ' . $e->getMessage()]);
    }
}
