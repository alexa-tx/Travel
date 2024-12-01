<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orion | Туры</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <?php 
    include '../includes/header.php'; 
    include '../config/db_connect.php';

    $genre = isset($_GET['genre']) ? $_GET['genre'] : null;
    if ($genre) {
        $stmt = $pdo->prepare("SELECT t.*, h.hotelName, h.stars, h.city, h.country, h.description AS hotel_description, t.image AS tour_image 
                       FROM tour t
                       JOIN hotel h ON t.idHotel = h.idHotel
                       WHERE t.genre = :genre");


        $stmt->execute(['genre' => $genre]);
    } else {
        $stmt = $pdo->prepare("SELECT t.*, h.hotelName, h.stars, h.city, h.country, t.image AS tour_image 
                               FROM tour t
                               JOIN hotel h ON t.idHotel = h.idHotel");
        $stmt->execute();
    }

    $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <section class="tours-section">
        <div class="tours-header">
            <h2>Туры</h2>
            <p>Выберите свой идеальный маршрут среди наших предложений</p>
        </div>
        <div class="tours-filters">
            <a href="tours.php" class="filter-btn <?= !$genre ? 'active' : '' ?>">Все</a>
            <a href="tours.php?genre=пляж" class="filter-btn <?= ($genre === 'пляж') ? 'active' : '' ?>">Пляжный отдых</a>
            <a href="tours.php?genre=приключение" class="filter-btn <?= ($genre === 'приключение') ? 'active' : '' ?>">Приключения</a>
            <a href="tours.php?genre=экскурсионный" class="filter-btn <?= ($genre === 'экскурсионный') ? 'active' : '' ?>">Культурные туры</a>
            <a href="tours.php?genre=городской" class="filter-btn <?= ($genre === 'городской') ? 'active' : '' ?>">Городские туры</a>
        </div>

        <div class="tours-list">
            <?php if (count($tours) > 0): ?>
                <?php foreach ($tours as $tour): ?>
                    <div class="tour-card" data-category="<?= htmlspecialchars($tour['genre']) ?>">
                        <img src="../<?= !empty($tour['tour_image']) ? htmlspecialchars($tour['tour_image']) : 'default-tour-image.jpg' ?>" 
                             alt="<?= htmlspecialchars($tour['hotelName']) ?>">
                        <h3><?= htmlspecialchars($tour['country']) ?></h3>
                        <p><strong>Отель:</strong> <?= htmlspecialchars($tour['hotelName']) ?></p>
                        <p><strong>Звезды:</strong> <?= str_repeat('&#9733;', (int)$tour['stars']) ?></p>
                        <p><strong>Цена:</strong> <?= number_format($tour['price'], 2, ',', ' ') ?> руб.</p>
                        <button class="btn" onclick="window.location.href='register-tour.php?id=<?= $tour['idTour'] ?>'">Выбрать тур</button>
                        <button class="btn" onclick="showDetails('<?= htmlspecialchars(json_encode($tour)) ?>')">Подробнее</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Туры с выбранным жанром не найдены.</p>
            <?php endif; ?>
        </div>
    </section>
    <div id="tour-modal" class="tour-modal" style="display: none;">
    <div class="tour-modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <div id="tour-details"></div>
    </div>
</div>
<script>
    function openModal(tourId) {
    const modal = document.getElementById('tour-modal');
    const tourDetails = document.getElementById('tour-details');
    tourDetails.innerHTML = `<p>Загрузка информации о туре ID: ${tourId}</p>`;
    modal.style.display = 'block';
}
function closeModal() {
    const modal = document.getElementById('tour-modal');
    modal.style.display = 'none';
}
function showDetails(tourData) {
    const data = JSON.parse(tourData);
    console.log(data); // Оставляем для отладки

    const modal = document.getElementById('tour-modal');
    const tourDetails = document.getElementById('tour-details');
    tourDetails.innerHTML = `
        <h3>Подробнее о туре: ${data.country}</h3>
        <p><strong>Отель:</strong> ${data.hotelName}</p>
        <p><strong>Звезды:</strong> ${'★'.repeat(data.stars)}</p>
        <p><strong>Город:</strong> ${data.city}</p>
        <p><strong>Описание тура:</strong> ${data.tourDescription || 'Описание отсутствует.'}</p>
        <p><strong>Цена:</strong> ${data.price} руб.</p>
        <img src="../${data.tour_image}" alt="${data.hotelName}" />
    `;
    modal.style.display = 'block';
}



</script>
    <?php include '../includes/footer.html'; ?>
</body>
</html>
