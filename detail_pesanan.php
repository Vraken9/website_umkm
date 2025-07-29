<?php
include 'koneksi.php';

$id_pesanan = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id_pesanan <= 0) {
    echo "<h2 class='text-center text-red-600 mt-4'>ID pesanan tidak valid</h2>";
    exit;
}

$query = mysqli_query($conn, "
  SELECT p.*, pg.nama, pg.umur, pg.alamat AS alamat_pelanggan
  FROM pesanan p
  JOIN pelanggan pg ON p.id_pelanggan = pg.id_pelanggan
  WHERE p.id_pesanan = $id_pesanan
");
$data = mysqli_fetch_assoc($query);
if (!$data) {
    echo "<h2 class='text-center text-red-600 mt-4'>Pesanan tidak ditemukan</h2>";
    exit;
}

// Cek status pembayaran
$pembayaran = mysqli_query($conn, "SELECT * FROM pembayaran WHERE id_pesanan = $id_pesanan");
$status_bayar = "belum";
$metode_terpilih = "";
$status_konfirmasi = "";
if (mysqli_num_rows($pembayaran)) {
    $row = mysqli_fetch_assoc($pembayaran);
    $status_bayar = $row['status_pembayaran'];
    $metode_terpilih = $row['metode'];
    $status_konfirmasi = $row['status_konfirmasi'] ?? '';
    $bukti_transfer = $row['bukti'] ?? '';
    if ($status_bayar === 'lunas') {
        header("Location: antrian.php?id=$id_pesanan");
        exit;
    }
}

$menu = mysqli_query($conn, "
  SELECT pr.nama_produk, dp.jumlah, dp.harga_satuan, dp.subtotal
  FROM detail_pesanan dp
  JOIN produk pr ON dp.id_produk = pr.id_produk
  WHERE dp.id_pesanan = $id_pesanan
");
$total = 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Pesanan</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script>
function tampilkanInstruksi() {
  const metodeEl = document.getElementById('metode');
  if (!metodeEl) return;

  const metode_makan = metodeEl.dataset.metode || '';
  const instruksi = document.getElementById('instruksi');
  const uploadBox = document.getElementById('uploadBox');
  const selected = metodeEl.value;
  const salinBtn = (isi) => `<button type="button" onclick="salin('${isi}')" class="bg-yellow-300 px-2 py-1 rounded ml-2 hover:bg-yellow-400">Salin</button>`;

  // Sembunyikan opsi Cash jika metode makan Diantar
  if (metode_makan === 'Diantar') {
    const opsiCash = Array.from(metodeEl.options).find(opt => opt.value === 'Cash');
    if (opsiCash) opsiCash.style.display = 'none';
  }

  // Default: sembunyikan uploadBox jika cash
  uploadBox.style.display = selected === 'Cash' ? 'none' : 'block';

  let html = '';
  switch (selected) {
    case 'Transfer BTN':
      html = `Transfer ke BTN: <b>0069601610029774 a.n. Akhyar Mualif</b> ${salinBtn('0069601610029774')}`;
      break;
    case 'Transfer BRI':
      html = `Transfer ke BRI: <b>662501037567538 a.n. Akhyar Mualif</b> ${salinBtn('662501037567538')}`;
      break;
    case 'DANA':
    case 'Gopay':
    case 'ShopeePay':
      html = `${selected} ke: <b>089530123608 a.n. Akhyar Mualif</b> ${salinBtn('089530123608')}`;
      break;
    case 'USDT':
      html = `USDT (BNB Smart Chain - BEP20):<br><b>0xdbfa6bd10424a3ed864328ec8229c60e29f2067d</b> ${salinBtn('0xdbfa6bd10424a3ed864328ec8229c60e29f2067d')}`;
      break;
    case 'Ethereum':
      html = `Ethereum (ERC20):<br><b>0xdbfa6bd10424a3ed864328ec8229c60e29f2067d</b> ${salinBtn('0xdbfa6bd10424a3ed864328ec8229c60e29f2067d')}`;
      break;
    case 'Solana':
      html = `Solana:<br><b>ABfLZ7LGWXktE56pD1tnJBsDmnA8SSVFSL2xqPKMdXaR</b> ${salinBtn('ABfLZ7LGWXktE56pD1tnJBsDmnA8SSVFSL2xqPKMdXaR')}`;
      break;
    case 'Binance QR':
      html = `<p class="text-center mb-2">Scan QR Binance Pay:</p><img src="gambar/binance.jpg" alt="Binance QR" class="mx-auto rounded shadow-md max-w-[200px]">`;
      break;
    case 'Cash':
      html = "Silakan bayar langsung ke kasir.";
      break;
  }

  instruksi.innerHTML = html;
}

function salin(teks) {
  navigator.clipboard.writeText(teks);
  alert("📋 Disalin:\n" + teks);
}

window.onload = tampilkanInstruksi;
</script>

</head>
<body class="bg-yellow-50 p-6">
  <div class="max-w-3xl mx-auto bg-white shadow-lg p-6 rounded-md">
    <h2 class="text-2xl font-bold text-center text-yellow-700 mb-4">🧾 Detail Pesanan</h2>

    <p><strong>Nama:</strong> <?= htmlspecialchars($data['nama']) ?></p>
    <p><strong>Umur:</strong> <?= $data['umur'] ?> tahun</p>

    <?php if ($data['metode'] === 'Diantar') : ?>
      <p><strong>Alamat:</strong> <?= $data['alamat_pelanggan'] ?: '-' ?></p>
    <?php endif; ?>

    <p><strong>Metode Makan:</strong> <?= $data['metode'] ?></p>

    <?php if ($data['metode'] === 'Makan di Tempat' && $data['id_meja']) :
      $meja = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM meja WHERE id_meja = {$data['id_meja']}"));
      echo "<p><strong>Nomor Meja:</strong> Meja {$meja['nomor_meja']} (Kapasitas {$meja['kapasitas']})</p>";
    endif; ?>

    <p><strong>Tanggal:</strong> <?= $data['tanggal'] ?></p>

    <h3 class="text-lg font-semibold mt-6 mb-3"> Daftar Pesanan</h3>
    <table class="w-full border text-center text-sm mb-4">
      <thead class="bg-amber-100">
        <tr>
          <th class="border p-2">Menu</th>
          <th class="border p-2">Jumlah</th>
          <th class="border p-2">Harga</th>
          <th class="border p-2">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($menu)) :
          $total += $row['subtotal']; ?>
          <tr>
            <td class="border p-2"><?= htmlspecialchars($row['nama_produk']) ?></td>
            <td class="border p-2"><?= $row['jumlah'] ?></td>
            <td class="border p-2">Rp <?= number_format($row['harga_satuan'], 0, ',', '.') ?></td>
            <td class="border p-2">Rp <?= number_format($row['subtotal'], 0, ',', '.') ?></td>
          </tr>
        <?php endwhile; ?>
        <tr class="bg-yellow-100 font-semibold">
          <td colspan="3" class="border p-2">Total</td>
          <td class="border p-2">Rp <?= number_format($total, 0, ',', '.') ?></td>
        </tr>
      </tbody>
    </table>

   <!-- bagian status -->
<div id="status-container" class="text-center mt-4">
  <?php if ($status_konfirmasi === 'pending' && $status_bayar === 'belum') : ?>
    <p class="text-green-600 font-semibold">⏳ Bukti pembayaran sudah dikirim. Menunggu konfirmasi admin...</p>
  

    <?php elseif (!$metode_terpilih) : ?>
      <form action="proses_bayar.php" method="POST" enctype="multipart/form-data" class="mt-4">
        <input type="hidden" name="id_pesanan" value="<?= $id_pesanan ?>">
        <label class="block mb-1 font-medium">💰 Pilih Metode Pembayaran:</label>
       <select name="metode" id="metode" onchange="tampilkanInstruksi()" class="w-full p-2 border rounded mb-2" required data-metode="<?= $data['metode'] ?>">

            <option value="">-- Pilih --</option>
            <option value="Cash">Cash</option>
            <option value="Transfer BTN">Transfer BTN</option>
            <option value="Transfer BRI">Transfer BRI</option>
            <option value="DANA">DANA</option>
            <option value="Gopay">Gopay</option>
            <option value="ShopeePay">ShopeePay</option>
            <option value="USDT">USDT (BEP20)</option>
            <option value="Ethereum">Ethereum (ERC20)</option>
            <option value="Solana">Solana</option>
            <option value="Binance QR">Binance QR</option>
        </select>

        <div id="instruksi" class="text-sm text-gray-700 mb-3"></div>

        <div id="uploadBox" style="display:none;">
            <label class="block mb-1 font-medium">🧾 Upload Bukti Pembayaran:</label>
            <input type="file" name="bukti" accept="image/*" class="mb-3 w-full border p-2 rounded bg-gray-50" />
        </div>

        <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded font-semibold">
            Konfirmasi Pembayaran
        </button>
      </form>
    <?php endif; ?>
   
</div>


    <form action="index.php" method="get">
      <button type="submit" class="mt-4 w-full bg-gray-200 hover:bg-yellow-100 py-2 px-4 rounded">
         Kembali ke Beranda 
      </button>
    </form>
  </div>
 <script>
  function cekStatus() {
    fetch("fetch_status_pembayaran.php?id=<?= $id_pesanan ?>")
      .then(res => res.json())
      .then(data => {
        if (data.status_konfirmasi === "disetujui" && data.status_pembayaran === "lunas") {
          window.location.href = "antrian.php?id=<?= $id_pesanan ?>";
        } else if (data.status_konfirmasi === "pending") {
          document.getElementById("status-container").innerHTML =
            "<p class='text-green-600 font-semibold'>⏳ Bukti pembayaran sudah dikirim. Menunggu konfirmasi admin...</p>";
        }
      });
  }

  // Cek status tiap 5 detik
  setInterval(cekStatus, 5000);
</script>


</body>
</html>
