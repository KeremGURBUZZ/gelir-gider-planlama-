<?php
session_start();
require_once 'inc/db.php'; // Veritabanı bağlantısı

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Tarih filtresi kontrolü
$filtreli = false;
if (isset($_GET['tarih1']) && isset($_GET['tarih2'])) {
    $tarih1 = $_GET['tarih1'];
    $tarih2 = $_GET['tarih2'];
    $filtreli = true;
}

// Kullanıcı bilgilerini alalım
$userSorgu = $conn->query("SELECT username FROM users WHERE id = '$user_id'");
$userData = $userSorgu->fetch_assoc();
$username = $userData['username'] ?? 'Kullanıcı';

// Toplam Gelir
$gelirSorgu = $conn->query("SELECT SUM(tutar) AS toplamGelir FROM hareketler WHERE user_id = '$user_id' AND tip = 'gelir'");
$gelirData = $gelirSorgu->fetch_assoc();
$toplamGelir = $gelirData['toplamGelir'] ?? 0;

// Toplam Gider
$giderSorgu = $conn->query("SELECT SUM(tutar) AS toplamGider FROM hareketler WHERE user_id = '$user_id' AND tip = 'gider'");
$giderData = $giderSorgu->fetch_assoc();
$toplamGider = $giderData['toplamGider'] ?? 0;

// Bakiye Hesabı
$bakiye = $toplamGelir - $toplamGider;

// Son 5 Hareket (filtreli veya değil)
if ($filtreli) {
    $sonHareketler = $conn->query("SELECT * FROM hareketler WHERE user_id = '$user_id' AND tarih BETWEEN '$tarih1' AND '$tarih2' ORDER BY tarih DESC LIMIT 5");
} else {
    $sonHareketler = $conn->query("SELECT * FROM hareketler WHERE user_id = '$user_id' ORDER BY tarih DESC LIMIT 5");
}

// Yaklaşan Ödemeler (sadece giderleri göster)
$bugun = date('Y-m-d');
$gelecekHafta = date('Y-m-d', strtotime('+7 days'));
$yaklasanOdemeler = $conn->query("SELECT * FROM hareketler WHERE user_id = '$user_id' AND tip = 'gider' AND tarih BETWEEN '$bugun' AND '$gelecekHafta' ORDER BY tarih ASC");
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Gelir-Gider Paneli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        .panel {
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .panel-heading {
            font-size: 18px;
            padding: 15px;
            font-weight: bold;
        }

        .panel-footer {
            background: #f5f5f5;
            padding: 10px;
            border-top: 1px solid #ddd;
            border-radius: 0 0 5px 5px;
        }

        .huge {
            font-size: 36px;
        }

        .alert-kritik {
            background: #f2dede;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ebccd1;
            color: #a94442;
            border-radius: 4px;
        }

        .dashboard-welcome {
            margin-bottom: 20px;
            background: #f5f5f5;
            padding: 20px;
            border-radius: 5px;
        }
    </style>
</head>

<body>



    <div class="container mt-4 text-end">
        <a href="hareket_ekle.php" class="btn btn-success">+ Yeni Gelir / Gider Ekle</a>
    </div>

    <div class="container mt-4">
        <div class="dashboard-welcome">
            <h2>Hoş geldin, <?php echo htmlspecialchars($username); ?>!</h2>
            <p>Gelir ve giderlerini buradan yönetebilirsin.</p>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="panel bg-primary text-white">
                    <div class="panel-heading">Kasa Bakiyesi</div>
                    <div class="panel-body text-center p-3">
                        <div class="huge"><?php echo number_format($bakiye); ?>TL</div>
                    </div>
                    <div class="panel-footer text-center">
                        <a href="#" class="text-decoration-none">Detayları Gör</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel bg-success text-white">
                    <div class="panel-heading">Toplam Gelir</div>
                    <div class="panel-body text-center p-3">
                        <div class="huge"><?php echo number_format($toplamGelir); ?>TL</div>
                    </div>
                    <div class="panel-footer text-center">
                        <a href="#" class="text-decoration-none">Gelirleri Gör</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel bg-danger text-white">
                    <div class="panel-heading">Toplam Gider</div>
                    <div class="panel-body text-center p-3">
                        <div class="huge"><?php echo number_format($toplamGider); ?>TL</div>
                    </div>
                    <div class="panel-footer text-center">
                        <a href="#" class="text-decoration-none">Giderleri Gör</a>
                    </div>
                </div>
            </div>
        </div>

        <form class="row mt-4 mb-2" method="get">
            <div class="col-md-3">
                <input type="date" name="tarih1" class="form-control" value="<?php echo $_GET['tarih1'] ?? ''; ?>">
            </div>
            <div class="col-md-3">
                <input type="date" name="tarih2" class="form-control" value="<?php echo $_GET['tarih2'] ?? ''; ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Filtrele</button>
            </div>
        </form>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Son Hareketler</div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <?php if ($sonHareketler->num_rows > 0): ?>
                                <?php while ($hareket = $sonHareketler->fetch_assoc()): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <?php echo htmlspecialchars($hareket['aciklama']); ?>
                                            <span
                                                class="badge bg-<?php echo $hareket['tip'] == 'gelir' ? 'success' : 'danger'; ?>">
                                                <?php echo number_format($hareket['tutar'], 2); ?> TL
                                            </span>
                                        </div>
                                        <div>
                                            <a href="hareket_duzenle.php?id=<?php echo $hareket['id']; ?>"
                                                class="btn btn-sm btn-warning">Düzenle</a>
                                            <a href="hareket_sil.php?id=<?php echo $hareket['id']; ?>"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Bu hareketi silmek istediğinize emin misiniz?')">Sil</a>
                                        </div>
                                    </li>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <li class="list-group-item">Henüz hareket yok.</li>
                            <?php endif; ?>
                        </ul>
                        <div class="text-right mt-2">
                            <a href="hareketler.php">Tümünü Gör</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Yaklaşan Ödemeler</div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <?php if ($yaklasanOdemeler->num_rows > 0): ?>
                                <?php while ($odeme = $yaklasanOdemeler->fetch_assoc()): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?php echo htmlspecialchars($odeme['aciklama']); ?>
                                        <span class="badge bg-danger">
                                            <?php echo number_format($odeme['tutar'], 2); ?> TL
                                        </span>
                                    </li>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <li class="list-group-item">Yaklaşan ödeme bulunmuyor.</li>
                            <?php endif; ?>
                        </ul>
                        <div class="text-right mt-2">
                            <a href="giderler.php">Tüm Giderleri Gör</a>
                        </div>

                    </div>
                </div>
            </div>
            <div class="container mt-4 d-flex justify-content-between">
                <a href="logout.php" class="btn btn-danger">Çıkış Yap</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>