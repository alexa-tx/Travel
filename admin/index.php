<?php
session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

include '../config/db_connect.php';

$stmt = $pdo->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Админская панель</title>
    <link rel="icon" href="assets/image/logo/favicon.ico" type="image/x-icon">
</head>
<body>
    <?php 
    include '../includes/header.php';
    ?>
    <div class="admin-panel">
        <h1>Добро пожаловать в Админскую панель!</h1>
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

        <h2>Список пользователей</h2>
        <?php if ($users && count($users) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Роль</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['idUser']) ?></td>
                        <td><?= htmlspecialchars($user['fullName']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                        <td>
                            <a href="edit_user.php?id=<?= htmlspecialchars($user['idUser']) ?>">Редактировать</a>
                            <a href="delete_user.php?id=<?= htmlspecialchars($user['idUser']) ?>">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>Пользователи не найдены.</p>
        <?php endif; ?>
    </div>
    <?php 
    include '../includes/footer.html';
    ?>
</body>
</html>
