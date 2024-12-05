<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
          integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" 
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Вход</title>
</head>
<body>
<div class="container-form">
    <div class="form-signin">
        <form method="POST" action="">
            <h1>Добро пожаловать!</h1>
            <h2>Вход</h2>
            <input type="email" name="email" placeholder="Почта" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <a href="#" class="pass">Забыли пароль?</a>
            <div class="social-link">
                <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-vk"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-telegram"></i></a>
            </div>
            <button type="submit" name="login">Вход</button>
            <a href="singup.php" class="noacc">Нет аккаунта?</a>
        </form>
    </div>
</div>

<?php
session_start();

// если пользователь уже авторизован, перенаправляем на профиль или главную страницу
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        // если роль администратора, перенаправляем на админ-панель
        header("Location: ../admin/index.php");
    } else {
        // если обычный пользователь, перенаправляем на его профиль
        header("Location: ../views/profile.php");
    }
    exit;
}

include '../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    // проверкапользователя в базе данных
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // сохранение данных в сессию
        $_SESSION['user_id'] = $user['idUser'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['fullName'] = $user['fullName'];
        if ($user['role'] === 'admin') {
            header("Location: ../admin/index.php");
        } else {
            header("Location: ../views/profile.php");
        }
        exit;
    } else {
        // ошибка данных
        echo "<p style='color:red; text-align:center;'>Неверный email или пароль.</p>";
    }
}
?>


</body>
</html>
