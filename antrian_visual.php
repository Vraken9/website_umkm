<?php
include 'koneksi.php';

// Ambil pesanan yang status_pembayaran = 'lunas' dan status_pesanan belum selesai
$antrian = mysqli_query($conn, "
  SELECT ps.id_pesanan, pg.nama, ps.status_pesanan, ps.tanggal
  FROM pesanan ps
  JOIN pelanggan pg ON ps.id_pelanggan = pg.id_pelanggan
  JOIN pembayaran pb ON ps.id_pesanan = pb.id_pesanan
  WHERE pb.status_pembayaran = 'lunas' AND ps.status_pesanan != 'selesai'
  ORDER BY ps.tanggal ASC
");

$total_antrian = mysqli_num_rows($antrian);

// Cek apakah ada pesanan baru (bandingkan dengan file count)
$file_counter = 'antrian_count.txt';
$sebelumnya = file_exists($file_counter) ? (int)file_get_contents($file_counter) : 0;
file_put_contents($file_counter, $total_antrian); // update terbaru

$ada_pesanan_baru = $total_antrian > $sebelumnya;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>📋 Antrian Pesanan</title>
  <meta http-equiv="refresh" content="5">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    @keyframes scroll {
      0% { transform: translateX(100%); }
      100% { transform: translateX(-100%); }
    }
    .marquee {
      white-space: nowrap;
      overflow: hidden;
      background: #fef9c3;
      color: #92400e;
      font-weight: bold;
    }
    .marquee span {
      display: inline-block;
      padding: 10px 0;
      
    }
  </style>
  
</head>
<body class="bg-white text-gray-800 font-sans">

  <?php if ($ada_pesanan_baru): ?>
    <audio autoplay>
      <source src="suara/notif.wav" type="audio/wav">
    </audio>
  <?php endif; ?>

  <div class="marquee text-center text-lg">
    <span> Antrian Pesanan Saung Apung Kita - Hanya menampilkan pesanan yang sudah dibayar </span>
  </div>

  <div class="p-6">
    <h1 class="text-3xl font-bold text-center mb-6 text-amber-600">📦 Antrian Pesanan (Lunas)</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
      <?php while ($row = mysqli_fetch_assoc($antrian)) : ?>
        <div class="bg-white border-l-4 <?= $row['status_pesanan'] === 'diproses' ? 'border-yellow-500' : 'border-blue-500' ?> rounded shadow p-5">
          <h2 class="text-xl font-bold mb-1"> # <?= $row['id_pesanan'] ?>  <?= htmlspecialchars($row['nama']) ?></h2>
          <p class="text-gray-500 text-sm mb-2">⏰ <?= date('H:i', strtotime($row['tanggal'])) ?></p>
          <span class="px-3 py-1 text-sm rounded-full 
            <?= $row['status_pesanan'] === 'diproses' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' ?>">
            <?= ucfirst($row['status_pesanan']) ?>
          </span>
        </div>
      <?php endwhile; ?>
    </div>

    <p class="mt-6 text-center text-sm text-gray-400"></p>
  </div>
</body>
</html>
