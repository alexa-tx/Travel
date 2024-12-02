<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

include '../config/db_connect.php';

// Обработка добавления нового тура
if (isset($_POST['add_tour'])) {
    $idHotel = $_POST['idHotel'];
    $tourDescription = trim($_POST['tourDescription']);
    $genre = trim($_POST['genre']);
    $price = $_POST['price'];
    $imagePath = null;

    // Проверка и обработка загрузки файла
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../assets/image/";
        $fileName = basename($_FILES['image']['name']);
        $targetFilePath = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Проверка типа файла
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileType, $allowedTypes)) {
            // Загрузка файла
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                $imagePath = "assets/image/" . $fileName; // Сохраняем путь для базы данных
            } else {
                echo "Ошибка при загрузке изображения.";
            }
        } else {
            echo "Недопустимый формат файла. Разрешены: JPG, JPEG, PNG, GIF.";
        }
    }

    // Сохранение данных в таблицу `tour`
    $stmt = $pdo->prepare("
        INSERT INTO tour (idHotel, tourDescription, genre, price, image) 
        VALUES (:idHotel, :tourDescription, :genre, :price, :image)
    ");
    $stmt->execute([
        'idHotel' => $idHotel,
        'tourDescription' => $tourDescription,
        'genre' => $genre,
        'price' => $price,
        'image' => $imagePath,
    ]);
    header("Location: manage_tours.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Добавить тур</title>
</head>
<body>
<?php 
    include '../includes/header.php';
    ?>
    <div class="admin-panel">
        <h1>Добавить новый тур</h1>
        <form method="POST" enctype="multipart/form-data">
            <!-- Выпадающий список отелей -->
            <label for="idHotel">Отель:</label>
            <select name="idHotel" id="idHotel" required>
                <option value="" disabled selected>Выберите отель</option>
                <?php
                $stmt = $pdo->prepare("SELECT idHotel, hotelName, country FROM hotel");
                $stmt->execute();
                $hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($hotels as $hotel) {
                    echo "<option value='{$hotel['idHotel']}'>{$hotel['hotelName']} ({$hotel['country']})</option>";
                }
                ?>
            </select>

            <!-- Поле для загрузки изображения -->
            <label for="image">Изображение тура:</label>
            <input type="file" id="image" name="image" accept=".jpg, .jpeg, .png, .gif" required>

            <!-- Поле для описания тура -->
            <label for="tourDescription">Описание тура:</label>
            <textarea id="tourDescription" name="tourDescription" placeholder="Описание тура" required></textarea>

            <!-- Поле для жанра тура -->
            <label for="genre">Тип тура:</label>
            <input type="text" id="genre" name="genre" placeholder="Тип тура (пляж, экскурсия, горы)" required>

            <!-- Поле для цены тура -->
            <label for="price">Цена:</label>
            <input type="number" id="price" name="price" placeholder="Цена тура" step="0.01" required>

            <!-- Кнопка сохранения -->
            <button type="submit" name="add_tour">Добавить тур</button>
        </form>
    </div>
    <?php 
    include '../includes/footer.html';
    ?>
</body>
</html>
