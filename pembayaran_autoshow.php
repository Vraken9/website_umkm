
<?php
include 'koneksi.php';

$id_pesanan = isset($_GET['id_pesanan']) ? intval($_GET['id_pesanan']) : 0;

$query = mysqli_query($conn, "
  SELECT p.id_pesanan, pg.nama, pg.umur, p.tanggal
  FROM pesanan p
  JOIN pelanggan pg ON p.id_pelanggan = pg.id_pelanggan
  WHERE p.id_pesanan = $id_pesanan
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
  echo "<div style='text-align:center;margin-top:50px;color:red;'>
          <h2>❗ Pesanan tidak ditemukan!</h2>
          <p>Periksa kembali ID pesanan yang kamu masukkan di URL.</p>
        </div>";
  exit;
}

// Ringkasan menu
$menu = mysqli_query($conn, "
  SELECT pr.nama_produk, dp.jumlah, dp.harga_satuan, dp.subtotal
  FROM detail_pesanan dp
  JOIN produk pr ON dp.id_produk = pr.id_produk
  WHERE dp.id_pesanan = $id_pesanan
");

$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
  <title>Konfirmasi Pembayaran</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script>
    function tampilkanInstruksi() {
      const metode = document.getElementById('metode').value;
      const instruksi = document.getElementById('instruksi');

      if (metode === 'QRIS') {
        instruksi.innerHTML = "<p class='text-center mt-4'>Silakan scan QRIS berikut:</p><img src='qris.jpg' class='mx-auto my-2 max-w-[200px]' />";
      } else if (metode === 'Transfer') {
        instruksi.innerHTML = "<p class='text-center mt-4'>Silakan transfer ke rekening:</p><p class='text-center font-semibold'>BRI 6624 0103 7567 538 a.n. Warung Kita</p>";
      } else {
        instruksi.innerHTML = "<p class='text-center mt-4'>Silakan bayar langsung ke kasir saat di tempat.</p>";
      }
    }
  </script>
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-2xl mx-auto bg-white shadow p-6 rounded-lg">
    <h2 class="text-2xl font-bold mb-4 text-center text-amber-600">Pembayaran Pesanan</h2>
    <p><strong>Nama:</strong> <?= $data['nama'] ?></p>
    <p><strong>Umur:</strong> <?= $data['umur'] ?> tahun</p>
    <p><strong>Tanggal Pesan:</strong> <?= $data['tanggal'] ?></p>

    <h3 class="mt-6 text-lg font-semibold text-gray-800">Ringkasan Pesanan:</h3>
    <table class="w-full mt-2 mb-4 border border-gray-300 rounded">
      <thead class="bg-gray-100">
        <tr>
          <th class="py-2 border">Menu</th>
          <th class="py-2 border">Jumlah</th>
          <th class="py-2 border">Harga</th>
          <th class="py-2 border">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($r = mysqli_fetch_assoc($menu)) :
          $total += $r['subtotal'];
        ?>
        <tr class="text-center">
          <td class="py-1 border"><?= $r['nama_produk'] ?></td>
          <td class="py-1 border"><?= $r['jumlah'] ?></td>
          <td class="py-1 border">Rp <?= number_format($r['harga_satuan'], 0, ',', '.') ?></td>
          <td class="py-1 border">Rp <?= number_format($r['subtotal'], 0, ',', '.') ?></td>
        </tr>
        <?php endwhile; ?>
        <tr class="bg-gray-200 font-semibold text-center">
          <td colspan="3" class="py-2 border">Total</td>
          <td class="py-2 border">Rp <?= number_format($total, 0, ',', '.') ?></td>
        </tr>
      </tbody>
    </table>

    <form action="proses_bayar.php" method="POST" class="mt-6">
      <input type="hidden" name="id_pesanan" value="<?= $id_pesanan ?>" />
      <label class="block mb-2 font-semibold">Pilih Metode Pembayaran:</label>
      <select name="metode" id="metode" onchange="tampilkanInstruksi()" required class="w-full p-2 border rounded mb-4">
        <option value="">-- Pilih --</option>
        <option value="Cash">Cash</option>
        <option value="Transfer">Transfer</option>
        <option value="QRIS">QRIS</option>
      </select>

      <div id="instruksi" class="text-sm text-gray-700 mb-4"></div>

      <button type="submit" class="w-full bg-amber-500 text-white py-2 px-4 rounded hover:bg-amber-600">Konfirmasi Pembayaran</button>
    </form>
  </div>
</body>
</html>
