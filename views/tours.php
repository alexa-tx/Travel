<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orion | Туры</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <?php include '../includes/header.php' ?>
    <section class="tours-section">
    <div class="tours-header">
        <h2>Туры</h2>
        <p>Выберите свой идеальный маршрут среди наших предложений</p>
    </div>
    <div class="tours-filters">
        <button class="filter-btn active" data-category="all">Все</button>
        <button class="filter-btn" data-category="beach">Пляжный отдых</button>
        <button class="filter-btn" data-category="adventure">Приключения</button>
        <button class="filter-btn" data-category="culture">Культурные туры</button>
    </div>
    <div class="tours-list">
        <div class="tour-card" data-category="beach">
            <img src="../assets/tour1.jpg" alt="Пляжный отдых">
            <h3>Мальдивы</h3>
            <p>Насладитесь белоснежными пляжами и лазурными водами.</p>
            <button class="btn" onclick="window.location.href='register-tour.php'">Подробнее</button>
        </div>
        <div class="tour-card" data-category="adventure">
            <img src="../assets/tour2.jpg" alt="Приключенческий тур">
            <h3>Гималаи</h3>
            <p>Незабываемый треккинг и виды, которые захватывают дух.</p>
            <button class="btn" onclick="window.location.href='register-tour.php'">Подробнее</button>
        </div>
        <div class="tour-card" data-category="culture">
            <img src="../assets/tour3.jpg" alt="Культурный тур">
            <h3>Италия</h3>
            <p>Погрузитесь в историю, искусство и изысканную кухню.</p>
            <button class="btn" onclick="window.location.href='register-tour.php'">Подробнее</button>
        </div>
        <div class="tour-card" data-category="beach">
            <img src="../assets/tour4.jpg" alt="Пляжный отдых">
            <h3>Бали</h3>
            <p>Райские пляжи и уникальная природа ждут вас.</p>
            <button class="btn" onclick="window.location.href='register-tour.php'">Подробнее</button>
        </div>
    </div>
</section>
    <?php include '../includes/footer.html' ?>
</body>
</html>