<?php
session_start();
include 'koneksi.php';
include 'auth_admin.php'; 

// Ambil data produk
$produk = mysqli_query($conn, "
  SELECT pr.*, kt.nama_kategori 
  FROM produk pr
  LEFT JOIN kategori kt ON pr.id_kategori = kt.id_kategori
  ORDER BY pr.id_produk DESC
");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Kelola Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-5xl mx-auto bg-white shadow-md rounded p-6">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold text-amber-600">Kelola Produk</h1>
      <a href="tambah_produk.php" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">+ Tambah Produk</a>
    </div>

    <table class="w-full text-sm border border-gray-300">
      <thead class="bg-gray-200 text-center">
        <tr>
          <th class="p-2 border">#</th>
          <th class="p-2 border">Nama</th>
          <th class="p-2 border">Kategori</th>
          <th class="p-2 border">Harga</th>
          <th class="p-2 border">Gambar</th>
          <th class="p-2 border">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($p = mysqli_fetch_assoc($produk)) : ?>
        <tr class="text-center border-t">
          <td class="p-2"><?= $p['id_produk'] ?></td>
          <td class="p-2"><?= $p['nama_produk'] ?></td>
          <td class="p-2"><?= $p['nama_kategori'] ?></td>
          <td class="p-2">Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
          <td class="p-2">
            <img src="gambar/<?= $p['gambar'] ?>" class="w-14 h-14 object-cover mx-auto rounded">
          </td>
          <td class="p-2">
            <a href="edit_produk.php?id=<?= $p['id_produk'] ?>" class="text-blue-500">Edit</a> |
            <a href="hapus_produk.php?id=<?= $p['id_produk'] ?>" onclick="return confirm('Yakin ingin menghapus?')" class="text-red-500">Hapus</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
