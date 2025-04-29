<?php
session_start();
require_once 'inc/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: proje.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    echo "Hareket bulunamadı.";
    exit;
}

$hareket_id = intval($_GET['id']);

// Hareket bilgilerini çek
$hareket_sorgu = $conn->query("SELECT * FROM hareketler WHERE id = '$hareket_id' AND user_id = '$user_id'");
$hareket = $hareket_sorgu->fetch_assoc();

if (!$hareket) {
    echo "Bu hareket size ait değil veya bulunamadı.";
    exit;
}

// Form gönderildiyse güncelle
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tip = $_POST['tip'];
    $tutar = floatval($_POST['tutar']);
    $aciklama = trim($_POST['aciklama']);
    $tarih = $_POST['tarih'];

    if (!empty($tip) && !empty($tutar) && !empty($aciklama) && !empty($tarih)) {
        $stmt = $conn->prepare("UPDATE hareketler SET tip=?, tutar=?, aciklama=?, tarih=? WHERE id=? AND user_id=?");
        $stmt->bind_param("sdssii", $tip, $tutar, $aciklama, $tarih, $hareket_id, $user_id);

        if ($stmt->execute()) {
            header("Location: hareketler.php");
            exit;
        } else {
            echo "Güncelleme hatası: " . $stmt->error;
        }
    } else {
        echo "Tüm alanları doldurun.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Hareket Düzenle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">Hareket Düzenle</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label>Tip</label>
            <select name="tip" class="form-control" required>
                <option value="gelir" <?php if ($hareket['tip'] == 'gelir') echo 'selected'; ?>>Gelir</option>
                <option value="gider" <?php if ($hareket['tip'] == 'gider') echo 'selected'; ?>>Gider</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Tutar (TL)</label>
            <input type="number" step="0.01" name="tutar" class="form-control" value="<?php echo htmlspecialchars($hareket['tutar']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Açıklama</label>
            <input type="text" name="aciklama" class="form-control" value="<?php echo htmlspecialchars($hareket['aciklama']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Tarih</label>
            <input type="date" name="tarih" class="form-control" value="<?php echo htmlspecialchars($hareket['tarih']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Güncelle</button>
        <a href="hareketler.php" class="btn btn-secondary">İptal</a>
    </form>
</div>

</body>
</html>
