# 💰 Kişisel Gelir-Gider Takip Sistemi

Bu proje, kullanıcı bazlı geliştirilen bir **PHP tabanlı gelir-gider takip uygulamasıdır**. Kullanıcılar kayıt olduktan sonra sisteme giriş yapabilir, gelir ve giderlerini kolayca ekleyip takip edebilirler.

## ✨ Özellikler

- 👤 Kullanıcı girişi ve oturum yönetimi (Login / Logout)
- ➕ Gelir ve gider ekleme
- 📊 Kasa bakiyesi (Toplam gelir – Toplam gider)
- 🕒 Son 5 işlem listesi
- 🔔 7 gün içerisinde yaklaşan giderleri listeleme
- 📅 Tarihe göre gider filtreleme (yaklaşan ödemeler sayfasında)
- 🧾 Gider düzenleme ve silme işlemleri
- 🔒 Güvenli parola doğrulama (bcrypt)
- 🎨 Bootstrap ile responsive tasarım

## 🛠️ Kullanılan Teknolojiler

- PHP
- MySQL
- HTML / CSS
- Bootstrap 5
- FontAwesome

## 📂 Kurulum ve Kullanım

1. **XAMPP veya WAMP** gibi bir yerel sunucu kurun.
2. Projeyi `htdocs` (veya www) klasörüne yerleştirin.
3. `inc/db.php` dosyasındaki veritabanı ayarlarını kendinize göre güncelleyin.
4. MySQL üzerinde `gelir_gider` adında bir veritabanı oluşturun ve gerekli tabloları ekleyin:
    ```sql
    CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255),
        email VARCHAR(255) UNIQUE,
        password VARCHAR(255)
    );

    CREATE TABLE hareketler (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        aciklama VARCHAR(255),
        tutar DECIMAL(10,2),
        tip ENUM('gelir','gider'),
        tarih DATE
    );
    ```
5. `index.php` üzerinden kayıt olabilir veya doğrudan `login` ekranı ile giriş yapabilirsiniz.

## 👨‍💻 Geliştirici

> Bu proje [Kerem Gürbüz](https://github.com/KeremGURBUZZ) tarafından geliştirilmiştir.

## 📄 Lisans

Bu proje eğitim amaçlıdır. Dilediğiniz gibi geliştirip kullanabilirsiniz.
