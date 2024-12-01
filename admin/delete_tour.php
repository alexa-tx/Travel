<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

include '../config/db_connect.php';

// Проверяем, передан ли ID тура
if (isset($_GET['id'])) {
    $idTour = $_GET['id'];

    // Удаляем изображение тура, если оно есть
    $stmt = $pdo->prepare("SELECT image FROM tour WHERE idTour = :idTour");
    $stmt->execute(['idTour' => $idTour]);
    $tour = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($tour && !empty($tour['image'])) {
        $imagePath = '../' . $tour['image'];
        if (file_exists($imagePath)) {
            unlink($imagePath); // Удаляем файл изображения
        }
    }

    // Удаляем тур из базы данных
    $stmt = $pdo->prepare("DELETE FROM tour WHERE idTour = :idTour");
    $stmt->execute(['idTour' => $idTour]);

    // Перенаправление на страницу управления турами
    header("Location: manage_tours.php");
    exit;
} else {
    // Если ID не передан, возвращаемся на страницу управления турами
    header("Location: manage_tours.php");
    exit;
}
?>
