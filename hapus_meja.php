<?php
session_start();
include 'koneksi.php';
include 'auth_admin.php'; 


$id = intval($_GET['id']);
mysqli_query($conn, "DELETE FROM meja WHERE id_meja = $id");

header("Location: kelola_meja.php");
exit;
?>
