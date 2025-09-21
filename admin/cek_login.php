<?php
require_once "../include/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cek apakah email dan password kosong
    if (empty($email) || empty($password)) {
        header("Location: index.php?error=empty_fields");
        exit();
    }

    // Cek apakah email terdaftar di database
    $query = mysqli_query($kon, "SELECT * FROM users WHERE email='$email'");
    $data = mysqli_fetch_array($query);

    // Verifikasi password
    if ($data && password_verify($password, $data['password'])) {
        session_start();
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['username'] = $data['username'];

        // Redirect ke halaman utama setelah login berhasil
        header("Location: main.php?p=dashboard");
    } else {
        // Jika email atau password salah
        header("Location: index.php?error=invalid_credentials");
    }
}
