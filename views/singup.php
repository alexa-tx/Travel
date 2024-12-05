<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
          integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" 
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Регистрация</title>
    <script>
        // регистрация прошла успешно
        function showSuccessMessage() {
            if (confirm("Регистрация успешна! Перейти ко входу?")) {
                window.location.href = "singin.php";
            }
        }
    </script>
</head>
<body>
<div class="container-form">
    <div class="form-registration">
        <form method="POST" action="">
            <h1>Добро пожаловать!</h1>
            <h2>Создать аккаунт</h2>
            <div class="social-link">
                <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-vk"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-telegram"></i></a>
            </div>
            <span>Или зарегистрируйтесь по почте</span>
            <input type="text" name="fullName" placeholder="Имя" required>
            <input type="tel" name="phoneNumber" placeholder="Номер телефона" required>
            <input type="email" name="email" placeholder="Почта" required>
            <input type="date" name="dateOfBirth" placeholder="Дата рождения" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit" name="register">Зарегистрироваться</button>
            <a href="singin.php" class="signin">Уже зарегистрированы?</a>
        </form>
    </div>
</div>

<?php
include '../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $fullName = trim($_POST['fullName']);
    $phoneNumber = trim($_POST['phoneNumber']);
    $email = trim($_POST['email']);
    $dateOfBirth = $_POST['dateOfBirth'];
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);

    try {
        //проверка пользователя на наличие этой почты
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);

        if ($stmt->rowCount() > 0) {
            echo "<p style='color: red; text-align: center;'>Этот email уже зарегистрирован.</p>";
        } else {
            //добавляем нового пользователя в базу данных
            $stmt = $pdo->prepare("
                INSERT INTO users (fullName, phoneNumber, email, dateOfBirth, password, role) 
                VALUES (:fullName, :phoneNumber, :email, :dateOfBirth, :password, 'user')
            ");
            $stmt->execute([
                'fullName' => $fullName,
                'phoneNumber' => $phoneNumber,
                'email' => $email,
                'dateOfBirth' => $dateOfBirth,
                'password' => $password
            ]);
            echo "<script>showSuccessMessage();</script>";
        }
    } catch (PDOException $e) {
        echo "<p style='color: red; text-align: center;'>Ошибка: " . $e->getMessage() . "</p>";
    }
}
?>
</body>
</html>
