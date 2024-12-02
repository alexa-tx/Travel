<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

include '../config/db_connect.php';

if (isset($_GET['id'])) {
    $idReview = $_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM reviews WHERE idReview = :idReview");
    $stmt->execute(['idReview' => $idReview]);
}

header("Location: manage_reviews.php");
exit;
?>