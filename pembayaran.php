<?php
include 'koneksi.php';

$id_pesanan = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Cek apakah pesanan ada
$cek = mysqli_query($conn, "SELECT * FROM pesanan WHERE id_pesanan = $id_pesanan");
if (mysqli_num_rows($cek) == 0) {
  echo "<h2 style='color:red; text-align:center;'>Pesanan tidak ditemukan</h2>";
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Pembayaran</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script>
    function tampilkanInstruksi() {
      const metode = document.getElementById("metode").value;
      const instruksi = document.getElementById("instruksi");

      if (metode === "QRIS") {
        instruksi.innerHTML = "<p class='mt-3 text-center'>Silakan scan QRIS berikut:</p><img src='qris.jpg' class='mx-auto my-2 max-w-[200px]' />";
      } else if (metode === "Transfer") {
        instruksi.innerHTML = "<p class='mt-3 text-center'>Silakan transfer ke:</p><p class='text-center font-semibold'>BRI 6624 0103 7567 538 a.n. Warung Kita</p>";
      } else {
        instruksi.innerHTML = "<p class='mt-3 text-center'>Silakan bayar langsung ke kasir.</p>";
      }
    }
  </script>
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-xl mx-auto bg-white shadow-md rounded p-6">
    <h2 class="text-2xl font-bold text-amber-600 mb-4 text-center">Pembayaran</h2>

    <form action="proses_bayar.php" method="POST">
      <input type="hidden" name="id_pesanan" value="<?= $id_pesanan ?>">

      <label class="block mb-2">Metode Pembayaran</label>
      <select name="metode" id="metode" onchange="tampilkanInstruksi()" class="w-full border p-2 rounded mb-4" required>
        <option value="">-- Pilih Metode --</option>
        <option value="Cash">Cash</option>
        <option value="QRIS">QRIS</option>
        <option value="Transfer">Transfer</option>
      </select>

      <div id="instruksi" class="text-sm text-gray-700 mb-4"></div>

      <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
        ✅ Saya Sudah Membayar
      </button>
    </form>

    <div class="mt-4 text-center">
      <a href="index.php" class="text-blue-500 text-sm hover:underline">← Kembali ke Beranda</a>
    </div>
  </div>
</body>
</html>
