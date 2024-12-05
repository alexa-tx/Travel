<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $fullName = trim($_POST['fullName']);
        $phone = trim($_POST['phone']);
        $email = trim($_POST['email']);
        $departureCity = trim($_POST['departureCity']);
        $departureDate = trim($_POST['departureDate']);
        $returnDate = trim($_POST['returnDate']);
        $destination = trim($_POST['destination']);
        $hotelName = trim($_POST['hotel']);
        $idTour = (int)$_POST['idTour'];
        $seats = (int)$_POST['seats'];
        $totalPrice = (float)str_replace(' ₽', '', $_POST['totalPrice']);

        // проверка на заполненность полей
        if (empty($fullName) || empty($phone) || empty($email) || empty($departureCity) ||
            empty($departureDate) || empty($returnDate) || empty($destination) || empty($hotelName) ||
            empty($idTour) || empty($seats) || empty($totalPrice)) {
            echo "Пожалуйста, заполните все поля!";
            exit;
        }

        // проверяем существование тура и отеля
        $tour_check = $pdo->prepare("SELECT * FROM tour WHERE idTour = :idTour");
        $tour_check->execute(['idTour' => $idTour]);
        $hotel_check = $pdo->prepare("SELECT * FROM hotel WHERE hotelName = :hotelName");
        $hotel_check->execute(['hotelName' => $hotelName]);

        if ($tour_check->rowCount() > 0 && $hotel_check->rowCount() > 0) {
            $hotel_data = $hotel_check->fetch(PDO::FETCH_ASSOC);
            $stars = $hotel_data['stars'];

            $pdo->beginTransaction();

            try {
                $stmt = $pdo->prepare("INSERT INTO orders 
                    (fullName, phone, email, departureCity, departureDate, returnDate, destination, hotel, stars, idUser, idTour, seats, totalPrice) 
                    VALUES (:fullName, :phone, :email, :departureCity, :departureDate, :returnDate, :destination, :hotel, :stars, :idUser, :idTour, :seats, :totalPrice)");

                $stmt->execute([
                    ':fullName' => $fullName,
                    ':phone' => $phone,
                    ':email' => $email,
                    ':departureCity' => $departureCity,
                    ':departureDate' => $departureDate,
                    ':returnDate' => $returnDate,
                    ':destination' => $destination,
                    ':hotel' => $hotelName,
                    ':stars' => $stars,
                    ':idUser' => $user_id,
                    ':idTour' => $idTour,
                    ':seats' => $seats,
                    ':totalPrice' => $totalPrice
                ]);

                $pdo->commit();
                echo "Ваша заявка успешно отправлена!";
            } catch (Exception $e) {
                $pdo->rollBack();
                echo "Ошибка при добавлении заказа: " . $e->getMessage();
            }
        } else {
            if ($tour_check->rowCount() == 0) {
                echo "Тур не найден!";
            }
            if ($hotel_check->rowCount() == 0) {
                echo "Отель не найден!";
            }
        }
    } else {
        echo "Пожалуйста, войдите в свой аккаунт.";
    }
}
header('Location: confirmation.php');
exit;
?>
