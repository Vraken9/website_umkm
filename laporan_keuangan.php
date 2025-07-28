<?php
session_start();
include 'koneksi.php';
include 'auth_admin.php'; 


// Fungsi: Ambil minggu ke-berapa dalam tahun
function mingguKe($tanggal) {
  $tgl = new DateTime($tanggal);
  return $tgl->format("W");
}

// Ambil semua pembayaran yang sudah lunas
$pendapatan_query = mysqli_query($conn, "
  SELECT 
    WEEK(tanggal, 1) AS minggu_ke,
    YEAR(tanggal) AS tahun,
    SUM(dp.subtotal) AS total_pendapatan
  FROM pesanan p
  JOIN detail_pesanan dp ON p.id_pesanan = dp.id_pesanan
  JOIN pembayaran pb ON pb.id_pesanan = p.id_pesanan
  WHERE pb.status_pembayaran = 'lunas'
  GROUP BY tahun, minggu_ke
  ORDER BY tahun DESC, minggu_ke DESC
");

// Ambil pengeluaran berdasarkan tanggal
$pengeluaran_query = mysqli_query($conn, "
  SELECT 
    WEEK(tanggal, 1) AS minggu_ke,
    YEAR(tanggal) AS tahun,
    SUM(nominal) AS total_pengeluaran
  FROM biaya
  GROUP BY tahun, minggu_ke
  ORDER BY tahun DESC, minggu_ke DESC
");

// Gabungkan hasil dalam array mingguan
$laporan = [];

while ($row = mysqli_fetch_assoc($pendapatan_query)) {
  $kunci = $row['tahun'] . '-W' . $row['minggu_ke'];
  $laporan[$kunci]['pendapatan'] = $row['total_pendapatan'];
  $laporan[$kunci]['minggu_ke'] = $row['minggu_ke'];
  $laporan[$kunci]['tahun'] = $row['tahun'];
}

while ($row = mysqli_fetch_assoc($pengeluaran_query)) {
  $kunci = $row['tahun'] . '-W' . $row['minggu_ke'];
  $laporan[$kunci]['pengeluaran'] = $row['total_pengeluaran'];
  $laporan[$kunci]['minggu_ke'] = $row['minggu_ke'];
  $laporan[$kunci]['tahun'] = $row['tahun'];
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Laporan Keuangan Mingguan</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-5xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold text-amber-600 mb-6 text-center">📊 Laporan Keuangan Mingguan</h1>

    <table class="w-full text-center text-sm border">
      <thead class="bg-gray-100">
        <tr>
          <th class="border p-2">Minggu</th>
          <th class="border p-2">Tahun</th>
          <th class="border p-2">Pendapatan</th>
          <th class="border p-2">Pengeluaran</th>
          <th class="border p-2">Laba Bersih</th>
        </tr>
      </thead>
      <tbody>
        <?php ksort($laporan); foreach ($laporan as $l) :
          $pendapatan = $l['pendapatan'] ?? 0;
          $pengeluaran = $l['pengeluaran'] ?? 0;
          $laba = $pendapatan - $pengeluaran;
        ?>
        <tr>
          <td class="border p-2">Minggu <?= $l['minggu_ke'] ?></td>
          <td class="border p-2"><?= $l['tahun'] ?></td>
          <td class="border p-2 text-green-600">Rp <?= number_format($pendapatan, 0, ',', '.') ?></td>
          <td class="border p-2 text-red-600">Rp <?= number_format($pengeluaran, 0, ',', '.') ?></td>
          <td class="border p-2 font-bold <?= $laba >= 0 ? 'text-green-700' : 'text-red-700' ?>">
            Rp <?= number_format($laba, 0, ',', '.') ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
            <div class="mt-6 text-center">
  <a href="export_laporan_exel.php" target="_blank" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded mr-3">⬇️ Export Excel</a>
  
</div>

    <div class="mt-6 text-center">
      <a href="dashboard_admin.php" class="px-2 py-1 rounded text-white bg-green-500">← Kembali ke Dashboard</a>
    </div>
  </div>
</body>
</html>
