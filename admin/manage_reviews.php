<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

include '../config/db_connect.php';

// Получение всех отзывов
$stmt = $pdo->query("
    SELECT 
        idReview, 
        fullName, 
        reviewTitle, 
        reviewContent, 
        created_at
    FROM reviews
    ORDER BY created_at DESC
");
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Управление отзывами</title>
    <link rel="icon" href="assets/image/logo/favicon.ico" type="image/x-icon">
</head>
<body>
<?php 
    include '../includes/header.php';
    ?>
    <div class="admin-panel">
        <h1>Управление отзывами</h1>
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
        <table>
            <thead>
                <tr>
                    <th>Имя пользователя</th>
                    <th>Заголовок отзыва</th>
                    <th>Содержание</th>
                    <th>Дата создания</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($reviews): ?>
                    <?php foreach ($reviews as $review): ?>
                        <tr>
                            <td><?= htmlspecialchars($review['fullName']) ?></td>
                            <td><?= htmlspecialchars($review['reviewTitle']) ?></td>
                            <td><?= htmlspecialchars($review['reviewContent']) ?></td>
                            <td><?= htmlspecialchars($review['created_at']) ?></td>
                            <td>
                                <a href="delete_review.php?id=<?= $review['idReview'] ?>" 
                                   onclick="return confirm('Вы уверены, что хотите удалить этот отзыв?');">
                                   Удалить
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Отзывов пока нет.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php 
    include '../includes/footer.html';
    ?>
</body>
</html>
