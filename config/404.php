<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Страница не найдена</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
            overflow: hidden;
            margin: 0;
        }

        .error-container {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
            max-width: 600px;
            width: 100%;
            transform: translateY(-50px);
            animation: fadeIn 1s ease-out forwards;
        }

        h1 {
            font-size: 80px;
            font-weight: bold;
            color: #8aa7b8;
            margin-bottom: 20px;
            animation: slideIn 1s ease-out forwards;
        }

        p {
            font-size: 22px;
            color: #555;
            margin-bottom: 30px;
            animation: fadeIn 1.5s ease-out forwards;
        }

        a {
            display: inline-block;
            background-color: #c8a784;
            color: white;
            padding: 12px 30px;
            font-size: 18px;
            border-radius: 25px;
            text-decoration: none;
            transition: background-color 0.3s;
            animation: fadeIn 2s ease-out forwards;
        }

        a:hover {
            background-color: #a18363;
        }
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            0% {
                transform: translateY(-50px);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

    </style>
</head>
<body>

    <div class="error-container">
        <h1>404</h1>
        <p>Такой страницы не существует.</p>
        <a href="../views/index.php">Вернуться на главную</a>
    </div>

</body>
</html>
