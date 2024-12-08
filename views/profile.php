<?php
session_start();
include '../config/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: singin.php");
    exit;
}

//получаем данные пользователя
$stmt = $pdo->prepare("SELECT fullName, email, phoneNumber, dateOfBirth, role FROM users WHERE idUser = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Ошибка: пользователь не найден.";
    exit;
}

//проверка на поступление новых заявок на оформление тура
$newOrdersCount = 0;
if ($user['role'] === 'manager') {
    $newOrdersStmt = $pdo->prepare("
        SELECT COUNT(*) AS newOrdersCount 
        FROM orders 
        WHERE approvalStatus = 'pending'
    ");
    $newOrdersStmt->execute();
    $newOrders = $newOrdersStmt->fetch(PDO::FETCH_ASSOC);
    $newOrdersCount = $newOrders['newOrdersCount'] ?? 0;
}

//получаем из базы данных всю информацию об оформленных туров
$toursStmt = $pdo->prepare("
    SELECT 
        o.idOrder, 
        o.departureCity, 
        o.departureDate, 
        o.returnDate, 
        o.destination, 
        o.hotel, 
        o.stars, 
        o.seats, 
        o.totalPrice, 
        o.approvalStatus 
    FROM orders o
    WHERE o.idUser = :id
    ORDER BY o.departureDate DESC
");
$toursStmt->execute(['id' => $_SESSION['user_id']]);
$tours = $toursStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Профиль</title>
    <link rel="icon" href="assets/image/logo/favicon.ico" type="image/x-icon">
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="profile-container">
    <h1>Профиль пользователя</h1>
    <div class="profile-info">
        <p><strong>Имя:</strong> <?= htmlspecialchars($user['fullName']); ?></p>
        <p><strong>Почта:</strong> <?= htmlspecialchars($user['email']); ?></p>
        <p><strong>Телефон:</strong> <?= htmlspecialchars($user['phoneNumber']); ?></p>
        <p><strong>Дата рождения:</strong> <?= htmlspecialchars($user['dateOfBirth']); ?></p>
    </div>

    <!-- уведомление о новых заявок -->
    <?php if ($user['role'] === 'manager' && $newOrdersCount > 0): ?>
        <div class="notification">
            <p>У вас есть <?= $newOrdersCount ?> новых заявок на туры!</p>
        </div>
    <?php endif; ?>

    <!-- разделение ролей -->
    <?php if ($user['role'] === 'admin'): ?>
        <a href="../admin/index.php" class="btn">Панель администратора</a>
    <?php elseif ($user['role'] === 'manager'): ?>
        <a href="../manager/requests.php" class="btn">Просмотр заявок</a>
    <?php endif; ?>

    <!-- вывод туров, если пользователь их оформлял -->
    <?php if ($user['role'] === 'user'): ?>
        <div class="user-tours">
            <h2>Мои туры</h2>
            <?php if ($tours): ?>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Город отправления</th>
                            <th>Дата отправления</th>
                            <th>Дата возвращения</th>
                            <th>Направление</th>
                            <th>Отель</th>
                            <th>Звезды</th>
                            <th>Места</th>
                            <th>Цена</th>
                            <th>Статус</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tours as $tour): ?>
                            <tr>
                                <td><?= htmlspecialchars($tour['idOrder']); ?></td>
                                <td><?= htmlspecialchars($tour['departureCity']); ?></td>
                                <td><?= htmlspecialchars($tour['departureDate']); ?></td>
                                <td><?= htmlspecialchars($tour['returnDate']); ?></td>
                                <td><?= htmlspecialchars($tour['destination']); ?></td>
                                <td><?= htmlspecialchars($tour['hotel']); ?></td>
                                <td><?= htmlspecialchars($tour['stars']); ?>★</td>
                                <td><?= htmlspecialchars($tour['seats']); ?></td>
                                <td><?= htmlspecialchars($tour['totalPrice']); ?> руб.</td>
                                <td>
                                    <?php
                                    if ($tour['approvalStatus'] === 'approved') {
                                        echo '<span class="status-approved">Одобрено</span>';
                                    } elseif ($tour['approvalStatus'] === 'rejected') {
                                        echo '<span class="status-rejected">Отклонено</span>';
                                    } else {
                                        echo '<span class="status-pending">В ожидании</span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>У вас пока нет оформленных туров.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <form action="../session/logout.php" method="POST">
        <button type="submit" class="logout-btn">Выйти</button>
    </form>
</div>
<?php include '../includes/footer.html'; ?>
</body>
</html>
