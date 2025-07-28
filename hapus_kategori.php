<?php
session_start();
include 'koneksi.php';
include 'auth_admin.php'; 

$id = intval($_GET['id']);
mysqli_query($conn, "DELETE FROM kategori WHERE id_kategori = $id");

header("Location: kelola_kategori.php");
exit;
?>
