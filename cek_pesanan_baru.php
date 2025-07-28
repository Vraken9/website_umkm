<?php
include 'koneksi.php';

// Cek pesanan terbaru dengan pembayaran lunas
$query = mysqli_query($conn, "
  SELECT MAX(p.id_pesanan) as id
  FROM pesanan p
  JOIN pembayaran pb ON p.id_pesanan = pb.id_pesanan
  WHERE pb.status_pembayaran = 'lunas'
");

$data = mysqli_fetch_assoc($query);
$id = $data['id'] ?? 0;

echo json_encode([
  'new_order' => $id > 0,
  'id' => (int)$id
]);
