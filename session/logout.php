<?php
session_start();
session_destroy();
header("Location: ../views/singin.php");
exit;
?>
