<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

include '../config/db_connect.php';

if (isset($_GET['id'])) {
    $idHotel = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM hotel WHERE idHotel = :idHotel");
    $stmt->execute(['idHotel' => $idHotel]);
    $hotel = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$hotel) {
        header("Location: manage_hotels.php");
        exit;
    }
} else {
    header("Location: manage_hotels.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hotelName = trim($_POST['hotelName']);
    $country = trim($_POST['country']);
    $city = trim($_POST['city']);
    $stars = (int)$_POST['stars'];
    $description = trim($_POST['description']);

    $stmt = $pdo->prepare("
        UPDATE hotel 
        SET hotelName = :hotelName, country = :country, city = :city, stars = :stars, description = :description
        WHERE idHotel = :idHotel
    ");
    $stmt->execute([
        'hotelName' => $hotelName,
        'country' => $country,
        'city' => $city,
        'stars' => $stars,
        'description' => $description,
        'idHotel' => $idHotel,
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
    <title>Редактировать отель</title>
</head>
<body>
<?php 
    include '../includes/header.php';
    ?>
    <div class="admin-panel">
        <h1>Редактировать отель</h1>
        <form method="POST">
            <input type="text" name="hotelName" value="<?= htmlspecialchars($hotel['hotelName']) ?>" required>
            <input type="text" name="country" value="<?= htmlspecialchars($hotel['country']) ?>" required>
            <input type="text" name="city" value="<?= htmlspecialchars($hotel['city']) ?>" required>
            <input type="number" name="stars" min="1" max="5" value="<?= htmlspecialchars($hotel['stars']) ?>" required>
            <textarea name="description"><?= htmlspecialchars($hotel['description']) ?></textarea>
            <button type="submit">Сохранить</button>
        </form>
    </div>
    <?php 
    include '../includes/footer.html';
    ?>
</body>
</html>
