<?php
session_start();
include 'koneksi.php';
include 'auth_admin.php'; 


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_pesanan'])) {
  $id = intval($_POST['id_pesanan']);

  // Cek apakah pembayaran sudah ada
  $cek = mysqli_query($conn, "SELECT * FROM pembayaran WHERE id_pesanan = $id");

  if (mysqli_num_rows($cek) > 0) {
    // Update status pembayaran dan status konfirmasi
    $query = "
      UPDATE pembayaran 
      SET status_pembayaran = 'lunas', 
          status_konfirmasi = 'disetujui', 
          waktu_bayar = NOW()
      WHERE id_pesanan = $id
    ";
  } else {
    // Insert data baru jika belum ada entri pembayaran
    $query = "
      INSERT INTO pembayaran (id_pesanan, metode, status_pembayaran, status_konfirmasi, waktu_bayar) 
      VALUES ($id, 'Manual', 'lunas', 'disetujui', NOW())
    ";
  }

  // Eksekusi query dan tangani jika gagal
  if (mysqli_query($conn, $query)) {
    header("Location: dashboard_admin.php");
    exit;
  } else {
    echo "<p style='color:red; text-align:center;'>❌ Gagal mengonfirmasi pembayaran: " . mysqli_error($conn) . "</p>";
  }
}
?>
