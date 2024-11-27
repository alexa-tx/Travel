<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orion | Выбор тура</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<?php include '../includes/header.php' ?>
<section class="tour-selection-section">
    <h2>Выберите тур</h2>
    <form class="tour-selection-form" id="tourForm">
        <div class="form-group">
            <label for="fullName">ФИО</label>
            <input type="text" id="fullName" name="fullName" placeholder="Введите ваше ФИО" required>
        </div>
        <div class="form-group">
            <label for="phone">Телефон</label>
            <input type="tel" id="phone" name="phone" placeholder="+7 999 999 99 99" required>
        </div>
        <div class="form-group">
            <label for="email">Почта</label>
            <input type="email" id="email" name="email" placeholder="example@mail.com" required>
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
            <select id="destination" name="destination" required>
                <option value="" disabled selected>Выберите страну и город</option>
                <option value="maldives">Мальдивы</option>
                <option value="bali">Бали</option>
                <option value="paris">Париж</option>
                <option value="tokyo">Токио</option>
            </select>
        </div>
        <div class="form-group">
            <label for="hotel">Отель</label>
            <select id="hotel" name="hotel" required>
                <option value="" disabled selected>Выберите отель</option>
            </select>
        </div>
        <div class="form-group" id="starsGroup" style="display: none;">
            <label for="stars">Количество звезд</label>
            <input type="text" id="stars" name="stars" readonly>
        </div>
        <button type="submit" class="btn">Отправить заявку</button>
    </form>
</section>

<?php include '../includes/footer.html' ?>
</body>
</html>