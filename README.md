![github contribution grid snake animation](assets/img/github-contribution-grid-snake-dark.svg#gh-dark-mode-only)![github contribution grid snake animation](assets/img/github-contribution-grid-snake.svg#gh-light-mode-only)

## Hi there <img src="assets/img/88677602-1635ba80-d120-11ea-84d8-d263ba5fc3c0.gif" width="40px">
- **name** : Ahmad
- **from** : Indonesia
- **age** : 19
- **gender** : male
---

<div align="center">
 <div style="border: 2px solid Crimson; width: 200px; height: 200px; border-radius: 5px; position: fixed; margin-left: 30%; margin-top: 50px; z-index: -2">
  
 </div>
 <img src="assets/img/fa8c5c54-e7bc-43fb-b682-6e5d03febb4c.webp" width="200" style="border-radius : 5px; box-shadow: 2px 2px 7px rgba(0,0,0,0.4); z-index: 1">

</div>

# pengcodean v0.1.0

### 1) javascript

1) menampilkan kecepatan `internet`
```javascript
function updateKecepatanInternet() {
  if ("connection" in navigator && "downlink" in navigator.connection) {
    var kecepatan = navigator.connection.downlink * 1024; // Mengonversi ke kbps

    var kecepatanFormatted;
    if (kecepatan >= 1000000) {
      kecepatanFormatted = (kecepatan / 1000000).toFixed(2) + " mbps";
    } else {
      kecepatanFormatted = (kecepatan / 1000).toFixed(2) + " kbps";
    }

    var kecepatanElement = document.getElementById("kecepatan-internet");
    kecepatanElement.textContent = kecepatanFormatted;
  } else {
    var kecepatanElement = document.getElementById("kecepatan-internet");
    kecepatanElement.textContent = "Tidak dapat mendeteksi kecepatan internet.";
  }
}

// Memperbarui kecepatan internet setiap 1 detik
setInterval(updateKecepatanInternet, 1000);


```
pemasangan
```html
<div id="kecepatan-internet">0 kbps</div>

```

2) menampilkan `ping`
```javascript
function ping(url, callback) {
  var start = new Date().getTime();
  var xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      var end = new Date().getTime();
      var duration = end - start;
      callback(null, duration);
    }
  };

  xhr.onerror = function() {
    callback(new Error("Error in making the request."));
  };

  xhr.open("GET", url, true);
  xhr.send();
}

function pingUrl() {
  var url = "http://localhost:7700/"; // Ganti dengan URL yang ingin Anda ping
  var resultElement = document.getElementById("ping");
  resultElement.textContent = "Pinging...";

  ping(url, function(error, duration) {
    if (error) {
      resultElement.textContent = "Ping error: " + error.message;
    } else {
      resultElement.textContent = "Ping : " + duration + " ms";
    }
  });
}

window.onload = function() {
  pingUrl(); // Memanggil fungsi pingUrl saat halaman selesai dimuat
  setInterval(pingUrl, 5000); // Memanggil fungsi pingUrl setiap 5 detik
};

```

pemasangan
```html
<div id="ping"></div>

```

3) mengetahui type jaringan `4g 3g h+ dll`
```javascript
if ("connection" in navigator && "effectiveType" in navigator.connection) {
  //console.log("Nama jaringan: " + navigator.connection.effectiveType);
  document.getElementById('modeljangan').innerHTML = navigator.connection.effectiveType;
} else {
  console.log("Tidak dapat mendeteksi nama jaringan.");
}

```

pemasangan
```html
<div id="modeljangan"></div>

```

### 2) membuat login php menggunakan json no sql

sengaja saya memperbanyak file untuk memudahkan saya dalam mengedit, penjelasan code php nya saya taro di dalam comentar code.

1) daftar file
- `assets`
- * `php`
- * * `login.php`
- * * `register.php`
- * * `edit_profil.php`
- * * `logout.php`
- * * `index.php`
- `profile_pictures`
- * `.img`
- `userDB`
- * `users.json`
- `index.php`
- `login.php`
- `register.php`
- `edit_profil.php`

2) pemasangan
### code login.php
- `assets`
- * `php`
- * * `login.php`

```php
<?php
session_start();

// Fungsi untuk memeriksa apakah pengguna sudah login
function isUserLoggedIn() {
    return isset($_SESSION['username']);
}

// Fungsi untuk melakukan login
function login($username, $password) {
    // Mendapatkan data pengguna dari file JSON
    $usersData = json_decode(file_get_contents('users.json'), true);

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

            header("Location: index.php");
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


```

### code register.php
- `assets`
- * `php`
- * * `register.php`

```php
<?php
// Fungsi untuk menambahkan pengguna baru ke dalam file JSON
function addUser($username, $password, $name, $profilePicture) {
    // Mendapatkan data pengguna dari file JSON
    $usersData = json_decode(file_get_contents('users.json'), true);

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
    file_put_contents('users.json', json_encode($usersData));

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
        echo "Registrasi berhasil. Silakan <a href='login.php'>login</a>.";
    } else {
        echo "Username dengan nama <b>$username</b> sudah digunakan.";
    }
}
?>
```

### code edit_profil.php
- `assets`
- * `php`
- * * `edit_profil.php`

```php
<?php
session_start();

// Fungsi untuk memperbarui data pengguna
function updateProfile($username, $newUsername, $newPassword, $newName, $newProfilePicture) {
    // Mendapatkan data pengguna dari file JSON
    $usersData = json_decode(file_get_contents('users.json'), true);

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
        file_put_contents('users.json', json_encode($usersData));

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
```

### code logout.php
- `assets`
- * `php`
- * * `logout.php`

```php
<?php
session_start();

// Fungsi untuk logout
function logout() {
    session_unset();
    session_destroy();
}

// Logout pengguna
logout();

// Redirect ke halaman login
header("Location: login.php");
exit;

?>
<script>
    localStorage.removeItem('remember');
</script>

```

### code index.php
- `assets`
- * `php`
- * * `index.php`

```php
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
$usersData = json_decode(file_get_contents('users.json'), true);

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

```

# END

## silahkan di sesuaikan 
