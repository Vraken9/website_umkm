<?php
include 'koneksi.php';

$id_pesanan = intval($_POST['id_pesanan']);
$metode = trim($_POST['metode'] ?? '');

// Validasi input dasar
if (!$id_pesanan || !$metode) {
    die("❌ Lengkapi data pembayaran dengan benar.");
}

$bukti = null;
$waktu = date('Y-m-d H:i:s');

if ($metode !== 'Cash') {
    // Validasi dan upload file bukti
    if (!isset($_FILES['bukti']) || $_FILES['bukti']['error'] !== 0) {
        die("❌ Bukti pembayaran tidak ditemukan atau terjadi kesalahan upload.");
    }

    $ext = pathinfo($_FILES['bukti']['name'], PATHINFO_EXTENSION);
    $nama_bukti = 'bukti_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
    $target = 'bukti/' . $nama_bukti;

    if (!move_uploaded_file($_FILES['bukti']['tmp_name'], $target)) {
        die("❌ Gagal menyimpan bukti pembayaran.");
    }

    $bukti = $nama_bukti;
}

// Cek apakah sudah ada data pembayaran untuk pesanan ini
$cek = mysqli_query($conn, "SELECT id_pembayaran FROM pembayaran WHERE id_pesanan = $id_pesanan");

if (mysqli_num_rows($cek)) {
    // Update jika sudah ada
    $query = "UPDATE pembayaran SET
                metode = '$metode',
                status_pembayaran = 'belum',
                status_konfirmasi = 'pending',
                waktu_bayar = '$waktu'";

    if ($bukti) {
        $query .= ", bukti = '$bukti'";
    }

    $query .= " WHERE id_pesanan = $id_pesanan";
} else {
    // Insert jika belum ada
    $query = "INSERT INTO pembayaran (id_pesanan, metode, status_pembayaran, waktu_bayar, bukti, status_konfirmasi)
              VALUES ($id_pesanan, '$metode', 'belum', '$waktu', " . ($bukti ? "'$bukti'" : "NULL") . ", 'pending')";
}

if (!mysqli_query($conn, $query)) {
    die("❌ Gagal menyimpan data pembayaran: " . mysqli_error($conn));
}

// Arahkan kembali ke halaman detail pesanan
header("Location: detail_pesanan.php?id=$id_pesanan");
exit;
?>
