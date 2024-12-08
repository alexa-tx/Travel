<?php
session_start();
include '../config/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    header("Location: ../session/singin.php");
    exit;
}

$stmt = $pdo->query("SELECT o.idOrder, o.fullName, o.phone, o.email, o.departureCity, 
                            o.departureDate, o.returnDate, o.destination, o.hotel, o.stars, 
                            o.seats, o.totalPrice, o.approvalStatus, u.fullName as userName
                     FROM orders o
                     LEFT JOIN users u ON o.idUser = u.idUser
                     ORDER BY o.approvalStatus DESC, o.idOrder ASC");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Менеджер: Управление заказами</title>
    <link rel="icon" href="assets/image/logo/favicon.ico" type="image/x-icon">
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="manager-container">
    <h1>Управление заявками</h1>

    <?php if ($orders): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Имя клиента</th>
                    <th>Телефон</th>
                    <th>Почта</th>
                    <th>Город отправления</th>
                    <th>Дата отправления</th>
                    <th>Дата возвращения</th>
                    <th>Направление</th>
                    <th>Отель</th>
                    <th>Звезды</th>
                    <th>Места</th>
                    <th>Цена</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody id="orderTable">
                <?php foreach ($orders as $order): ?>
                    <tr id="order-<?= $order['idOrder']; ?>">
                        <td><?= htmlspecialchars($order['idOrder']); ?></td>
                        <td><?= htmlspecialchars($order['fullName']); ?></td>
                        <td><?= htmlspecialchars($order['phone']); ?></td>
                        <td><?= htmlspecialchars($order['email']); ?></td>
                        <td><?= htmlspecialchars($order['departureCity']); ?></td>
                        <td><?= htmlspecialchars($order['departureDate']); ?></td>
                        <td><?= htmlspecialchars($order['returnDate']); ?></td>
                        <td><?= htmlspecialchars($order['destination']); ?></td>
                        <td><?= htmlspecialchars($order['hotel']); ?></td>
                        <td><?= htmlspecialchars($order['stars']); ?></td>
                        <td><?= htmlspecialchars($order['seats']); ?></td>
                        <td><?= htmlspecialchars($order['totalPrice']); ?> руб.</td>
                        <td class="status"><?= htmlspecialchars($order['approvalStatus']); ?></td>
                        <td>
                            <?php if ($order['approvalStatus'] === 'pending'): ?>
                                <button class="btn-approve" data-id="<?= $order['idOrder']; ?>" data-status="approved">Одобрить</button>
                                <button class="btn-reject" data-id="<?= $order['idOrder']; ?>" data-status="rejected">Отклонить</button>
                            <?php else: ?>
                                <span><?= $order['approvalStatus'] === 'approved' ? 'Одобрено' : 'Отклонено'; ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Заявок пока нет.</p>
    <?php endif; ?>
</div>

<script>
    $(document).ready(function () {
        $('.btn-approve, .btn-reject').on('click', function () {
            const idOrder = $(this).data('id');
            const status = $(this).data('status');
            const row = $('#order-' + idOrder);

            $.ajax({
                url: 'update_status.php',
                type: 'POST',
                data: { idOrder, status },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        row.find('.status').text(status === 'approved' ? 'Одобрено' : 'Отклонено');
                        row.find('button').remove(); // Удаляем кнопки после обновления
                    } else {
                        alert('Ошибка: ' + response.message);
                    }
                },
                error: function () {
                    alert('Ошибка при отправке запроса');
                }
            });
        });
    });
</script>

<?php include '../includes/footer.html'; ?>
</body>
</html>
