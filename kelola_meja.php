<?php
session_start();
include 'koneksi.php';
include 'auth_admin.php'; 


// Tambah meja
if (isset($_POST['tambah'])) {
  $nomor = mysqli_real_escape_string($conn, $_POST['nomor_meja']);
  $kapasitas = intval($_POST['kapasitas']);
  mysqli_query($conn, "INSERT INTO meja (nomor_meja, kapasitas) VALUES ('$nomor', $kapasitas)");
  header("Location: kelola_meja.php");
  exit;
}

// Edit meja
if (isset($_POST['edit'])) {
  $id = intval($_POST['id_meja']);
  $nomor = mysqli_real_escape_string($conn, $_POST['nomor_meja']);
  $kapasitas = intval($_POST['kapasitas']);
  $status = $_POST['status'];
  mysqli_query($conn, "UPDATE meja SET nomor_meja='$nomor', kapasitas=$kapasitas, status='$status' WHERE id_meja=$id");
  header("Location: kelola_meja.php");
  exit;
}

$meja = mysqli_query($conn, "SELECT * FROM meja ORDER BY id_meja");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Kelola Meja</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold text-amber-600 mb-4">🍽️ Kelola Meja</h2>

    <!-- Tambah Meja -->
    <form method="POST" class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-2">
      <input type="text" name="nomor_meja" placeholder="Nomor Meja" required class="border p-2 rounded">
     <select name="kapasitas" required class="border p-2 rounded">
      <option value="">-- Pilih Jumlah Kursi --</option>
      <option value="2">2 Kursi</option>
      <option value="4">4 Kursi</option>
      <option value="6">6 Kursi</option>
      <option value="8">8 Kursi</option>
     </select>

      <button type="submit" name="tambah" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Tambah</button>
    </form>
    <?php
        // Hitung jumlah total, tersedia, dan terisi
    $rekap = mysqli_fetch_assoc(mysqli_query($conn, "
         SELECT
         COUNT(*) AS total,
         SUM(status = 'tersedia') AS tersedia,
         SUM(status = 'terisi') AS terisi
         FROM meja
    "));
?>

<div class="bg-white p-4 rounded shadow mb-6">
  <h2 class="text-xl font-semibold text-amber-600 mb-3">📋 Rekap Status Meja</h2>
  <ul class="space-y-1 text-gray-700">
    <li>🪑 Total Meja: <strong><?= $rekap['total'] ?></strong></li>
    <li>✅ Meja Tersedia: <strong class="text-green-600"><?= $rekap['tersedia'] ?></strong></li>
    <li>❌ Meja Terisi: <strong class="text-red-600"><?= $rekap['terisi'] ?></strong></li>
  </ul>
</div>


    <!-- Daftar Meja -->
    <table class="w-full border text-center">
      <thead class="bg-gray-100">
         <tr>
          <th class="p-2 border">No</th>
         <th class="p-2 border">Nomor Meja</th>
          <th class="p-2 border">Kapasitas</th>
         <th class="p-2 border">Status</th>
         <th class="p-2 border">Aksi</th>
         </tr>
        </thead>

     
    <tbody>
  <?php while ($row = mysqli_fetch_assoc($meja)) : ?>
  <tr>
    <td class="border p-2"><?= $row['id_meja'] ?></td>
    <td class="border p-2"><?= $row['nomor_meja'] ?></td>
    <td class="border p-2"><?= $row['kapasitas'] ?> orang</td>
    <td class="border p-2"><?= ucfirst($row['status']) ?></td>
    <td class="border p-2">
      <form action="ubah_status_meja.php" method="POST">
        <input type="hidden" name="id_meja" value="<?= $row['id_meja'] ?>">
        <?php if ($row['status'] === 'tersedia') : ?>
          <button type="submit" name="status" value="terisi" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Tandai Terisi</button>
        <?php else : ?>
          <button type="submit" name="status" value="tersedia" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">Tandai Tersedia</button>
        <?php endif; ?>
             </form>
        </td>
 </tr>
  <?php endwhile; ?>
    </tbody>

    </table>
        <?php
        $kapasitas_total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(kapasitas) AS total_kapasitas FROM meja"));
        ?>
        <p class="mt-4 text-sm text-gray-600">🧾 Total Kapasitas Semua Meja: <strong><?= $kapasitas_total['total_kapasitas'] ?> orang</strong></p>


    <div class="mt-4 text-center">
      <a href="dashboard_admin.php" class="px-2 py-1 rounded text-white bg-green-500">← Kembali ke Dashboard</a>
    </div>
  </div>
</body>
</html>
