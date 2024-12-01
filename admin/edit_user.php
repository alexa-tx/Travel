<?php
session_start();

// Проверка, что пользователь является администратором
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

include '../config/db_connect.php';

// Получение данных пользователя для редактирования
if (isset($_GET['id'])) {
    $idUser = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE idUser = :idUser");
    $stmt->execute(['idUser' => $idUser]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    header("Location: manage_users.php");
    exit;
}

// Обработка редактирования данных пользователя
if (isset($_POST['edit_user'])) {
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
    <title>Редактирование пользователя</title>
</head>
<body>
    <div class="admin-panel">
        <h1>Редактировать пользователя</h1>
        <form method="POST">
            <input type="text" name="fullName" value="<?= $user['fullName'] ?>" placeholder="Полное имя" required>
            <input type="email" name="email" value="<?= $user['email'] ?>" placeholder="Email" required>
            <select name="role">
                <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>Пользователь</option>
                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Администратор</option>
            </select>
            <button type="submit" name="edit_user">Сохранить изменения</button>
        </form>
    </div>
</body>
</html>
