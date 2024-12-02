<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

include '../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hotelName = trim($_POST['hotelName']);
    $country = trim($_POST['country']);
    $city = trim($_POST['city']);
    $stars = (int)$_POST['stars'];
    $description = trim($_POST['description']);

    $stmt = $pdo->prepare("
        INSERT INTO hotel (hotelName, country, city, stars, description)
        VALUES (:hotelName, :country, :city, :stars, :description)
    ");
    $stmt->execute([
        'hotelName' => $hotelName,
        'country' => $country,
        'city' => $city,
        'stars' => $stars,
        'description' => $description,
    ]);

    header("Location: manage_hotels.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Добавить отель</title>
</head>
<body>
<?php 
    include '../includes/header.php';
    ?>
    <div class="admin-panel">
        <h1>Добавить отель</h1>
        <form method="POST">
            <input type="text" name="hotelName" placeholder="Название отеля" required>
            <input type="text" name="country" placeholder="Страна" required>
            <input type="text" name="city" placeholder="Город" required>
            <input type="number" name="stars" min="1" max="5" placeholder="Количество звезд" required>
            <textarea name="description" placeholder="Описание отеля"></textarea>
            <button type="submit">Добавить</button>
        </form>
    </div>
    <?php 
    include '../includes/footer.html';
    ?>
</body>
</html>
