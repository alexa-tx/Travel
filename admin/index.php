<?php
session_start();

// Проверка, что пользователь является администратором
if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

include '../config/db_connect.php';

// Пример получения списка пользователей
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
</head>
<body>
    <div class="admin-panel">
        <h1>Добро пожаловать в Админскую панель!</h1>
        <nav>
            <ul>
                <li><a href="manage_users.php">Управление пользователями</a></li>
                <li><a href="manage_tours.php">Управление турами</a></li>
                <li><a href="manage_hotels.php">Управление отелями</a></li>
                <li><a href="manage_reviews.php">Управление отзывами</a></li>
                <li><a href="reports.php">Отчеты</a></li>
            </ul>
        </nav>

        <h2>Список пользователей</h2>
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
                        <td><?= $user['idUser'] ?></td>
                        <td><?= $user['fullName'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['role'] ?></td>
                        <td>
                            <a href="edit_user.php?id=<?= $user['idUser'] ?>">Редактировать</a>
                            <a href="delete_user.php?id=<?= $user['idUser'] ?>">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
