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
header("Location: ../../login.php");
exit;

?>
<script>
    localStorage.removeItem('remember');
</script>
