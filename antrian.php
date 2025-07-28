<?php
include 'koneksi.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
  echo "<h2 class='text-center text-red-600 mt-4'>ID pesanan tidak valid</h2>";
  exit;
}

$pesanan = mysqli_query($conn, "
  SELECT p.*, pl.nama, pl.umur, pl.alamat, k.nama AS nama_karyawan
  FROM pesanan p
  JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
  LEFT JOIN karyawan k ON p.id_karyawan_delivery = k.id_karyawan
  WHERE p.id_pesanan = $id
");

$data = mysqli_fetch_assoc($pesanan);
if (!$data) {
  echo "<h2 class='text-center text-red-600 mt-4'>Pesanan tidak ditemukan</h2>";
  exit;
}

$cekBayar = mysqli_query($conn, "SELECT status_pembayaran FROM pembayaran WHERE id_pesanan = $id");
$bayar = mysqli_fetch_assoc($cekBayar);
if (!$bayar || strtolower($bayar['status_pembayaran']) !== 'lunas') {
  echo "<h2 class='text-center text-red-600 mt-4'>Pembayaran belum dikonfirmasi oleh admin</h2>";
  exit;
}

$detail = mysqli_query($conn, "
  SELECT dp.jumlah, dp.harga_satuan, pr.nama_produk 
  FROM detail_pesanan dp
  JOIN produk pr ON dp.id_produk = pr.id_produk
  WHERE dp.id_pesanan = $id
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="refresh" content="3"> <!-- Auto-refresh setiap 3 detik -->
  <title>Antrian Pemesanan</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-yellow-50 text-gray-800">
  <div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-lg">
    <h1 class="text-3xl font-bold text-center text-amber-600 mb-6">Status Pesanan Anda</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm md:text-base mb-6">
      <div>
        <p class="mb-2"><span class="font-bold">Nama:</span> <?= htmlspecialchars($data['nama']) ?></p>
        <p class="mb-2"><span class="font-bold">Umur:</span> <?= $data['umur'] ?> tahun</p>
        <?php if ($data['metode'] === 'Diantar'): ?>
          <p class="mb-2"><span class="font-bold">Alamat:</span> <?= $data['alamat'] ?></p>
        <?php endif; ?>
        <p class="mb-2"><span class="font-bold">Metode Makan:</span> <?= $data['metode'] ?></p>
        <?php if ($data['metode'] === 'Makan di Tempat' && $data['id_meja']) :
          $meja = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM meja WHERE id_meja = {$data['id_meja']}"));
          echo "<p class='mb-2'><span class='font-bold'>Nomor Meja:</span> Meja {$meja['nomor_meja']} (Kapasitas {$meja['kapasitas']})</p>";
        endif; ?>
        <p class="mb-2"><span class="font-bold">Waktu Pemesanan:</span> <?= $data['tanggal'] ?></p>
      </div>
    </div>

    <h2 class="text-xl font-bold text-gray-700 mb-3 border-b pb-1">Rincian Pesanan</h2>
    <table class="w-full table-auto text-sm md:text-base border mb-6">
      <thead class="bg-amber-100 text-gray-800">
        <tr>
          <th class="px-3 py-2 border">Menu</th>
          <th class="px-3 py-2 border">Jumlah</th>
          <th class="px-3 py-2 border">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $total = 0;
        while ($row = mysqli_fetch_assoc($detail)) {
          $subtotal = $row['jumlah'] * $row['harga_satuan'];
          $total += $subtotal;
          echo "<tr>
            <td class='border px-3 py-2'>" . htmlspecialchars($row['nama_produk']) . "</td>
            <td class='border px-3 py-2 text-center'>{$row['jumlah']}</td>
            <td class='border px-3 py-2'>Rp " . number_format($subtotal, 0, ',', '.') . "</td>
          </tr>";
        }
        ?>
        <tr class="font-semibold bg-yellow-100">
          <td colspan="2" class="border px-3 py-2 text-right">Total</td>
          <td class="border px-3 py-2">Rp <?= number_format($total, 0, ',', '.') ?></td>
        </tr>
      </tbody>
    </table>

    <div class="mt-6 bg-green-50 p-4 rounded shadow text-center text-sm md:text-base text-blue-700">
      <p class="font-medium">Status Pesanan: <?= ucfirst($data['status_pesanan']) ?></p>
      <?php if ($data['status_pesanan'] === 'diproses'): ?>
        <p class="text-gray-600 mt-1">Pesanan sedang disiapkan di dapur.</p>
      <?php elseif ($data['status_pesanan'] === 'diantar' && $data['nama_karyawan']): ?>
        <p class="mt-1">Sedang diantar oleh: <strong><?= htmlspecialchars($data['nama_karyawan']) ?></strong></p>
      <?php elseif ($data['status_pesanan'] === 'selesai'): ?>
        <p class="text-green-500 mt-1 font-medium">Pesanan selesai. Terima kasih telah memesan.</p>
      <?php endif; ?>
    </div>

    <?php if ($data['status_pesanan'] === 'selesai'): ?>
    <div class="mt-8 text-center space-y-4">
      <a href="index.php" class="inline-block bg-green-100 gray-800 px-5 py-2 rounded shadow">
        Kembali ke Beranda
      </a>
      <a href="review.php?id=<?= $id ?>" class="inline-block bg-yellow-100 gray-800 px-5 py-2 rounded shadow">
        Berikan Review
      </a>
    </div>
    <?php endif; ?>
  </div>
</body>
</html>
