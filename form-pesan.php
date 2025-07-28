<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Form Pemesanan</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
    .produk-card:hover {
      transform: scale(1.02);
      transition: all 0.3s ease;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .btn-pesan:hover {
      transform: translateY(-2px);
      transition: 0.3s ease;
    }
  </style>
  <script>
    function toggleAlamat() {
      const metode = document.getElementById("metode").value;
      document.getElementById("alamatBox").style.display = (metode === "Diantar") ? "block" : "none";
      document.getElementById("mejaBox").style.display = (metode === "Makan di Tempat") ? "block" : "none";
      document.getElementById("noHpBox").style.display = (metode === "Diantar") ? "block" : "none";
      document.getElementById("no_hp").required = (metode === "Diantar");
    }

    window.onload = toggleAlamat;
  </script>
</head>
<body class="bg-gradient-to-b from-yellow-50 via-orange-50 to-amber-100 text-gray-800">
  <div class="max-w-6xl mx-auto p-8 bg-white mt-10 rounded-xl shadow-xl">
    <h1 class="text-3xl font-bold text-center mb-6 text-amber-600">📝 Form Pemesanan</h1>
    <form action="proses_pesanan.php" method="POST">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block font-semibold text-gray-700">Nama</label>
          <input type="text" name="nama" class="w-full border p-3 rounded focus:outline-none focus:ring-2 focus:ring-amber-400" required>
        </div>
        <div>
          <label class="block font-semibold text-gray-700">Umur</label>
          <input type="number" name="umur" class="w-full border p-3 rounded focus:outline-none focus:ring-2 focus:ring-amber-400" required>
        </div>
        <div id="noHpBox">
          <label class="block font-semibold text-gray-700">Nomor HP</label>
          <input type="text" name="no_hp" id="no_hp" class="w-full border p-3 rounded focus:outline-none focus:ring-2 focus:ring-amber-400">
        </div>
        <div>
          <label class="block font-semibold text-gray-700">Metode Makan</label>
          <select name="metode" id="metode" onchange="toggleAlamat()" class="w-full border p-3 rounded focus:outline-none focus:ring-2 focus:ring-amber-400">
            <option value="Makan di Tempat">Makan di Tempat</option>
            <option value="Diantar">Diantar</option>
          </select>
        </div>
        <div id="alamatBox" style="display:none;">
          <label class="block font-semibold text-gray-700">Alamat Pengiriman</label>
          <textarea name="alamat" rows="2" class="w-full border p-3 rounded focus:outline-none focus:ring-2 focus:ring-amber-400"></textarea>
        </div>
        <div id="mejaBox">
          <label class="block font-semibold text-gray-700">Pilih Meja</label>
          <select name="id_meja" class="w-full border p-3 rounded focus:outline-none focus:ring-2 focus:ring-amber-400">
            <option value="">-- Pilih Meja Tersedia --</option>
            <?php
            $meja = mysqli_query($conn, "SELECT * FROM meja WHERE status = 'tersedia'");
            while ($m = mysqli_fetch_assoc($meja)) {
              echo '<option value="' . $m['id_meja'] . '">Meja ' . $m['nomor_meja'] . ' (Kapasitas ' . $m['kapasitas'] . ')</option>';
            }
            ?>
          </select>
        </div>
      </div>

      <h2 class="text-2xl font-semibold text-amber-600 mt-10 mb-4 text-center">📦 Pilih Produk</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php
        $produk = mysqli_query($conn, "SELECT pr.*, kt.nama_kategori FROM produk pr JOIN kategori kt ON pr.id_kategori = kt.id_kategori");
        while ($p = mysqli_fetch_assoc($produk)) {
          echo '
          <div class="produk-card border border-amber-300 rounded-lg bg-yellow-50 p-3 text-center shadow-sm">
            <img src="gambar/' . htmlspecialchars($p['gambar']) . '" alt="' . htmlspecialchars($p['nama_produk']) . '" class="w-full h-32 object-cover rounded mb-2 shadow">
            <h3 class="text-lg font-semibold text-amber-700">' . htmlspecialchars($p['nama_produk']) . '</h3>
            <p class="text-sm text-gray-600">Kategori: <strong>' . $p['nama_kategori'] . '</strong></p>
            <p class="text-sm text-gray-700 mb-2">Rp ' . number_format($p['harga'], 0, ",", ".") . '</p>
            <input type="number" name="produk[' . $p['id_produk'] . ']" placeholder="Jumlah" min="0" class="w-full border p-2 rounded">
          </div>';
        }
        ?>
      </div>
      <div class="mt-6">
  <label class="block font-semibold text-gray-700">Catatan untuk Pesanan (Opsional)</label>
  <textarea name="catatan" rows="3" placeholder="Contoh: Mie ayam jangan terlalu pedas, tanpa sayur..." class="w-full border p-3 rounded focus:outline-none focus:ring-2 focus:ring-amber-400"></textarea>
</div>


      <div class="mt-10 text-center">
        <button type="submit" class="btn-pesan bg-amber-500 hover:bg-amber-600 text-black px-8 py-3 rounded text-lg font-semibold shadow-lg transition-all">
          🛒 Kirim Pesanan
        </button>
      </div>
    </form>
  </div>
</body>
</html>
