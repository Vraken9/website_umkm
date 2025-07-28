<?php
include 'koneksi.php';
$hash = password_hash("admin123", PASSWORD_DEFAULT);
mysqli_query($conn, "UPDATE admin SET password = '$hash' WHERE username = 'admin123'");
echo "Password berhasil di-hash dan disimpan.";
?>
