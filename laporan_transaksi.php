<?php
session_start();
include 'koneksi.php';
include 'auth_admin.php'; 

$query = mysqli_query($conn, "
  SELECT 
    ps.id_pesanan,
    pg.nama AS nama_pelanggan,
    ps.tanggal,
    pb.metode AS metode_bayar,
    pb.status_pembayaran,
    COALESCE(SUM(dp.subtotal), 0) AS total
  FROM pesanan ps
  JOIN pelanggan pg ON ps.id_pelanggan = pg.id_pelanggan
  LEFT JOIN pembayaran pb ON ps.id_pesanan = pb.id_pesanan
  LEFT JOIN detail_pesanan dp ON ps.id_pesanan = dp.id_pesanan
  GROUP BY ps.id_pesanan
  ORDER BY ps.tanggal DESC
");

$total_semua = 0;
?>

<!DOCTYPE html>
<html>
<head>
  <title>Laporan Transaksi</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-5xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold text-amber-600 mb-4 text-center">📄 Laporan Transaksi</h1>

    <table class="w-full border text-center text-sm">
      <thead class="bg-gray-200">
        <tr>
          <th class="p-2 border">ID</th>
          <th class="p-2 border">Pelanggan</th>
          <th class="p-2 border">Tanggal</th>
          <th class="p-2 border">Metode Bayar</th>
          <th class="p-2 border">Status</th>
          <th class="p-2 border">Total</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($query)) : ?>
        <tr>
          <td class="border p-2">#<?= $row['id_pesanan'] ?></td>
          <td class="border p-2"><?= $row['nama_pelanggan'] ?></td>
          <td class="border p-2"><?= $row['tanggal'] ?></td>
          <td class="border p-2"><?= $row['metode_bayar'] ?? '-' ?></td>
          <td class="border p-2">
            <span class="px-2 py-1 rounded text-white <?= $row['status_pembayaran'] == 'lunas' ? 'bg-green-500' : 'bg-red-500' ?>">
              <?= ucfirst($row['status_pembayaran'] ?? 'belum') ?>
            </span>
          </td>
          <td class="border p-2">Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
        </tr>
        <?php $total_semua += $row['total']; endwhile; ?>
        <tr class="font-bold bg-gray-100">
          <td colspan="5" class="p-2 border text-right">Total Omset:</td>
          <td class="p-2 border">Rp <?= number_format($total_semua, 0, ',', '.') ?></td>
        </tr>
      </tbody>
    </table>

    <div class="text-center mt-4">
      <a href="dashboard_admin.php" class="text-blue-600 hover:underline">← Kembali ke Dashboard</a>
    </div>
  </div>
</body>
</html>
