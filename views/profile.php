<?php
session_start();
include '../config/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: singin.php");
    exit;
}

$stmt = $pdo->prepare("SELECT fullName, email, phoneNumber, dateOfBirth, role FROM users WHERE idUser = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Ошибка: пользователь не найден.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Профиль</title>
</head>
<body>
<?php include '../includes/header.php' ?>

<div class="profile-container">
    <h1>Профиль пользователя</h1>
    <div class="profile-info">
        <p><strong>Имя:</strong> <?= htmlspecialchars($user['fullName']); ?></p>
        <p><strong>Почта:</strong> <?= htmlspecialchars($user['email']); ?></p>
        <p><strong>Телефон:</strong> <?= htmlspecialchars($user['phoneNumber']); ?></p>
        <p><strong>Дата рождения:</strong> <?= htmlspecialchars($user['dateOfBirth']); ?></p>
        <p><strong>Роль:</strong> <?= htmlspecialchars($user['role']); ?></p>
    </div>
    
    <form action="../session/logout.php" method="POST">
        <button type="submit" class="logout-btn">Выйти</button>
    </form>
</div>
<?php include '../includes/footer.html'?>
</body>
</html>
