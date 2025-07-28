<?php
session_start();
include 'koneksi.php';
include 'auth_admin.php'; 
?>



<!DOCTYPE html>
<html>
<head>
  <title>Dashboard Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <audio id="notifSound" src="notif.wav" preload="auto"></audio>
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">
  <!-- Sidebar -->
  <div class="w-64 bg-white shadow-md p-6">
    <h2 class="text-xl font-bold text-amber-600 mb-6">Admin Panel</h2>
    <ul class="space-y-3">
      <li><a href="dashboard_admin.php" class="block p-2 rounded bg-amber-100">📊 Dashboard</a></li>
      <li><a href="laporan_transaksi.php" class="block p-2 rounded hover:bg-gray-200">📄 Laporan Transaksi</a></li>
      <li><a href="laporan_keuangan.php" class="block p-2 rounded hover:bg-gray-200">💰 Laporan Keuangan</a></li>
      <li><a href="kelola_kategori.php" class="block p-2 rounded hover:bg-gray-200">🗂️ Kelola Kategori</a></li>
      <li><a href="kelola_meja.php" class="block p-2 rounded hover:bg-gray-200">🪑 Kelola Meja</a></li>
      <li><a href="kelola_produk.php" class="block p-2 rounded hover:bg-gray-200">🍽️ Kelola Produk</a></li>
      <li><a href="tambah_produk.php" class="block p-2 rounded hover:bg-gray-200">➕ Tambah Produk</a></li>
      <li><a href="review_pelanggan.php" class="block p-2 rounded hover:bg-gray-200">📝 Review Pelanggan</a></li>
      <li><a href="catat_biaya.php" class="block p-2 rounded hover:bg-gray-200">📝 Catat Pengeluaran</a></li>
      <li><a href="laporan_biaya.php" class="block p-2 rounded hover:bg-gray-200">📊 Laporan Pengeluaran</a></li>
      <li><a href="ubah_password.php" class="block p-2 rounded hover:bg-gray-200">🔒 Ubah Password</a></li>
      <li><a href="logout_admin.php" class="block p-2 rounded hover:bg-gray-200 text-red-600">🚪 Logout</a></li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="flex-1 p-8">
    <h1 class="text-3xl font-bold text-amber-600 mb-6">📊 Dashboard Pesanan</h1>

    <div class="overflow-x-auto mb-12">
      <table class="w-full bg-white rounded shadow overflow-hidden text-sm">
        <thead class="bg-gray-200 text-gray-700">
          <tr>
            <th class="p-3 border">ID</th>
            <th class="p-3 border">Nama</th>
            <th class="p-3 border">Tanggal</th>
            <th class="p-3 border">Metode Makan</th>
            <th class="p-3 border">Metode Bayar</th>
            <th class="p-3 border">Bukti</th>
            <th class="p-3 border">Status Bayar</th>
            <th class="p-3 border">Status Pesanan</th>
            <th class="p-3 border">Aksi</th>
            <th class="p-3 border">Total</th>
            <th class="p-3 border">Detail</th>
          </tr>
        </thead>
        <tbody id="tbody-pesanan">
          <!-- Data pesanan akan dimuat secara otomatis via fetch_pesanan.php -->
        </tbody>
      </table>
    </div>

    <!-- Modal Detail -->
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
      <div class="bg-white rounded-lg w-96 p-4 relative">
        <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-500">✕</button>
        <div id="modalContent">Loading…</div>
      </div>
    </div>

    <!-- Chart Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-center">📅 Pendapatan Mingguan</h2>
        <canvas id="grafikMingguan"></canvas>
      </div>
      <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-center">📆 Pendapatan Bulanan</h2>
        <canvas id="grafikBulanan"></canvas>
      </div>
    </div>
  </div>
</div>
<?php
$mingguan = mysqli_query($conn, "
  SELECT DATE(tanggal) AS hari, SUM(dp.subtotal) AS total
  FROM pesanan ps
  JOIN detail_pesanan dp ON ps.id_pesanan = dp.id_pesanan
  JOIN pembayaran pb ON ps.id_pesanan = pb.id_pesanan
  WHERE pb.status_pembayaran = 'lunas' AND tanggal >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
  GROUP BY DATE(tanggal)
  ORDER BY hari
");
$hari = []; $totalHari = [];
while ($row = mysqli_fetch_assoc($mingguan)) {
  $hari[] = $row['hari'];
  $totalHari[] = $row['total'];
}

// Data untuk grafik bulanan
$bulanan = mysqli_query($conn, "
  SELECT DATE_FORMAT(tanggal, '%M') AS bulan, SUM(dp.subtotal) AS total
  FROM pesanan ps
  JOIN detail_pesanan dp ON ps.id_pesanan = dp.id_pesanan
  JOIN pembayaran pb ON ps.id_pesanan = pb.id_pesanan
  WHERE pb.status_pembayaran = 'lunas'
  GROUP BY MONTH(tanggal)
  ORDER BY MONTH(tanggal)
");
$bulan = []; $totalBulan = [];
while ($row = mysqli_fetch_assoc($bulanan)) {
  $bulan[] = $row['bulan'];
  $totalBulan[] = $row['total'];
}
?>

<!-- JavaScript untuk Modal dan Auto Refresh -->
<script>
function showDetail(id) {
  const modal = document.getElementById('detailModal');
  const content = document.getElementById('modalContent');
  content.innerHTML = 'Loading…';
  modal.classList.remove('hidden');
  fetch('fetch_admin_detail.php?id=' + id)
    .then(r => r.text())
    .then(html => content.innerHTML = html)
    .catch(_ => content.innerHTML = 'Gagal memuat detail');
}

function closeModal() {
  document.getElementById('detailModal').classList.add('hidden');
}

function refreshPesanan() {
  fetch('fetch_pesanan.php')
    .then(response => response.text())
    .then(html => {
      document.getElementById('tbody-pesanan').innerHTML = html;
    });
}

// Refresh setiap 5 detik
window.onload = refreshPesanan;
setInterval(refreshPesanan, 5000);
</script>

<!-- Chart -->
<script>
const ctxM = document.getElementById('grafikMingguan').getContext('2d');
new Chart(ctxM, {
  type: 'bar',
  data: {
    labels: <?= json_encode($hari) ?>,
    datasets: [{
      label: 'Pendapatan',
      data: <?= json_encode($totalHari) ?>,
      backgroundColor: 'rgba(255, 165, 0, 0.7)'
    }]
  }
});

const ctxB = document.getElementById('grafikBulanan').getContext('2d');
new Chart(ctxB, {
  type: 'line',
  data: {
    labels: <?= json_encode($bulan) ?>,
    datasets: [{
      label: 'Pendapatan',
      data: <?= json_encode($totalBulan) ?>,
      borderColor: 'rgba(75, 192, 192, 1)',
      fill: false,
      tension: 0.3
    }]
  }
});
</script>

</body>
</html>
