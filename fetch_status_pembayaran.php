<?php
include 'koneksi.php';
$id = intval($_GET['id']);

$response = [
  'status_konfirmasi' => 'belum',
  'status_pembayaran' => 'belum'
];

$q = mysqli_query($conn, "SELECT status_konfirmasi, status_pembayaran FROM pembayaran WHERE id_pesanan = $id LIMIT 1");
if ($row = mysqli_fetch_assoc($q)) {
  $response['status_konfirmasi'] = $row['status_konfirmasi'];
  $response['status_pembayaran'] = $row['status_pembayaran'];
}

header('Content-Type: application/json');
echo json_encode($response);
