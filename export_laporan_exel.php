<?php
include 'koneksi.php';

// Header untuk mendownload file Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_keuangan_mingguan.xls");

// Ambil data pendapatan mingguan
$pendapatan_query = mysqli_query($conn, "
  SELECT 
    WEEK(p.tanggal, 1) AS minggu_ke,
    YEAR(p.tanggal) AS tahun,
    SUM(dp.subtotal) AS total_pendapatan
  FROM pesanan p
  JOIN detail_pesanan dp ON p.id_pesanan = dp.id_pesanan
  JOIN pembayaran pb ON p.id_pesanan = pb.id_pesanan
  WHERE pb.status_pembayaran = 'lunas'
  GROUP BY tahun, minggu_ke
");

// Ambil data pengeluaran mingguan
$pengeluaran_query = mysqli_query($conn, "
  SELECT 
    WEEK(tanggal, 1) AS minggu_ke,
    YEAR(tanggal) AS tahun,
    SUM(nominal) AS total_pengeluaran
  FROM biaya
  GROUP BY tahun, minggu_ke
");

// Gabungkan data ke array $laporan
$laporan = [];

while ($row = mysqli_fetch_assoc($pendapatan_query)) {
  $key = $row['tahun'] . '-W' . $row['minggu_ke'];
  $laporan[$key]['minggu_ke'] = $row['minggu_ke'];
  $laporan[$key]['tahun'] = $row['tahun'];
  $laporan[$key]['pendapatan'] = $row['total_pendapatan'];
}

while ($row = mysqli_fetch_assoc($pengeluaran_query)) {
  $key = $row['tahun'] . '-W' . $row['minggu_ke'];
  $laporan[$key]['minggu_ke'] = $row['minggu_ke'];
  $laporan[$key]['tahun'] = $row['tahun'];
  $laporan[$key]['pengeluaran'] = $row['total_pengeluaran'];
}

// Keluarkan sebagai tabel HTML (dibaca Excel sebagai spreadsheet)
echo "<table border='1'>";
echo "<tr style='background-color:#f2f2f2;'>
        <th>Minggu Ke</th>
        <th>Tahun</th>
        <th>Total Pendapatan</th>
        <th>Total Pengeluaran</th>
        <th>Laba Bersih</th>
      </tr>";

ksort($laporan);
foreach ($laporan as $item) {
  $minggu = htmlspecialchars($item['minggu_ke']);
  $tahun = htmlspecialchars($item['tahun']);
  $pendapatan = $item['pendapatan'] ?? 0;
  $pengeluaran = $item['pengeluaran'] ?? 0;
  $laba = $pendapatan - $pengeluaran;

  echo "<tr>
    <td>Minggu {$minggu}</td>
    <td>{$tahun}</td>
    <td>Rp " . number_format($pendapatan, 0, ',', '.') . "</td>
    <td>Rp " . number_format($pengeluaran, 0, ',', '.') . "</td>
    <td>Rp " . number_format($laba, 0, ',', '.') . "</td>
  </tr>";
}
echo "</table>";
?>
