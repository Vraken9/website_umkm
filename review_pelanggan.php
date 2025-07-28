<?php
session_start();
include 'koneksi.php';
include 'auth_admin.php'; 


// Ambil semua review dan nama pelanggan + karyawan
$query = mysqli_query($conn, "
  SELECT r.*, p.nama AS nama_pelanggan, k.nama AS nama_karyawan
  FROM review r
  JOIN pesanan ps ON r.id_pesanan = ps.id_pesanan
  JOIN pelanggan p ON ps.id_pelanggan = p.id_pelanggan
  LEFT JOIN karyawan k ON ps.id_karyawan_delivery = k.id_karyawan
  ORDER BY r.tanggal_review DESC
");

// Ambil rata-rata rating rasa dan pelayanan per hari (untuk grafik harian)
$ratingHarian = mysqli_query($conn, "
  SELECT DATE(tanggal_review) AS hari,
         ROUND(AVG(rasa), 2) AS avg_rasa,
         ROUND(AVG(pelayanan), 2) AS avg_pelayanan
  FROM review
  WHERE tanggal_review >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
  GROUP BY DATE(tanggal_review)
  ORDER BY hari
");

$hari = $avgRasa = $avgPelayanan = [];
while ($row = mysqli_fetch_assoc($ratingHarian)) {
  $hari[] = $row['hari'];
  $avgRasa[] = $row['avg_rasa'];
  $avgPelayanan[] = $row['avg_pelayanan'];
}

// Ambil rata-rata rating per karyawan (untuk grafik indeks per karyawan)
$ratingKaryawan = mysqli_query($conn, "
  SELECT k.nama AS nama_karyawan,
         ROUND(AVG(r.rasa), 2) AS avg_rasa,
         ROUND(AVG(r.pelayanan), 2) AS avg_pelayanan
  FROM review r
  JOIN pesanan ps ON r.id_pesanan = ps.id_pesanan
  LEFT JOIN karyawan k ON ps.id_karyawan_delivery = k.id_karyawan
  WHERE k.nama IS NOT NULL
  GROUP BY k.nama
  ORDER BY k.nama
");

$namaKaryawan = $ratingGabungan = [];
while ($row = mysqli_fetch_assoc($ratingKaryawan)) {
  $namaKaryawan[] = $row['nama_karyawan'];
  // Skor gabungan rata-rata (rasa + pelayanan) / 2
  $ratingGabungan[] = round(($row['avg_rasa'] + $row['avg_pelayanan']) / 2, 2);
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Review Pelanggan</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50 p-8">

  <h1 class="text-3xl font-bold text-center text-amber-600 mb-8">⭐ Review Pelanggan</h1>

  <!-- Tabel Review -->
  <div class="overflow-x-auto mb-12">
    <table class="min-w-full bg-white rounded shadow text-sm text-center">
      <thead class="bg-amber-100 text-gray-700">
        <tr>
          <th class="py-3 px-4 border">No</th>
          <th class="py-3 px-4 border">Nama Pelanggan</th>
          <th class="py-3 px-4 border">Tanggal</th>
          <th class="py-3 px-4 border">Rating Rasa</th>
          <th class="py-3 px-4 border">Rating Pelayanan</th>
          <th class="py-3 px-4 border">Komentar</th>
          <th class="py-3 px-4 border">Karyawan Delivery</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; while ($row = mysqli_fetch_assoc($query)) : ?>
        <tr class="border-t">
          <td class="py-2 px-3"><?= $no++ ?></td>
          <td class="py-2 px-3"><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
          <td class="py-2 px-3"><?= $row['tanggal_review'] ?></td>
          <td class="py-2 px-3 text-yellow-600 font-bold"><?= str_repeat('⭐', $row['rasa']) ?></td>
          <td class="py-2 px-3 text-yellow-600 font-bold"><?= str_repeat('⭐', $row['pelayanan']) ?></td>
          <td class="py-2 px-3"><?= htmlspecialchars($row['komentar']) ?: '-' ?></td>
          <td class="py-2 px-3"><?= htmlspecialchars($row['nama_karyawan'] ?? '-') ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <!-- Grafik Rating Harian -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
    <div class="bg-white rounded p-6 shadow">
      <h2 class="text-lg font-semibold text-center mb-4">📅 Rata-rata Rating Harian</h2>
      <canvas id="grafikHarian"></canvas>
    </div>

    <!-- Grafik Indeks per Karyawan -->
    <div class="bg-white rounded p-6 shadow">
      <h2 class="text-lg font-semibold text-center mb-4">👨‍🍳 Indeks Kepuasan per Karyawan</h2>
      <canvas id="grafikKaryawan"></canvas>
    </div>
  </div>

<script>
  const ctxHarian = document.getElementById('grafikHarian').getContext('2d');
  new Chart(ctxHarian, {
    type: 'line',
    data: {
      labels: <?= json_encode($hari) ?>,
      datasets: [
        {
          label: 'Rasa',
          data: <?= json_encode($avgRasa) ?>,
          borderColor: 'orange',
          fill: false,
          tension: 0.3
        },
        {
          label: 'Pelayanan',
          data: <?= json_encode($avgPelayanan) ?>,
          borderColor: 'blue',
          fill: false,
          tension: 0.3
        }
      ]
    }
  });

  const ctxKaryawan = document.getElementById('grafikKaryawan').getContext('2d');
  new Chart(ctxKaryawan, {
    type: 'bar',
    data: {
      labels: <?= json_encode($namaKaryawan) ?>,
      datasets: [{
        label: 'Indeks Kepuasan (rasa + pelayanan)',
        data: <?= json_encode($ratingGabungan) ?>,
        backgroundColor: 'rgba(255, 206, 86, 0.7)'
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          max: 5
        }
      }
    }
  });
</script>

</body>
</html>
