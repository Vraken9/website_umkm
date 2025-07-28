<?php
include 'koneksi.php';

$username = 'admin123';
$password = 'admin123';

// Hash password dengan aman
$hash = password_hash($password, PASSWORD_DEFAULT);

// Hapus jika admin dengan username itu sudah ada
mysqli_query($conn, "DELETE FROM admin WHERE username = '$username'");

// Tambahkan admin baru
$insert = mysqli_query($conn, "INSERT INTO admin (username, password) VALUES ('$username', '$hash')");

if ($insert) {
  echo "✅ Admin berhasil dibuat ulang dengan password hash!";
} else {
  echo "❌ Gagal membuat admin: " . mysqli_error($conn);
}
?>
