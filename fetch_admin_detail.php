<?php
include 'koneksi.php';

$id = intval($_GET['id'] ?? 0);
if (!$id) {
  echo "ID tidak valid.";
  exit;
}

// Ambil info pesanan
$pesanan = mysqli_query($conn, "
  SELECT 
    ps.tanggal,
    ps.metode,
    pg.nama,
    pg.umur,
    pg.no_hp,
    pg.alamat,
    m.nomor_meja
  FROM pesanan ps
  JOIN pelanggan pg ON ps.id_pelanggan = pg.id_pelanggan
  LEFT JOIN meja m ON ps.id_meja = m.id_meja
  WHERE ps.id_pesanan = $id
");
$data = mysqli_fetch_assoc($pesanan);

if (!$data) {
  echo "Data tidak ditemukan.";
  exit;
}

// Ambil daftar produk
$menu = mysqli_query($conn, "
  SELECT pr.nama_produk, dp.jumlah, pr.harga
  FROM detail_pesanan dp
  JOIN produk pr ON dp.id_produk = pr.id_produk
  WHERE dp.id_pesanan = $id
");

$total = 0;
?>

<h2 class="text-lg font-bold mb-2 text-center">Detail Pesanan</h2>
<div class="mb-2"><strong>Nama:</strong> <?= htmlspecialchars($data['nama']) ?></div>
<div class="mb-2"><strong>Umur:</strong> <?= htmlspecialchars($data['umur']) ?> tahun</div>
<?php if ($data['metode'] === 'Diantar') : ?>
  <div class="mb-2"><strong>No HP:</strong> <?= htmlspecialchars($data['no_hp']) ?></div>
  <div class="mb-2"><strong>Alamat:</strong> <?= htmlspecialchars($data['alamat']) ?></div>
<?php elseif ($data['metode'] === 'Makan di Tempat') : ?>
  <div class="mb-2"><strong>Nomor Meja:</strong> <?= htmlspecialchars($data['nomor_meja'] ?? '-') ?></div>
<?php endif; ?>
<div class="mb-4"><strong>Tanggal:</strong> <?= $data['tanggal'] ?></div>

<table class="w-full text-sm">
  <thead>
    <tr>
      <th class="text-left">Produk</th>
      <th class="text-right">Jumlah</th>
      <th class="text-right">Harga</th>
      <th class="text-right">Subtotal</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($item = mysqli_fetch_assoc($menu)) : 
      $subtotal = $item['jumlah'] * $item['harga'];
      $total += $subtotal;
    ?>
      <tr>
        <td><?= htmlspecialchars($item['nama_produk']) ?></td>
        <td class="text-right"><?= $item['jumlah'] ?></td>
        <td class="text-right">Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
        <td class="text-right">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
  <tfoot>
    <tr class="font-bold">
      <td colspan="3" class="text-right">Total:</td>
      <td class="text-right">Rp <?= number_format($total, 0, ',', '.') ?></td>
    </tr>
  </tfoot>
</table>
