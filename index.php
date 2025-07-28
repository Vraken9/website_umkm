<?php
include 'koneksi.php';

function tampilkan_bintang($conn, $id_produk) {
    $query = mysqli_query($conn, "
        SELECT AVG(r.rasa) as avg_rasa
        FROM Review r
        JOIN Detail_Pesanan dp ON r.id_pesanan = dp.id_pesanan
        WHERE dp.id_produk = $id_produk
    ");
    $result = mysqli_fetch_assoc($query);
    $avg = round($result['avg_rasa'], 1);

    if (!$avg) {
        return str_repeat('☆', 5) . " <span class='text-gray-500 text-xs'>(Belum ada review)</span>";
    }

    $stars = str_repeat('⭐', floor($avg)) . str_repeat('☆', 5 - floor($avg));
    return "$stars <span class='text-gray-500 text-xs'>($avg/5)</span>";
}

$kategori = $_GET['kategori'] ?? '';
$rating_min = floatval($_GET['rating'] ?? 0);

$query = mysqli_query($conn, "
    SELECT p.*, COALESCE(AVG(r.rasa), 0) as avg_rasa
    FROM Produk p
    LEFT JOIN Detail_Pesanan dp ON p.id_produk = dp.id_produk
    LEFT JOIN Review r ON dp.id_pesanan = r.id_pesanan
    " . ($kategori ? "WHERE p.id_kategori = (SELECT id_kategori FROM kategori WHERE nama_kategori = '$kategori')" : "") . "
    GROUP BY p.id_produk
    HAVING avg_rasa >= $rating_min
");

$review = mysqli_query($conn, "
    SELECT r.*, pg.nama FROM review r
    JOIN pesanan p ON p.id_pesanan = r.id_pesanan
    JOIN pelanggan pg ON pg.id_pelanggan = p.id_pelanggan
    ORDER BY r.id_review DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Warung UMKM Kita</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css"  rel="stylesheet">
  <script src="https://unpkg.com/scrollreveal"></script> 
  <style>
    html { scroll-behavior: smooth; }
    .parallax {
      background-image: url('gambar/saung.png');
      background-size: cover;
      background-attachment: fixed;
      background-position: center;
    }
    .hero-overlay {
      background: rgba(0, 0, 0, 0.4);
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

<!-- Parallax Hero -->
<section class="parallax text-white text-center py-32 px-6 relative overflow-hidden">
  <div class="hero-overlay absolute inset-0 z-0"></div>
  <div class="relative z-10 max-w-3xl mx-auto">
    <h1 class="text-5xl md:text-6xl font-bold mb-4 drop-shadow-lg">Selamat Datang di Saung Apung kita  </h1>
    <p class="text-xl text-white/90 mb-6">Makanan rumahan, harga bersahabat, dan pelayanan terbaik.</p>
  </div>
</section>

<!-- Menu Section -->
<section id="menu" class="p-6 md:p-12 bg-white">
  <h2 class="text-3xl font-semibold mb-8 text-center">Menu Makanan</h2>

  <!-- Filter -->
  <form method="GET" class="flex flex-wrap justify-center gap-4 mb-10">
    <select name="kategori" onchange="this.form.submit()" class="p-3 border rounded shadow-sm focus:ring-amber-300 focus:border-amber-500">
      <option value="">Semua Kategori</option>
      <?php
      $kategori_query = mysqli_query($conn, "SELECT nama_kategori FROM kategori");
      while ($kat = mysqli_fetch_assoc($kategori_query)) {
        echo "<option value='{$kat['nama_kategori']}' " . ($kategori == $kat['nama_kategori'] ? 'selected' : '') . ">{$kat['nama_kategori']}</option>";
      }
      ?>
    </select>

    <select name="rating" onchange="this.form.submit()" class="p-3 border rounded shadow-sm focus:ring-amber-300 focus:border-amber-500">
      <option value="0" <?= $rating_min == 0 ? 'selected' : '' ?>>Semua Rating</option>
      <?php for ($i = 1; $i <= 5; $i++) echo "<option value='$i' ".($rating_min == $i ? 'selected' : '').">$i ⭐</option>"; ?>
    </select>
  </form>

  <!-- Produk Grid -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    <?php while ($row = mysqli_fetch_assoc($query)) : ?>
      <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <img src="gambar/<?= $row['gambar'] ?>" class="w-full h-48 object-cover rounded-t" />
        <div class="p-5">
          <h3 class="text-xl font-bold"><?= $row['nama_produk'] ?></h3>
          <p class="text-sm text-gray-500 mb-2"><?= $row['deskripsi'] ?></p>
          <p class="text-lg font-semibold text-amber-600">Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
          <p class="text-sm mt-2"><?= tampilkan_bintang($conn, $row['id_produk']) ?></p>
          <a href="form-pesan.php?id_produk=<?= $row['id_produk'] ?>" class="block mt-4 bg-amber-400 text-black py-2 px-4 rounded hover:bg-yellow-100 transition text-center">Pesan</a>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</section>

<!-- Tentang Kami -->
<section class="py-16 px-6 text-center bg-gray-100" id="profil">
  <h2 class="text-3xl font-semibold mb-4">Tentang Kami</h2>
  <p class="max-w-2xl mx-auto text-gray-600">Kami adalah warung keluarga yang menyajikan makanan lokal khas rumahan, dengan bahan segar dan rasa yang autentik. Setiap hidangan dibuat dengan cinta dan dedikasi untuk memanjakan lidah Anda.</p>
</section>

<!-- Chef Kami -->
<section class="py-16 px-6 bg-amber-50 text-center">
  <h2 class="text-3xl font-semibold mb-4">👨‍🍳 Chef Kami</h2>
  <div class="max-w-xl mx-auto flex flex-col items-center">
    <img src="gambar/chef2.png" alt="Chef" class="rounded-full w-40 h-40 object-cover shadow-xl mb-4 border-4 border-amber-200"> 
    <p class="font-medium text-lg">Chef Andi Santoso</p>
    <p class="text-gray-600 mt-2">Ahli masakan nusantara dan cita rasa keluarga sejak 2010.</p>
   
  </div>
  
</section>

<!-- Review Pelanggan -->
<section class="py-16 px-6 bg-white text-center">
  <h2 class="text-3xl font-semibold mb-8">Apa Kata Pelanggan?</h2>
  <div class="flex flex-wrap justify-center gap-6">
    <?php while ($r = mysqli_fetch_assoc($review)) : ?>
      <div class="bg-gray-50 p-5 rounded-lg shadow-md w-full sm:w-72 transition hover:shadow-xl">
        <p class="italic text-gray-700">"<?= htmlspecialchars($r['komentar']) ?>"</p>
        <p class="mt-3 text-sm text-gray-600">⭐ <?= $r['rasa'] ?>/5 | 👤 <?= $r['nama'] ?></p>
      </div>
    <?php endwhile; ?>
  </div>
</section>

<!-- Footer -->
<footer class="bg-gray-800 text-white py-8 text-center mt-12">
  <p>&copy; 2025 Saung Apung Kita | WhatsApp: 089999999999</p>
  <p class="text-sm text-gray-400 mt-2">Jl. Kuliner No. 88, Banjarnegara</p>
</footer>

<!-- Scroll Reveal -->
<script>
  ScrollReveal().reveal('section', {
    distance: '60px',
    duration: 800,
    easing: 'ease-in-out',
    origin: 'bottom',
    interval: 100,
    reset: false
  });
</script>

</body>
</html>
