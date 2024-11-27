<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orion</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <?php include '../includes/header.php' ?>

    <main>
        <section class="welcome-section">
            <div class="text-content">
                <h1>Добро пожаловать в Orion!</h1>
                <p>
                    Orion – ваш надёжный гид в мир увлекательных путешествий. Мы предлагаем уникальные туры, 
                    которые подойдут каждому, кто ищет приключения, отдых и вдохновение.
                </p>
            </div>
            <div class="image-content">
                <img src="../assets/image/welcome-image.jpg" alt="Welcome to Orion">
            </div>
        </section>

        <section class="facts-section">
            <div class="fact">
                <i class='bx bx-calendar-heart' ></i>
                <h3>10+ лет опыта</h3>
                <p>Мы работаем на рынке туризма более 10 лет, помогая людям открывать мир.</p>
            </div>
            <div class="fact">
                <i class='bx bxs-plane-take-off' ></i>
                <h3>500+ туров</h3>
                <p>В нашем каталоге вы найдёте более 500 уникальных туров в разные страны.</p>
            </div>
            <div class="fact">
                <i class='bx bx-wink-smile' ></i>
                <h3>1000+ довольных клиентов</h3>
                <p>Мы гордимся тем, что наши клиенты остаются довольны каждым путешествием.</p>
            </div>
        </section>

        <section class="popular-tours-section">
            <h2>Популярные туры</h2>
            <div class="tour-cards">
                <div class="tour-card">
                    <img src="../assets/tour1.jpg" alt="Tour 1">
                    <h3>Тур в Турцию</h3>
                    <p>От 50,000 руб.</p>
                    <button>Подробнее</button>
                </div>
                <div class="tour-card">
                    <img src="../assets/tour2.jpg" alt="Tour 2">
                    <h3>Тур в Египет</h3>
                    <p>От 60,000 руб.</p>
                    <button>Подробнее</button>
                </div>
                <div class="tour-card">
                    <img src="../assets/tour3.jpg" alt="Tour 3">
                    <h3>Тур в Италию</h3>
                    <p>От 80,000 руб.</p>
                    <button>Подробнее</button>
                </div>
            </div>
        </section>
        <section class="reviews-section">
            <h2>Отзывы наших клиентов</h2>
            <div class="review">
                <blockquote>“Организация тура была на высшем уровне. Спасибо Orion за незабываемое путешествие!”</blockquote>
                <cite>– Анна Смирнова</cite>
            </div>
            <div class="review">
                <blockquote>“Идеальный отдых! Всё было продумано до мелочей. Рекомендую!”</blockquote>
                <cite>– Игорь Петров</cite>
            </div>
        </section>
    </main>

    <?php include '../includes/footer.html'?>
</body>
</html>
