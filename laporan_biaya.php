<?php
session_start();
include 'koneksi.php';
include 'auth_admin.php'; 


$rentang = $_GET['rentang'] ?? 'mingguan';

if ($rentang == 'bulanan') {
  $grafik = mysqli_query($conn, "
    SELECT DATE_FORMAT(tanggal, '%Y-%m') AS periode, SUM(nominal) AS total
    FROM biaya
    GROUP BY DATE_FORMAT(tanggal, '%Y-%m')
    ORDER BY periode DESC
  ");
  $judul = "Pengeluaran Bulanan";
} elseif ($rentang == 'tahunan') {
  $grafik = mysqli_query($conn, "
    SELECT YEAR(tanggal) AS periode, SUM(nominal) AS total
    FROM biaya
    GROUP BY YEAR(tanggal)
    ORDER BY periode DESC
  ");
  $judul = "Pengeluaran Tahunan";
} else {
  // default: mingguan
  $grafik = mysqli_query($conn, "
    SELECT DATE(tanggal) AS periode, SUM(nominal) AS total
    FROM biaya
    WHERE tanggal >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    GROUP BY DATE(tanggal)
    ORDER BY periode DESC
  ");
  $judul = "Pengeluaran Mingguan";
}

$grafik_data = [];
while ($row = mysqli_fetch_assoc($grafik)) {
  $grafik_data[] = $row;
}

// Statistik ringkasan
$mingguan = mysqli_fetch_assoc(mysqli_query($conn, "
  SELECT SUM(nominal) as total FROM biaya
  WHERE tanggal >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
"));
$bulanan = mysqli_fetch_assoc(mysqli_query($conn, "
  SELECT SUM(nominal) as total FROM biaya
  WHERE MONTH(tanggal) = MONTH(CURDATE()) AND YEAR(tanggal) = YEAR(CURDATE())
"));
$tahunan = mysqli_fetch_assoc(mysqli_query($conn, "
  SELECT SUM(nominal) as total FROM biaya
  WHERE YEAR(tanggal) = YEAR(CURDATE())
"));

// Tabel lengkap
$semua_biaya = mysqli_query($conn, "SELECT * FROM biaya ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Laporan Biaya</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">

    <h2 class="text-2xl font-bold text-amber-600 mb-6">📊 Laporan Biaya Operasional</h2>

    <!-- Ringkasan Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6 text-center">
      <div class="bg-yellow-100 p-4 rounded shadow">
        <h3 class="text-lg font-semibold text-yellow-700">Total Mingguan</h3>
        <p class="text-xl font-bold text-yellow-800">Rp <?= number_format($mingguan['total'] ?? 0, 0, ',', '.') ?></p>
      </div>
      <div class="bg-blue-100 p-4 rounded shadow">
        <h3 class="text-lg font-semibold text-blue-700">Total Bulanan</h3>
        <p class="text-xl font-bold text-blue-800">Rp <?= number_format($bulanan['total'] ?? 0, 0, ',', '.') ?></p>
      </div>
      <div class="bg-green-100 p-4 rounded shadow">
        <h3 class="text-lg font-semibold text-green-700">Total Tahunan</h3>
        <p class="text-xl font-bold text-green-800">Rp <?= number_format($tahunan['total'] ?? 0, 0, ',', '.') ?></p>
      </div>
    </div>

    <!-- Filter Rentang Waktu -->
    <form method="GET" class="mb-6 text-center">
      <label class="mr-2 font-medium">Tampilkan Grafik:</label>
      <select name="rentang" onchange="this.form.submit()" class="p-2 border rounded">
        <option value="mingguan" <?= $rentang == 'mingguan' ? 'selected' : '' ?>>Mingguan</option>
        <option value="bulanan" <?= $rentang == 'bulanan' ? 'selected' : '' ?>>Bulanan</option>
        <option value="tahunan" <?= $rentang == 'tahunan' ? 'selected' : '' ?>>Tahunan</option>
      </select>
    </form>

    <!-- Grafik Biaya -->
    <div class="bg-white p-4 rounded shadow mb-6">
      <h3 class="text-lg font-semibold mb-2 text-center"><?= $judul ?></h3>
      <canvas id="grafikBiaya" height="100"></canvas>
    </div>

    <!-- Tabel Biaya -->
    <div class="overflow-x-auto">
      <table class="w-full table-auto border border-gray-300 text-sm">
        <thead class="bg-gray-200 text-gray-700">
          <tr>
            <th class="border px-4 py-2">Tanggal</th>
            <th class="border px-4 py-2">Kategori</th>
            <th class="border px-4 py-2">Deskripsi</th>
            <th class="border px-4 py-2">Nominal</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($b = mysqli_fetch_assoc($semua_biaya)) : ?>
          <tr class="hover:bg-gray-100">
            <td class="border px-4 py-2"><?= $b['tanggal'] ?></td>
            <td class="border px-4 py-2"><?= htmlspecialchars($b['kategori_biaya']) ?></td>
            <td class="border px-4 py-2"><?= htmlspecialchars($b['deskripsi']) ?></td>
            <td class="border px-4 py-2">Rp <?= number_format($b['nominal'], 0, ',', '.') ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <div class="mt-6 text-center">
      <a href="dashboard_admin.php" class="px-2 py-1 rounded text-white bg-green-500">← Kembali ke Dashboard</a>
    </div>

  </div>

  <!-- Grafik -->
  <script>
    const ctx = document.getElementById('grafikBiaya').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?= json_encode(array_column($grafik_data, 'periode')) ?>,
        datasets: [{
          label: 'Total Pengeluaran',
          data: <?= json_encode(array_map('intval', array_column($grafik_data, 'total'))) ?>,
          backgroundColor: 'rgba(255, 99, 132, 0.7)'
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: {
            ticks: {
              callback: function(value) {
                return 'Rp ' + value.toLocaleString('id-ID');
              }
            }
          }
        }
      }
    });
  </script>
</body>
</html>
