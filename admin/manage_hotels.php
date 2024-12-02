<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

include '../config/db_connect.php';
$stmt = $pdo->query("SELECT * FROM hotel");
$hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Управление отелями</title>
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
        <h1>Управление отелями</h1>
        <a href="add_hotel.php" class="button">Добавить отель</a>
        <table>
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Страна</th>
                    <th>Город</th>
                    <th>Звезды</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hotels as $hotel): ?>
                    <tr>
                        <td><?= htmlspecialchars($hotel['hotelName']) ?></td>
                        <td><?= htmlspecialchars($hotel['country']) ?></td>
                        <td><?= htmlspecialchars($hotel['city']) ?></td>
                        <td><?= htmlspecialchars($hotel['stars']) ?></td>
                        <td>
                            <a href="edit_hotel.php?id=<?= $hotel['idHotel'] ?>">Редактировать</a>
                            <a href="delete_hotel.php?id=<?= $hotel['idHotel'] ?>" onclick="return confirm('Вы уверены, что хотите удалить этот отель?');">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php 
    include '../includes/footer.html';
    ?>
</body>
</html>
