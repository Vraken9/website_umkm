<?php
session_start();
include 'koneksi.php';
include 'auth_admin.php';

// Proses simpan produk
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = $_POST['nama'];
  $kategori = $_POST['kategori'];
  $harga = $_POST['harga'];
  $deskripsi = $_POST['deskripsi'];

  // Upload gambar
  $gambar = $_FILES['gambar']['name'];
  $tmp = $_FILES['gambar']['tmp_name'];
  $folder = "gambar/";
  $path = $folder . basename($gambar);

  if (move_uploaded_file($tmp, $path)) {
    mysqli_query($conn, "INSERT INTO produk (nama_produk, id_kategori, harga, deskripsi, gambar)
      VALUES ('$nama', '$kategori', '$harga', '$deskripsi', '$gambar')");
    header("Location: kelola_produk.php");
    exit;
  } else {
    $error = "Upload gambar gagal.";
  }
}

// Ambil kategori untuk dropdown
$kategori = mysqli_query($conn, "SELECT * FROM kategori");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Tambah Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-xl mx-auto bg-white shadow-md rounded p-6">
    <h1 class="text-2xl font-bold text-amber-600 mb-4">Tambah Produk</h1>

    <?php if (isset($error)) echo "<p class='text-red-500 mb-4'>$error</p>"; ?>

    <form method="POST" enctype="multipart/form-data">
      <label class="block mb-2">Nama Produk</label>
      <input type="text" name="nama" required class="w-full border p-2 rounded mb-4">

      <label class="block mb-2">Kategori</label>
      <select name="kategori" required class="w-full border p-2 rounded mb-4">
        <option value="">-- Pilih Kategori --</option>
        <?php while ($k = mysqli_fetch_assoc($kategori)) : ?>
          <option value="<?= $k['id_kategori'] ?>"><?= $k['nama_kategori'] ?></option>
        <?php endwhile; ?>
      </select>

      <label class="block mb-2">Harga</label>
      <input type="number" name="harga" required class="w-full border p-2 rounded mb-4">

      <label class="block mb-2">Deskripsi</label>
      <textarea name="deskripsi" class="w-full border p-2 rounded mb-4" rows="3"></textarea>

      <label class="block mb-2">Upload Gambar</label>
      <input type="file" name="gambar" accept="image/*" required class="mb-4">

      <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Simpan</button>
      <a href="dashboard_admin.php" class="ml-4 text-gray-600">← Kembali</a>
    </form>
  </div>
</body>
</html>
