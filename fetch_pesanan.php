<?php
include 'koneksi.php';

$warna = [
  'diproses' => 'bg-yellow-200 text-yellow-800',
  'diantar' => 'bg-blue-200 text-blue-800',
  'selesai' => 'bg-green-200 text-green-800'
];

$query = mysqli_query($conn, "
  SELECT
    ps.id_pesanan,
    pg.nama AS nama_pelanggan,
    ps.tanggal,
    ps.metode,
    ps.status_pesanan,
    pb.metode AS metode_bayar,
    pb.status_pembayaran,
    pb.bukti,
    COALESCE(SUM(dp.subtotal), 0) AS total
  FROM pesanan ps
  JOIN pelanggan pg ON ps.id_pelanggan = pg.id_pelanggan
  LEFT JOIN pembayaran pb ON ps.id_pesanan = pb.id_pesanan
  LEFT JOIN detail_pesanan dp ON ps.id_pesanan = dp.id_pesanan
  GROUP BY ps.id_pesanan
  ORDER BY ps.tanggal DESC
");

if (mysqli_num_rows($query) === 0) {
  echo "<tr><td colspan='11' class='text-center text-gray-500 p-4'>Tidak ada data pesanan.</td></tr>";
}

while ($row = mysqli_fetch_assoc($query)) :
?>
  <tr class="text-center border-t hover:bg-gray-50">
    <td class="p-3">#<?= $row['id_pesanan'] ?></td>
    <td class="p-3"><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
    <td class="p-3"><?= $row['tanggal'] ?></td>
    <td class="p-3"><?= htmlspecialchars($row['metode']) ?></td>
    <td class="p-3"><?= htmlspecialchars($row['metode_bayar'] ?? '-') ?></td>
    <td class="p-3">
      <?php if (!empty($row['bukti'])): ?>
        <a href="bukti/<?= $row['bukti'] ?>" target="_blank" class="px-2 py-1 rounded text-white bg-green-500">Lihat</a>
      <?php else: ?>
        <span class="text-gray-400 italic">-</span>
      <?php endif; ?>
    </td>
    <td class="p-3">
      <?php if ($row['status_pembayaran'] == 'lunas') : ?>
        <span class="px-2 py-1 rounded text-white bg-green-500">Lunas</span>
      <?php else : ?>
        <form action="konfirmasi_pembayaran.php" method="POST">
          <input type="hidden" name="id_pesanan" value="<?= $row['id_pesanan'] ?>">
          <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 text-sm">Konfirmasi</button>
        </form>
      <?php endif; ?>
    </td>
    <td class="p-3">
      <span class="px-2 py-1 rounded <?= $warna[$row['status_pesanan']] ?>">
        <?= ucfirst($row['status_pesanan']) ?>
      </span>
    </td>
    <td class="p-3">
      <form method="POST" action="ubah_status_pesanan.php" class="flex justify-center items-center gap-1">
        <input type="hidden" name="id_pesanan" value="<?= $row['id_pesanan'] ?>">
        <select name="status" class="border rounded p-1 text-sm">
          <option value="diproses" <?= $row['status_pesanan'] === 'diproses' ? 'selected' : '' ?>>Diproses</option>
          <option value="diantar" <?= $row['status_pesanan'] === 'diantar' ? 'selected' : '' ?>>Diantar</option>
          <option value="selesai" <?= $row['status_pesanan'] === 'selesai' ? 'selected' : '' ?>>Selesai</option>
        </select>
        <button type="submit" class="px-2 py-1 bg-amber-500 text-black rounded text-xs">Ubah</button>
      </form>
    </td>
    <td class="p-3">Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
    <td class="p-3">
      <button
        class="px-2 py-1 bg-indigo-500 text-white rounded hover:bg-indigo-600 text-xs"
        onclick="showDetail(<?= $row['id_pesanan'] ?>)"
      >
        Detail
      </button>
    </td>
  </tr>
<?php endwhile; ?>
