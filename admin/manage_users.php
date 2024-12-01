<?php
session_start();

// Проверка, что пользователь является администратором
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

include '../config/db_connect.php';

// Получение списка пользователей
$stmt = $pdo->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Обработка удаления пользователя
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE idUser = :idUser");
    $stmt->execute(['idUser' => $delete_id]);
    header("Location: manage_users.php");
    exit;
}

// Обработка добавления нового администратора
if (isset($_POST['add_admin'])) {
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $fullName = trim($_POST['fullName']);

    $stmt = $pdo->prepare("INSERT INTO users (email, password, fullName, role) VALUES (:email, :password, :fullName, 'admin')");
    $stmt->execute(['email' => $email, 'password' => $password, 'fullName' => $fullName]);
    header("Location: manage_users.php");
    exit;
}

// Обработка редактирования данных пользователя
if (isset($_POST['edit_user'])) {
    $idUser = $_POST['idUser'];
    $fullName = trim($_POST['fullName']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];

    $stmt = $pdo->prepare("UPDATE users SET fullName = :fullName, email = :email, role = :role WHERE idUser = :idUser");
    $stmt->execute(['idUser' => $idUser, 'fullName' => $fullName, 'email' => $email, 'role' => $role]);
    header("Location: manage_users.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Управление пользователями</title>
</head>
<body>
    <div class="admin-panel">
        <h1>Управление пользователями</h1>

        <!-- Форма добавления нового администратора -->
        <h2>Добавить нового администратора</h2>
        <form method="POST">
            <input type="text" name="fullName" placeholder="Полное имя" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit" name="add_admin">Добавить администратора</button>
        </form>

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
                            <a href="edit_user.php?id=<?= $user['idUser'] ?>">Редактировать</a> |
                            <a href="manage_users.php?delete_id=<?= $user['idUser'] ?>" onclick="return confirm('Вы уверены, что хотите удалить этого пользователя?')">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
