<?php
include 'koneksi.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$data = mysqli_query($conn, "
  SELECT p.metode, pl.nama 
  FROM pesanan p
  JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
  WHERE p.id_pesanan = $id
");
$row = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Review Berhasil</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-green-50 flex items-center justify-center h-screen">
  <div class="bg-white p-8 rounded shadow max-w-md w-full text-center">
    <h2 class="text-2xl font-bold text-amber-600 mb-4">🎉 Terima Kasih, <?= htmlspecialchars($row['nama']) ?>!</h2>
    <p class="text-gray-700 mb-2">Review Anda telah kami terima.</p>
    <p class="mb-4">🙏 Terima kasih telah makan di tempat kami.</p>

    <div class="bg-amber-100 text-amber-800 p-4 rounded mb-4">
      <p>Status Pesanan: <strong>Sedang diproses<?= $row['metode'] === 'Diantar' ? ' / Diantar' : '' ?></strong></p>
      <p>👨‍🍳 Admin akan segera menindaklanjuti pesanan Anda.</p>
    </div>

    <a href="index.php" class="inline-block mt-4 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded">Kembali ke Beranda</a>
  </div>
</body>
</html>
