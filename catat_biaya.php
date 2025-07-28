<?php
session_start();
include 'koneksi.php';
include 'auth_admin.php'; 


// Simpan jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $tanggal = $_POST['tanggal'];
  $kategori = $_POST['kategori_biaya'];
  $deskripsi = $_POST['deskripsi'];
  $nominal = intval($_POST['nominal']);

  $query = "INSERT INTO biaya (tanggal, kategori_biaya, deskripsi, nominal)
            VALUES ('$tanggal', '$kategori', '$deskripsi', $nominal)";
  mysqli_query($conn, $query);
  header("Location: catat_biaya.php?sukses=1");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Catat Pengeluaran</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-xl mx-auto bg-white shadow p-6 rounded">
    <h2 class="text-2xl font-bold text-amber-600 mb-4">📝 Catat Pengeluaran</h2>

    <?php if (isset($_GET['sukses'])) : ?>
      <p class="text-green-600 mb-4">✅ Pengeluaran berhasil dicatat.</p>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
      <div>
        <label class="block font-medium">Tanggal</label>
        <input type="date" name="tanggal" required class="border rounded w-full p-2">
      </div>
      <div>
        <label class="block font-medium">Kategori</label>
        <select name="kategori_biaya" required class="border rounded w-full p-2">
          <option value="">-- Pilih --</option>
          <option value="Gaji Karyawan">Gaji Karyawan</option>
          <option value="Belanja Bahan">Belanja Bahan</option>
          <option value="Operasional">Operasional</option>
          <option value="Lainnya">Lainnya</option>
        </select>
      </div>
      <div>
        <label class="block font-medium">Deskripsi</label>
        <textarea name="deskripsi" rows="3" class="border rounded w-full p-2" placeholder="Contoh: Bayar beras, minyak..."></textarea>
      </div>
      <div>
        <label class="block font-medium">Nominal (Rp)</label>
        <input type="number" name="nominal" required class="border rounded w-full p-2">
      </div>
      <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-black px-4 py-2 rounded">Simpan</button>
      <a href="dashboard_admin.php" class="ml-4 text-gray-600">← Kembali</a>
    </form>
  </div>
</body>
</html>
