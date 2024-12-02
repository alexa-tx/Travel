<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

include '../config/db_connect.php';

if (isset($_GET['id'])) {
    $idHotel = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM hotel WHERE idHotel = :idHotel");
    $stmt->execute(['idHotel' => $idHotel]);
}

header("Location: manage_hotels.php");
exit;
?>
