
<?php
include 'koneksi.php';

$id_pesanan = isset($_GET['id_pesanan']) ? intval($_GET['id_pesanan']) : 0;

$query = mysqli_query($conn, "
  SELECT p.id_pesanan, pg.nama, p.status, k.nama AS kurir
  FROM pesanan p
  JOIN pelanggan pg ON p.id_pelanggan = pg.id_pelanggan
  LEFT JOIN karyawan k ON p.id_karyawan_antar = k.id_karyawan
  WHERE p.id_pesanan = $id_pesanan
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
  echo "<h2 style='text-align:center;color:red;'>Pesanan tidak ditemukan</h2>";
  exit;
}

$status = $data['status'];
$nama = $data['nama'];
$kurir = $data['kurir'] ?: '-';
?>

<!DOCTYPE html>
<html>
<head>
  <title>Status Pesanan</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 p-6">
  <div class="max-w-xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-bold text-center text-amber-600 mb-4">Status Pesanan Anda</h2>
    <p class="text-lg mb-2"><strong>Nama:</strong> <?= $nama ?></p>
    <p class="text-lg mb-2"><strong>ID Pesanan:</strong> <?= $id_pesanan ?></p>
    <p class="text-lg mb-2"><strong>Status Saat Ini:</strong> 
      <span class="font-semibold text-blue-600"><?= ucfirst($status ?: 'Belum Ditetapkan') ?></span>
    </p>

    <?php if ($status === 'dikirim' && $kurir !== '-') : ?>
      <p class="text-lg mt-2 text-green-700">📦 Kurir Pengantar: <strong><?= $kurir ?></strong></p>
    <?php elseif ($status === 'selesai') : ?>
      <p class="text-lg mt-2 text-green-700">✅ Pesanan Anda telah selesai.</p>
    <?php else : ?>
      <p class="text-lg mt-2 text-yellow-600">⏳ Pesanan Anda sedang diproses. Mohon tunggu.</p>
    <?php endif; ?>
  </div>
</body>
</html>
