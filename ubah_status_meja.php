<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_meja = intval($_POST['id_meja']);
  $status = $_POST['status'] === 'terisi' ? 'terisi' : 'tersedia';

  mysqli_query($conn, "UPDATE meja SET status = '$status' WHERE id_meja = $id_meja");
}

header('Location: kelola_meja.php');
exit;
?>
