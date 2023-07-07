<?php
session_start();

// Fungsi untuk memperbarui data pengguna
function updateProfile($username, $newUsername, $newPassword, $newName, $newProfilePicture) {
    // Mendapatkan data pengguna dari file JSON
    $usersData = json_decode(file_get_contents('userDB/users.json'), true);

    // Memeriksa apakah pengguna ada dalam data pengguna dan password cocok
    if (isset($usersData[$username]) && password_verify($password, $usersData[$username]['password'])) {
        // Memeriksa apakah username baru sama dengan username yang sedang digunakan
        if ($newUsername !== $username && isset($usersData[$newUsername])) {
            return false; // Gagal memperbarui profil, username sudah digunakan
        }

        // Menghapus data pengguna yang lama
        unset($usersData[$username]);

        // Membuat hash password baru menggunakan bcrypt
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Menambahkan data pengguna yang baru
        $usersData[$newUsername] = array(
            'username' => $newUsername,
            'password' => $hashedPassword,
            'name' => $newName,
            'profile_picture' => $newProfilePicture
        );

        // Menyimpan data pengguna ke dalam file JSON
        file_put_contents('userDB/users.json', json_encode($usersData));

        return true; // Perbarui profil berhasil
    } else {
        return false; // Perbarui profil gagal
    }
}

// Menghandle proses pengeditan profil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['username'];
    $newUsername = $_POST['new_username'];
    $newPassword = $_POST['new_password'];
    $newName = $_POST['new_name'];

    // Mengatur direktori untuk menyimpan gambar profil
    $targetDirectory = "profile_pictures/";
    $newProfilePicture = "";

    // Memeriksa apakah ada file gambar yang diunggah
    if (!empty($_FILES['new_profile_picture']['name'])) {
        $newProfilePicture = $targetDirectory . basename($_FILES['new_profile_picture']['name']);
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $newProfilePicture;

        // Memindahkan file gambar ke direktori yang ditentukan
        move_uploaded_file($_FILES['new_profile_picture']['tmp_name'], $targetPath);
    }

    // Memperbarui profil pengguna
    if (updateProfile($username, $newUsername, $newPassword, $newName, $newProfilePicture)) {
        $_SESSION['username'] = $newUsername;
        echo "Profil berhasil diperbarui.";
        header("Location: ../../index.php");
    } else {
        echo "Gagal memperbarui profil.";
        if ($newUsername === $username) {
            echo " Username yang baru sama dengan username yang sedang digunakan.";
        } else {
            echo " Username sudah digunakan.";
        }
    }
}
?>