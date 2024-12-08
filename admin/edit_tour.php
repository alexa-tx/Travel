<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

include '../config/db_connect.php';

// Получение данных о туре для редактирования
if (isset($_GET['id'])) {
    $idTour = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM tour WHERE idTour = :idTour");
    $stmt->execute(['idTour' => $idTour]);
    $tour = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$tour) {
        header("Location: manage_tours.php");
        exit;
    }
} else {
    header("Location: manage_tours.php");
    exit;
}

// Обработка редактирования данных тура
if (isset($_POST['edit_tour'])) {
    $idHotel = $_POST['idHotel'];
    $tourDescription = trim($_POST['tourDescription']);
    $genre = trim($_POST['genre']);
    $imagePath = $tour['image']; // Сохраняем текущий путь к изображению

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
                $imagePath = "assets/image/" . $fileName; // Обновляем путь к изображению
            } else {
                echo "Ошибка при загрузке изображения.";
            }
        } else {
            echo "Недопустимый формат файла. Разрешены: JPG, JPEG, PNG, GIF.";
        }
    }

    // Обновление данных тура
    $stmt = $pdo->prepare("
        UPDATE tour 
        SET idHotel = :idHotel, image = :image, tourDescription = :tourDescription, genre = :genre 
        WHERE idTour = :idTour
    ");
    $stmt->execute([
        'idHotel' => $idHotel,
        'image' => $imagePath,
        'tourDescription' => $tourDescription,
        'genre' => $genre,
        'idTour' => $idTour,
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
    <title>Редактирование тура</title>
    <link rel="icon" href="assets/image/logo/favicon.ico" type="image/x-icon">
</head>
<body>
<?php 
    include '../includes/header.php';
    ?>
    <div class="admin-panel">
        <h1>Редактировать тур</h1>
        <form method="POST" enctype="multipart/form-data">
            <!-- Выпадающий список отелей -->
            <label for="idHotel">Отель:</label>
            <select name="idHotel" id="idHotel" required>
                <option value="" disabled>Выберите отель</option>
                <?php
                $stmt = $pdo->prepare("SELECT idHotel, hotelName, country FROM hotel");
                $stmt->execute();
                $hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($hotels as $hotel) {
                    $selected = $tour['idHotel'] == $hotel['idHotel'] ? 'selected' : '';
                    echo "<option value='{$hotel['idHotel']}' $selected>{$hotel['hotelName']} ({$hotel['country']})</option>";
                }
                ?>
            </select>

            <!-- Поле для загрузки изображения -->
            <label for="image">Изображение тура:</label>
            <input type="file" id="image" name="image" accept=".jpg, .jpeg, .png, .gif">
            <p>Текущее изображение: <img src="../<?= $tour['image'] ?>" alt="Изображение тура" style="max-width: 150px;"></p>

            <!-- Поле для описания тура -->
            <label for="tourDescription">Описание тура:</label>
            <textarea id="tourDescription" name="tourDescription" placeholder="Описание тура" required><?= htmlspecialchars($tour['tourDescription']) ?></textarea>

            <!-- Поле для жанра тура -->
            <label for="genre">Тип тура:</label>
            <input type="text" id="genre" name="genre" value="<?= htmlspecialchars($tour['genre']) ?>" placeholder="Тип тура (пляж, экскурсия, горы)" required>

            <!-- Кнопка сохранения -->
            <button type="submit" name="edit_tour">Сохранить изменения</button>
        </form>
    </div>
    <?php 
    include '../includes/footer.html';
    ?>
</body>
</html>
