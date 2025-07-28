<?php
session_start();
include 'koneksi.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = $_POST['password'];

  // Ambil data admin berdasarkan username
  $result = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");

  if ($admin = mysqli_fetch_assoc($result)) {
    // Verifikasi password
    if (password_verify($password, $admin['password'])) {
      $_SESSION['admin'] = $admin['username'];
      $_SESSION['last_activity'] = time();

      header('Location: dashboard_admin.php'); // ✅ arahkan ke dashboard
      exit;
    } else {
      $error = "Password salah.";
    }
  } else {
    $error = "Username tidak ditemukan.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6 flex items-center justify-center h-screen">
  <form method="POST" class="bg-white p-6 rounded shadow w-96">
    <h2 class="text-2xl font-bold mb-4 text-center text-amber-600">Login Admin</h2>

    <?php if (!empty($error)) echo "<p class='text-red-500 mb-2 text-sm'>$error</p>"; ?>

    <label class="block mb-2">Username</label>
    <input type="text" name="username" required class="w-full border p-2 rounded mb-4">

    <label class="block mb-2">Password</label>
    <input type="password" name="password" required class="w-full border p-2 rounded mb-4">

    <button type="submit" class="bg-amber-500 w-full py-2 rounded text-black font-semibold hover:bg-amber-600">Login</button>
  </form>
</body>
</html>
