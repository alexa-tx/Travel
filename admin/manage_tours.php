<?php
include '../config/db_connect.php';

try {
    // Запрос для получения информации о турах и связанных отелях
    $stmt = $pdo->prepare("
        SELECT 
            t.idTour, 
            t.country AS tour_country, 
            t.tourDescription, 
            t.genre, 
            t.price, 
            t.image, 
            h.hotelName, 
            h.city AS hotel_city, 
            h.stars
        FROM 
            tour t
        LEFT JOIN 
            hotel h ON t.idHotel = h.idHotel
    ");
    $stmt->execute();
    $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Ошибка: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление турами</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="icon" href="assets/image/logo/favicon.ico" type="image/x-icon">
</head>
<body>
<?php 
    include '../includes/header.php';
    ?>
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
<h1>Управление турами</h1>


<table border="1" cellpadding="10" cellspacing="0">
    <thead>
    <tr>
        <th>ID Тура</th>
        <th>Страна</th>
        <th>Описание</th>
        <th>Жанр</th>
        <th>Цена</th>
        <th>Изображение</th>
        <th>Отель</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($tours)): ?>
        <?php foreach ($tours as $tour): ?>
            <tr>
                <td><?= htmlspecialchars($tour['idTour']) ?></td>
                <td><?= htmlspecialchars($tour['tour_country']) ?></td>
                <td><?= htmlspecialchars($tour['tourDescription']) ?></td>
                <td><?= htmlspecialchars($tour['genre']) ?></td>
                <td><?= htmlspecialchars($tour['price']) ?> руб.</td>
                <td>
                    <img src="<?= htmlspecialchars($tour['image']) ?>" alt="Изображение тура" width="100">
                </td>
                <td>
                    <?php if (!empty($tour['hotelName'])): ?>
                        <?= htmlspecialchars($tour['hotelName']) ?> (<?= htmlspecialchars($tour['hotel_city']) ?>, <?= htmlspecialchars($tour['stars']) ?>★)
                    <?php else: ?>
                        <i>Отель не указан</i>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="edit_tour.php?id=<?= $tour['idTour'] ?>">Редактировать</a> |
                    <a href="delete_tour.php?id=<?= $tour['idTour'] ?>" onclick="return confirm('Удалить этот тур?');">Удалить</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="8" style="text-align: center;">Нет доступных туров</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<a href="add_tour.php">Добавить новый тур</a>
<?php 
    include '../includes/footer.html';
    ?>
</body>
</html>
