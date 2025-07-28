<?php
include 'koneksi.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = mysqli_query($conn, "SELECT status_pembayaran FROM pembayaran WHERE id_pesanan = $id");
$data = mysqli_fetch_assoc($query);

echo json_encode([
  'status' => strtolower($data['status_pembayaran'] ?? 'belum')
]);
?>
