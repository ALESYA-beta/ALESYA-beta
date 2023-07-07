<?php
session_start();

// Fungsi untuk memeriksa apakah pengguna sudah login
function isUserLoggedIn() {
    return isset($_SESSION['username']);
}

// Fungsi untuk melakukan login
function login($username, $password) {
    // Mendapatkan data pengguna dari file JSON
    $usersData = json_decode(file_get_contents('userDB/users.json'), true);

    // Memeriksa apakah pengguna ada dalam data pengguna dan password cocok
    if (isset($usersData[$username]) && password_verify($password, $usersData[$username]['password'])) {
        // Login berhasil
        $_SESSION['username'] = $username;
        return true;
    } else {
        // Login gagal
        return false;
    }
}

// Menghandle proses login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Memeriksa user agent
    $userAgent = $_SERVER['HTTP_USER_AGENT'];

    if (strpos($userAgent, 'Mozilla/5.0') !== false) {
        // Hanya mengizinkan masuk jika user agent sesuai
        if (login($username, $password)) {
            // Set session dan redirect ke halaman index setelah login otomatis
            $_SESSION['remember'] = isset($_POST['remember']) ? $_POST['remember'] : '';

            header("Location: ../../index.php");
            exit;
        } else {
            // Login gagal
            $errorMessage = "Username atau password salah.";
        }
    } else {
        // User agent tidak sesuai
        $errorMessage = "Anda tidak diizinkan untuk masuk dari perangkat ini.";
    }
}
?>