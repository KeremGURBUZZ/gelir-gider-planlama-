<?php
session_start();
require_once 'inc/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$hareketler = $conn->query("SELECT * FROM hareketler WHERE user_id = $user_id ORDER BY tarih DESC");
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Gelir-Gider Takibi - Hareketler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2>Hareketler</h2>

    <!-- Gelir/Gider Ekle Butonu -->
    <div class="text-end mb-3">
        <a href="hareket_ekle.php" class="btn btn-success">+ Yeni Gelir / Gider Ekle</a>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if ($hareketler->num_rows > 0): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tip</th>
                            <th>Tutar (TL)</th>
                            <th>Açıklama</th>
                            <th>Tarih</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $hareketler->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <?php if ($row['tip'] == 'gelir'): ?>
                                        <span class="badge bg-success">Gelir</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Gider</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo number_format($row['tutar'], 2); ?> TL</td>
                                <td><?php echo htmlspecialchars($row['aciklama']); ?></td>
                                <td><?php echo date('d.m.Y', strtotime($row['tarih'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Henüz kayıtlı hareket bulunmamaktadır.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

