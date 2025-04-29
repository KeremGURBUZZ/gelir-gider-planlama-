<?php
session_start();
require_once 'inc/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tip = $_POST['tip'];
    $tutar = floatval($_POST['tutar']);
    $aciklama = trim($_POST['aciklama']);
    $tarih = $_POST['tarih'];

    if (!empty($tip) && $tutar > 0 && !empty($aciklama) && !empty($tarih)) {
        $stmt = $conn->prepare("INSERT INTO hareketler (user_id, tip, tutar, aciklama, tarih) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isdss", $user_id, $tip, $tutar, $aciklama, $tarih);
        $stmt->execute();

        header("Location: dashboard.php"); // <<< BURADA DASHBOARD'A GÖNDERİYORUZ
        exit;
    } else {
        $hata = "Lütfen tüm alanları doldurun.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yeni Gelir/Gider Ekle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2>Yeni Gelir / Gider Ekle</h2>

    <?php if (isset($hata)): ?>
        <div class="alert alert-danger"><?php echo $hata; ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label for="tip" class="form-label">Tip:</label>
            <select name="tip" id="tip" class="form-select" required>
                <option value="">Seçiniz</option>
                <option value="gelir">Gelir</option>
                <option value="gider">Gider</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="tutar" class="form-label">Tutar (TL):</label>
            <input type="number" name="tutar" id="tutar" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="aciklama" class="form-label">Açıklama:</label>
            <input type="text" name="aciklama" id="aciklama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="tarih" class="form-label">Tarih:</label>
            <input type="date" name="tarih" id="tarih" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Kaydet</button>
        <a href="dashboard.php" class="btn btn-secondary">Vazgeç</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
