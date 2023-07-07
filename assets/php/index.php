<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Jika belum login, redirect ke halaman login
    header("Location: login.php");
    exit;
}

// Mendapatkan username pengguna yang sedang login
$username = $_SESSION['username'];

// Mendapatkan data pengguna dari file JSON
$usersData = json_decode(file_get_contents('assets/php/userDB/users.json'), true);

// Memeriksa apakah username pengguna ada dalam data pengguna
if (isset($usersData[$username])) {
    $name = $usersData[$username]['name'];
    $profilePicture = $usersData[$username]['profile_picture'];
} else {
    // Jika username tidak ditemukan, redirect ke halaman login
    header("Location: login.php");
    exit;
}
?>