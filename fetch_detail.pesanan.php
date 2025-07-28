<?php
include 'koneksi.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = mysqli_query($conn, "
  SELECT ps.*, pg.nama, pb.status_pembayaran, pb.metode AS metode_bayar, pb.bukti
  FROM pesanan ps
  JOIN pelanggan pg ON ps.id_pelanggan = pg.id_pelanggan
  LEFT JOIN pembayaran pb ON ps.id_pesanan = pb.id_pesanan
  WHERE ps.id_pesanan = $id
");

$data = mysqli_fetch_assoc($query);

// Ambil detail item pesanan
$items = mysqli_query($conn, "
  SELECT pr.nama_produk, dp.jumlah, dp.subtotal
  FROM detail_pesanan dp
  JOIN produk pr ON dp.id_produk = pr.id_produk
  WHERE dp.id_pesanan = $id
");

// Tampilkan status & item
?>
<div class="mb-4">
  <p><strong>Status Pembayaran:</strong> <?= $data['status_pembayaran'] ?? 'Belum bayar' ?></p>
  <p><strong>Status Pesanan:</strong> <?= ucfirst($data['status_pesanan']) ?></p>
</div>

<h3 class="font-bold mb-2">Daftar Pesanan:</h3>
<ul class="list-disc pl-6 mb-4">
  <?php while ($row = mysqli_fetch_assoc($items)): ?>
    <li><?= $row['nama_produk'] ?> - <?= $row['jumlah'] ?> pcs - Rp <?= number_format($row['subtotal'], 0, ',', '.') ?></li>
  <?php endwhile; ?>
</ul>
