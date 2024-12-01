<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $tourId = $_GET['id'];

    $stmt = $pdo->prepare("SELECT t.*, 
                              h.hotelName, 
                              h.stars, 
                              h.city, 
                              h.country, 
                              h.description AS hotel_description, 
                              t.image AS tour_image, 
                              t.price 
                       FROM tour t
                       JOIN hotel h ON t.idHotel = h.idHotel
                       WHERE t.idTour = :id");
$stmt->execute(['id' => $tourId]);
$tour = $stmt->fetch(PDO::FETCH_ASSOC);}

if ($tour) {
    echo json_encode([
        'idTour' => $tour['idTour'],
        'hotelName' => $tour['hotelName'],
        'stars' => $tour['stars'],
        'city' => $tour['city'],
        'country' => $tour['country'],
        'hotel_description' => $tour['hotel_description'],
        'price' => $tour['price'],
        'tour_image' => $tour['tour_image']
    ], JSON_UNESCAPED_UNICODE);
    
} else {
    echo json_encode(['error' => 'Тур не найден.']);
}

?>
