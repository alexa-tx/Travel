<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заявка успешно отправлена</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container">
    <div class="container-inner">
        <div class="checkmark">✔️</div>
        <h1>Заявка успешно отправлена!</h1>
        <p>Мы получили вашу заявку на оформление тура. Наши сотрудники скоро с вами свяжутся.</p>
        <p class="redirect-message">Вы будете перенаправлены через <span id="timer">5</span> секунд...</p>
    </div>
</div>

<script>
    let countdown = 5;
    const timerElement = document.getElementById("timer");

    setInterval(function() {
        countdown--;
        timerElement.textContent = countdown;
        if (countdown <= 0) {
            window.location.href = '../views/index.php';
        }
    }, 1000);
</script>
</body>
</html>
