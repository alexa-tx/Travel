<?php
session_start();
?>
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

        <section class="reviews-section">
        <h2>Отзывы наших клиентов</h2>
        <?php
        session_start();
        include '../config/db_connect.php';
        $stmt = $pdo->query("SELECT fullName, reviewTitle, reviewContent, created_at FROM reviews ORDER BY created_at DESC LIMIT 4");
        $reviews = $stmt->fetchAll();

        foreach ($reviews as $review) {
            echo "<div class='review'>";
            echo "<blockquote>“{$review['reviewContent']}”</blockquote>";
            echo "<cite>– {$review['fullName']}, {$review['created_at']}</cite>";
            echo "</div>";
            }
        ?>
        <!-- возможность добавление отзыва только для авторизованных пользователей -->
        <?php if (isset($_SESSION['fullName'])): ?>
            <form id="reviewForm" class="review-form">
                <label for="reviewTitle">Заголовок:</label>
                <input type="text" id="reviewTitle" name="reviewTitle" required>
                <label for="reviewContent">Ваш отзыв:</label>
                <textarea id="reviewContent" name="reviewContent" required></textarea>
                <button type="button" id="submitReviewButton">Добавить отзыв</button>
            </form>
            <div id="reviewMessage" style="color: green; display: none;">Отзыв успешно добавлен!</div>
        <?php else: ?>
            <p>Только авторизованные пользователи могут оставлять отзывы. <a href="singin.php">Войти</a></p>
        <?php endif; ?>
        </section>

        <script>
            document.getElementById('submitReviewButton').addEventListener('click', function () {
            const form = document.getElementById('reviewForm');
            const formData = new FormData(form);

            fetch('../config/submit_review.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const reviewsSection = document.querySelector('.reviews-section');
                    const newReview = document.createElement('div');
                    newReview.classList.add('review');
                    newReview.innerHTML = `
                        <blockquote>“${formData.get('reviewContent')}”</blockquote>
                        <cite>– ${data.fullName}, только что</cite>
                    `;
                    reviewsSection.insertBefore(newReview, form);
                    document.getElementById('reviewMessage').style.display = 'block';
                    form.reset();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
            });
        });
        </script>
    </main>
    <?php include '../includes/footer.html'?>
</body>
</html>
