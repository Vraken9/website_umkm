<?php
session_start();
include 'koneksi.php';
include 'auth_admin.php'; 


$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data produk
$produk = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = $id");
$data = mysqli_fetch_assoc($produk);

// Ambil kategori
$kategori = mysqli_query($conn, "SELECT * FROM kategori");

if (!$data) {
  echo "<p class='text-center text-red-500'>Produk tidak ditemukan.</p>";
  exit;
}

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = $_POST['nama'];
  $id_kategori = $_POST['kategori'];
  $harga = $_POST['harga'];
  $deskripsi = $_POST['deskripsi'];

  // Jika gambar baru diunggah
  if ($_FILES['gambar']['name']) {
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    move_uploaded_file($tmp, "gambar/$gambar");
  } else {
    $gambar = $data['gambar']; // gunakan gambar lama
  }

  mysqli_query($conn, "
    UPDATE produk SET 
      nama_produk = '$nama',
      id_kategori = '$id_kategori',
      harga = '$harga',
      deskripsi = '$deskripsi',
      gambar = '$gambar'
    WHERE id_produk = $id
  ");

  header("Location: kelola_produk.php");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-xl mx-auto bg-white shadow-md rounded p-6">
    <h1 class="text-2xl font-bold text-amber-600 mb-4">Edit Produk</h1>

    <form method="POST" enctype="multipart/form-data">
      <label class="block mb-2">Nama Produk</label>
      <input type="text" name="nama" value="<?= $data['nama_produk'] ?>" required class="w-full border p-2 rounded mb-4">

      <label class="block mb-2">Kategori</label>
      <select name="kategori" required class="w-full border p-2 rounded mb-4">
        <?php while ($k = mysqli_fetch_assoc($kategori)) : ?>
          <option value="<?= $k['id_kategori'] ?>" <?= $k['id_kategori'] == $data['id_kategori'] ? 'selected' : '' ?>>
            <?= $k['nama_kategori'] ?>
          </option>
        <?php endwhile; ?>
      </select>

      <label class="block mb-2">Harga</label>
      <input type="number" name="harga" value="<?= $data['harga'] ?>" required class="w-full border p-2 rounded mb-4">

      <label class="block mb-2">Deskripsi</label>
      <textarea name="deskripsi" class="w-full border p-2 rounded mb-4" rows="3"><?= $data['deskripsi'] ?></textarea>

      <label class="block mb-2">Gambar Saat Ini</label>
      <img src="gambar/<?= $data['gambar'] ?>" class="w-24 mb-4 rounded shadow">

      <label class="block mb-2">Ganti Gambar (Opsional)</label>
      <input type="file" name="gambar" class="mb-4">

      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan Perubahan</button>
      <a href="kelola_produk.php" class="ml-4 text-gray-600">← Kembali</a>
    </form>
  </div>
</body>
</html>
