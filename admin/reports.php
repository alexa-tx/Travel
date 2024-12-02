<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

include '../config/db_connect.php';
$stmt = $pdo->query("SELECT COUNT(*) AS totalTours FROM tour");
$totalTours = $stmt->fetch(PDO::FETCH_ASSOC)['totalTours'];
$stmt = $pdo->query("SELECT COUNT(*) AS totalHotels FROM hotel");
$totalHotels = $stmt->fetch(PDO::FETCH_ASSOC)['totalHotels'];
$stmt = $pdo->query("SELECT COUNT(*) AS totalReviews FROM reviews");
$totalReviews = $stmt->fetch(PDO::FETCH_ASSOC)['totalReviews'];
$stmt = $pdo->query("SELECT COUNT(*) AS totalUsers FROM users");
$totalUsers = $stmt->fetch(PDO::FETCH_ASSOC)['totalUsers'];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Отчеты</title>
</head>
<body>
<?php 
    include '../includes/header.php';
    ?>
    <div class="admin-panel">
    <header class="admin-header">
        <div class="logo">Админская панель</div>
        <nav>
            <ul>
                <li><a href="manage_users.php">Пользователи</a></li>
                <li><a href="manage_tours.php">Туры</a></li>
                <li><a href="manage_hotels.php">Отели</a></li>
                <li><a href="manage_reviews.php">Отзывы</a></li>
                <li><a href="reports.php">Отчеты</a></li>
            </ul>
        </nav>
    </header>
        <h1>Отчеты</h1>
        
        <div class="reports">
            <div class="report-item">
                <h2>Туры</h2>
                <p>Общее количество туров: <strong><?= $totalTours ?></strong></p>
            </div>
            <div class="report-item">
                <h2>Отели</h2>
                <p>Общее количество отелей: <strong><?= $totalHotels ?></strong></p>
            </div>
            <div class="report-item">
                <h2>Отзывы</h2>
                <p>Общее количество отзывов: <strong><?= $totalReviews ?></strong></p>
            </div>
            <div class="report-item">
                <h2>Пользователи</h2>
                <p>Общее количество пользователей: <strong><?= $totalUsers ?></strong></p>
            </div>
        </div>
    </div>
    <?php 
    include '../includes/footer.html';
    ?>
</body>
</html>
