<?php
session_start();
include '../config/db_connect.php';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE idUser = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $user = null;
}

$idTour = isset($_GET['id']) ? $_GET['id'] : null;

if ($idTour) {
    $stmt = $pdo->prepare("
    SELECT t.*, h.stars, h.hotelName AS hotel_name, h.country AS hotel_country
    FROM tour t
    JOIN hotel h ON t.idHotel = h.idHotel
    WHERE t.idTour = :idTour
");
$stmt->execute(['idTour' => $idTour]);

    $stmt->execute(['idTour' => $idTour]);
    $tour = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$tour) {
        echo "Ошибка: Тур не найден.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orion | Оформление тура</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include '../includes/header.php'; ?>

<section class="tour-selection-section">
    <h2>Оформление тура</h2>
    <form class="tour-selection-form" id="tourForm" method="POST" action="../config/submit-tour.php">
        <input type="hidden" name="idTour" value="<?= $idTour ?>"> 
        
        <div class="form-group">
            <label for="fullName">ФИО</label>
            <input type="text" id="fullName" name="fullName" 
                placeholder="Введите ваше ФИО" 
                value="<?= $user ? htmlspecialchars($user['fullName']) : '' ?>" 
                required>
        </div>
        <div class="form-group">
            <label for="phone">Телефон</label>
            <input type="tel" id="phone" name="phone" 
                placeholder="+7 999 999 99 99" 
                value="<?= $user ? htmlspecialchars($user['phoneNumber']) : '' ?>" 
                required>
        </div>
        <div class="form-group">
            <label for="email">Почта</label>
            <input type="email" id="email" name="email" 
                placeholder="example@mail.com" 
                value="<?= $user ? htmlspecialchars($user['email']) : '' ?>" 
                required>
        </div>
        <div class="form-group">
            <label for="departureCity">Откуда</label>
            <input type="text" id="departureCity" name="departureCity" placeholder="Город отправления" required>
        </div>
        <div class="form-group">
            <label for="departureDate">Когда вылет</label>
            <input type="date" id="departureDate" name="departureDate" required>
        </div>
        <div class="form-group">
            <label for="returnDate">Когда приезд обратно</label>
            <input type="date" id="returnDate" name="returnDate" required>
        </div>
        <div class="form-group">
            <label for="destination">Куда (страна и город)</label>
            <input type="text" id="destination" name="destination" value="<?= htmlspecialchars($tour['hotel_country']) ?>" readonly>
        </div>
        <div class="form-group">
            <label for="hotel">Отель</label>
            <input type="text" id="hotel" name="hotel" value="<?= htmlspecialchars($tour['hotel_name']) ?>" readonly>
        </div>
        <div class="form-group">
            <label for="stars">Количество звезд</label>
            <div class="star-rating">
                <?php 
                    $stars = $tour['stars'];
                    htmlspecialchars($stars);
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $stars) {
                            echo '<span class="star filled">&#9733;</span>';
                        } else {
                            echo '<span class="star">&#9734;</span>';
                        }
                    }
                ?>
            </div>
        </div>
        <button type="submit" class="btn">Отправить заявку</button>
    </form>
</section>

<?php include '../includes/footer.html'; ?>

</body>
</html>
