<?php
include("inc/db.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $user['password'])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Şifre yanlış";
        }
    } else {
        $error = "Kullanıcı bulunamadı!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f1f1f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            background: #fff;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        input[type=email],
        input[type=password] {
            width: 100%;
            background-color: #f0f0f0;
            color: #333;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
        }

        button {
            display: block;
            background-color: #333;
            color: #fff;
            border: 1px solid #666;
            padding: 12px 20px;
            margin: 15px auto 0;
            border-radius: 25px;
            cursor: pointer;
            width: auto;
            font-size: 16px;
        }

        button:hover {
            background-color: #f0f0f0;
            color: #333;
            transition: 0.6s;
        }

        .error {
            color: red;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <h2>Giriş Yap</h2>
        <?php if (isset($error))
            echo "<div class = 'error'>$error</div>"; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Şifre" required>
            <button type="submit">Giriş Yap</button>
        </form>
    </div>
</body>

</html>