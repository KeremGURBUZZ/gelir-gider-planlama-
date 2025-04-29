<?php
include("inc/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password !== $confirm_password) {
        echo "<p style='text-align:center; color:red;'>Şifreler uyuşmuyor!</p>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);
            if (mysqli_stmt_execute($stmt)) {
                echo "<p style='text-align:center; color:green;'>Kayıt başarılı! <a href='proje.php'>Giriş yap</a></p>";
            } else {
                echo "<p style='text-align:center; color:red;'>Hata oluştu: " . mysqli_error($conn) . "</p>";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "<p style='text-align:center; color:red;'>Hazırlama hatası: " . mysqli_error($conn) . "</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kayıt Ol</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="register-container">
        <h2>Kayıt Ol</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Kullanıcı Adı" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Şifre" required>
            <input type="password" name="confirm_password" placeholder="Şifre Tekrar" required>
            <button type="submit">Kayıt Ol</button>
        </form>
        <a href="login.php">Zaten hesabın var mı? Giriş yap</a>
    </div>
</body>
</html>

