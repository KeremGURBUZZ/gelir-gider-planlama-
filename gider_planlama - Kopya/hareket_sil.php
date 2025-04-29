<?php
session_start();
require_once 'inc/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: proje.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $hareket_id = intval($_GET['id']);

    // Kullanıcının kendi hareketi mi diye kontrol et
    $check = $conn->query("SELECT * FROM hareketler WHERE id = '$hareket_id' AND user_id = '$user_id'");

    if ($check->num_rows > 0) {
        $conn->query("DELETE FROM hareketler WHERE id = '$hareket_id'");
        header("Location: hareketler.php");
        exit;
    } else {
        echo "Bu hareket size ait değil veya bulunamadı.";
    }
} else {
    echo "Geçersiz istek.";
}
?>
