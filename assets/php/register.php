<?php
// Fungsi untuk menambahkan pengguna baru ke dalam file JSON
function addUser($username, $password, $name, $profilePicture) {
    // Mendapatkan data pengguna dari file JSON
    $usersData = json_decode(file_get_contents('userDB/users.json'), true);

    // Memeriksa apakah username sudah digunakan
    if (isset($usersData[$username])) {
        return false; // Registrasi gagal, username sudah digunakan
    }

    // Membuat hash password menggunakan bcrypt
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Menambahkan data pengguna baru
    $usersData[$username] = array(
        'username' => $username,
        'password' => $hashedPassword,
        'name' => $name,
        'profile_picture' => $profilePicture
    );

    // Menyimpan data pengguna ke dalam file JSON
    file_put_contents('userDB/users.json', json_encode($usersData));

    return true; // Registrasi berhasil
}

// Menghandle proses registrasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Mengatur direktori untuk menyimpan gambar profil
    $targetDirectory = "profile_pictures/";
    $profilePicture = "";

    // Memeriksa apakah ada file gambar yang diunggah
    if (!empty($_FILES['profile_picture']['name'])) {
        $profilePicture = $targetDirectory . basename($_FILES['profile_picture']['name']);
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $profilePicture;

        // Memindahkan file gambar ke direktori yang ditentukan
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetPath);
    }

    // Mendaftarkan pengguna baru
    if (addUser($username, $password, $name, $profilePicture)) {
        echo "Registrasi berhasil. Silakan <a href='../../login.php'>login</a>.";
    } else {
        echo "Username dengan nama <b>$username</b> sudah digunakan.";
    }
}
?>