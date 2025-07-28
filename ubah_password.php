<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['admin'])) {
  header('Location: login_admin.php');
  exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username_input = $_POST['username'];
  $password_lama = $_POST['password_lama'];
  $password_baru = $_POST['password_baru'];

  $username_session = $_SESSION['admin'];

  if ($username_input !== $username_session) {
    $error = "Username tidak cocok dengan akun login saat ini.";
  } else {
    $cek = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username_input'");
    $admin = mysqli_fetch_assoc($cek);

    if (password_verify($password_lama, $admin['password'])) {
      $hash = password_hash($password_baru, PASSWORD_DEFAULT);
      mysqli_query($conn, "UPDATE admin SET password = '$hash' WHERE username = '$username_input'");
      
      // ✅ Redirect ke dashboard setelah sukses
      header('Location: dashboard_admin.php?pesan=password_berhasil');
      exit;
    } else {
      $error = "Password lama salah.";
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Ubah Password Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4 text-amber-600">🔒 Ubah Password Admin</h2>

    <?php if ($error) echo "<p class='text-red-500 mb-3'>$error</p>"; ?>

    <form method="POST">
      <label class="block mb-1">Username</label>
      <input type="text" name="username" required class="w-full border p-2 rounded mb-4" placeholder="Ketik ulang username Anda">

      <label class="block mb-1">Password Lama</label>
      <input type="password" name="password_lama" required class="w-full border p-2 rounded mb-4" placeholder="Masukkan password lama">

      <label class="block mb-1">Password Baru</label>
      <input type="password" name="password_baru" required class="w-full border p-2 rounded mb-4" placeholder="Masukkan password baru">

      <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-balck font-semibold py-2 px-4 rounded w-full">Simpan Perubahan</button>
    </form>

    <div class="mt-4 text-center">
      <a href="dashboard_admin.php" class="text-blue-600 text-sm hover:underline">← Kembali ke Dashboard</a>
    </div>
  </div>
</body>
</html>
