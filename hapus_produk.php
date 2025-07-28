<?php
session_start();
include 'koneksi.php';
include 'auth_admin.php'; 


$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Cek apakah produk benar-benar ada
$cek = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = $id");
$data = mysqli_fetch_assoc($cek);

if ($data) {
  // Hapus file gambar dari folder
  $gambarPath = "gambar/" . $data['gambar'];
  if (file_exists($gambarPath)) {
    unlink($gambarPath); // hapus file
  }

  // Hapus dari database
  mysqli_query($conn, "DELETE FROM produk WHERE id_produk = $id");
}

header("Location: kelola_produk.php");
exit;
?>
