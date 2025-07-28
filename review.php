<?php
include 'koneksi.php';

$id_pesanan = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Cek apakah review sudah pernah diberikan
$cekReview = mysqli_query($conn, "SELECT * FROM review WHERE id_pesanan = $id_pesanan");
if (mysqli_num_rows($cekReview) > 0) {
  echo "<div class='min-h-screen flex flex-col items-center justify-center bg-green-50 text-green-700'>
          <h2 class='text-xl font-semibold mb-4'>Terima kasih, Anda sudah memberikan review.</h2>
          <a href='index.php' class='text-blue-600 hover:underline'>Kembali ke Beranda</a>
        </div>";
  exit;
}

// Cek validitas pesanan
$cek = mysqli_query($conn, "
  SELECT p.id_pesanan, pg.nama, p.tanggal, pb.status_pembayaran
  FROM pesanan p
  JOIN pelanggan pg ON p.id_pelanggan = pg.id_pelanggan
  LEFT JOIN pembayaran pb ON p.id_pesanan = pb.id_pesanan
  WHERE p.id_pesanan = $id_pesanan
");
$data = mysqli_fetch_assoc($cek);

if (!$data) {
  echo "<h2 class='text-center text-red-600 mt-10 text-xl'>❌ Pesanan tidak ditemukan</h2>";
  exit;
}

if ($data['status_pembayaran'] !== 'lunas') {
  echo "<h2 class='text-center text-red-600 mt-10 text-xl'>❌ Pembayaran belum dikonfirmasi</h2>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Review Pelanggan</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    .star {
      cursor: pointer;
      font-size: 1.5rem;
      transition: color 0.3s ease;
    }
    .star:hover,
    .star.selected {
      color: #fbbf24;
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex items-center justify-center">
  <div class="bg-white shadow-lg rounded-md p-8 max-w-xl w-full">
    <h1 class="text-2xl font-bold text-center text-amber-600 mb-4">Form Review</h1>
    <p class="text-center text-sm text-gray-600 mb-6">
      Untuk pesanan atas nama: <strong><?= htmlspecialchars($data['nama']) ?></strong>
    </p>

    <form action="submit_review.php" method="POST" class="space-y-6">
      <input type="hidden" name="id_pesanan" value="<?= $id_pesanan ?>">

      <!-- Rating Rasa -->
      <div>
        <label class="block font-medium mb-1"> Makanan</label>
        <div class="flex gap-2 text-xl" id="ratingRasa">
          <?php for ($i = 1; $i <= 5; $i++): ?>
            <span class="star" data-value="<?= $i ?>" data-type="rasa">&#9733;</span>
          <?php endfor; ?>
        </div>
        <input type="hidden" name="rasa" id="inputRasa" required>
      </div>

      <!-- Rating Pelayanan -->
      <div>
        <label class="block font-medium mb-1">Pelayanan</label>
        <div class="flex gap-2 text-xl" id="ratingPelayanan">
          <?php for ($i = 1; $i <= 5; $i++): ?>
            <span class="star" data-value="<?= $i ?>" data-type="pelayanan">&#9733;</span>
          <?php endfor; ?>
        </div>
        <input type="hidden" name="pelayanan" id="inputPelayanan" required>
      </div>

      <!-- Komentar -->
      <div>
        <label class="block font-medium mb-1">Komentar</label>
        <textarea name="komentar" rows="4" placeholder="Tulis komentar Anda di sini..." class="w-full p-3 border rounded bg-gray-50"></textarea>
      </div>

      <!-- Submit -->
      <button type="submit" class="w-full py-3 bg-yellow-100 hover:bg-yellow-200 text-black rounded font-semibold transition">
        Kirim Review
      </button>
    </form>
  </div>

  <script>
    const stars = document.querySelectorAll('.star');

    stars.forEach(star => {
      star.addEventListener('click', function () {
        const value = parseInt(this.dataset.value);
        const type = this.dataset.type;
        const container = this.parentElement;
        const input = document.getElementById('input' + type.charAt(0).toUpperCase() + type.slice(1));

        // Reset
        container.querySelectorAll('.star').forEach(s => s.classList.remove('selected'));
        
        // Highlight
        for (let i = 0; i < value; i++) {
          container.children[i].classList.add('selected');
        }

        input.value = value;
      });
    });
  </script>
</body>
</html>
