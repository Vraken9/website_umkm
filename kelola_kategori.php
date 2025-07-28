<?php
session_start();
include 'koneksi.php';
include 'auth_admin.php'; 


// Tambah kategori
if (isset($_POST['tambah'])) {
  $nama = mysqli_real_escape_string($conn, $_POST['nama_kategori']);
  mysqli_query($conn, "INSERT INTO kategori (nama_kategori) VALUES ('$nama')");
  header("Location: kelola_kategori.php");
  exit;
}

// Edit kategori
if (isset($_POST['edit'])) {
  $id = intval($_POST['id_kategori']);
  $nama = mysqli_real_escape_string($conn, $_POST['nama_kategori']);
  mysqli_query($conn, "UPDATE kategori SET nama_kategori='$nama' WHERE id_kategori=$id");
  header("Location: kelola_kategori.php");
  exit;
}

// Ambil semua kategori
$kategori = mysqli_query($conn, "SELECT * FROM kategori ORDER BY id_kategori");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Kelola Kategori</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold text-amber-600 mb-4">🍽️ Kelola Kategori</h2>

    <!-- Form Tambah -->
    <form method="POST" class="mb-6 flex gap-2">
      <input type="text" name="nama_kategori" placeholder="Nama kategori baru" required class="border p-2 rounded w-full">
      <button type="submit" name="tambah" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Tambah</button>
    </form>

    <!-- Tabel Kategori -->
    <table class="w-full border text-center">
      <thead class="bg-gray-200">
        <tr>
          <th class="p-2 border">ID</th>
          <th class="p-2 border">Nama Kategori</th>
          <th class="p-2 border">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($kategori)) : ?>
        <tr>
          <td class="border p-2"><?= $row['id_kategori'] ?></td>
          <td class="border p-2">
            <form method="POST" class="flex justify-center items-center gap-2">
              <input type="hidden" name="id_kategori" value="<?= $row['id_kategori'] ?>">
              <input type="text" name="nama_kategori" value="<?= $row['nama_kategori'] ?>" class="border p-1 rounded w-48">
              <button type="submit" name="edit" class="text-blue-600 hover:underline text-sm">Simpan</button>
              <a href="hapus_kategori.php?id=<?= $row['id_kategori'] ?>" class="text-red-600 hover:underline text-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
            </form>
          </td>
          <td class="border p-2"></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

    <div class="mt-4 text-center">
      <a href="dashboard_admin.php" class="px-2 py-1 rounded text-white bg-green-500">← Kembali ke Dashboard</a>
    </div>
  </div>
</body>
</html>
