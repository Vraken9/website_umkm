<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = intval($_POST['id_pesanan']);
  $rasa = intval($_POST['rasa']);
  $pelayanan = intval($_POST['pelayanan']);
  $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);
  $tanggal = date('Y-m-d H:i:s');

  // Simpan review ke database
  $query = "INSERT INTO review (id_pesanan, rasa, pelayanan, komentar, tanggal_review)
            VALUES ($id, $rasa, $pelayanan, '$komentar', '$tanggal')";

  if (mysqli_query($conn, $query)) {
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
      <meta charset="UTF-8">
      <title>Terima Kasih atas Ulasan Anda</title>
      <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body class="bg-green-50 min-h-screen flex items-center justify-center text-gray-800">
      <div class="max-w-md w-full bg-white p-8 rounded shadow-lg text-center">
        <h1 class="text-3xl font-bold text-green-600 mb-4">Terima Kasih!</h1>
        <p class="text-lg">Kami sangat menghargai waktu dan perhatian Anda dalam memberikan ulasan.</p>
        <p class="mt-2 text-sm text-gray-600">Masukan Anda akan membantu kami untuk terus berkembang dan menyajikan yang terbaik.</p>

        <div class="mt-6">
          <a href="index.php" class="bg-green-400 hover:bg-amber-600 text-white font-semibold px-6 py-2 rounded transition duration-200">
            Kembali ke Beranda
          </a>
        </div>
      </div>
    </body>
    </html>
    <?php
  } else {
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
      <meta charset="UTF-8">
      <title>Gagal Menyimpan Review</title>
      <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body class="bg-red-50 min-h-screen flex items-center justify-center text-gray-800">
      <div class="max-w-md w-full bg-white p-8 rounded shadow-lg text-center">
        <h1 class="text-2xl font-bold text-red-600 mb-4">Oops! Terjadi Kesalahan</h1>
        <p class="text-sm text-gray-700">Review Anda belum berhasil disimpan. Silakan coba beberapa saat lagi.</p>
        <p class="mt-2 text-xs text-red-500"><?= mysqli_error($conn) ?></p>

        <div class="mt-6">
          <a href="javascript:history.back()" class="bg-gray-300 hover:bg-gray-400 text-black font-semibold px-6 py-2 rounded">
            Kembali
          </a>
        </div>
      </div>
    </body>
    </html>
    <?php
  }
}
?>
