<?php
include 'koneksi.php';

// Ambil dan sanitasi input
$nama     = trim(strtolower($_POST['nama'] ?? ''));
$umur     = intval($_POST['umur'] ?? 0);
$metode   = $_POST['metode'] ?? '';
$alamat   = trim($_POST['alamat'] ?? '');
$no_hp    = isset($_POST['no_hp']) ? preg_replace('/\D/', '', $_POST['no_hp']) : '';
$catatan  = mysqli_real_escape_string($conn, $_POST['catatan'] ?? ''); // ✅ Tambahan
$tanggal  = date('Y-m-d H:i:s');
$produk   = $_POST['produk'] ?? [];
$id_meja  = $_POST['id_meja'] ?? null;

// Validasi
$butuh_no_hp = $metode === 'Diantar';
if (!$nama || !$umur || !$metode || empty($produk) || ($butuh_no_hp && !$no_hp)) {
    die("❌ Lengkapi semua data yang dibutuhkan.");
}

// Cek apakah pelanggan sudah ada
$where_pelanggan = "LOWER(nama) = '$nama'";
if ($no_hp !== '') {
    $where_pelanggan .= " AND REPLACE(no_hp, ' ', '') = '$no_hp'";
}
$cek = mysqli_query($conn, "SELECT id_pelanggan FROM pelanggan WHERE $where_pelanggan");
if (mysqli_num_rows($cek) > 0) {
    $pelanggan = mysqli_fetch_assoc($cek);
    $id_pelanggan = $pelanggan['id_pelanggan'];
} else {
    $insert_pelanggan = mysqli_query($conn, "
        INSERT INTO pelanggan (nama, umur, no_hp, alamat)
        VALUES ('$nama', $umur, '$no_hp', '$alamat')
    ");
    if (!$insert_pelanggan) {
        die("❌ Gagal menyimpan pelanggan: " . mysqli_error($conn));
    }
    $id_pelanggan = mysqli_insert_id($conn);
}

// Siapkan ID meja jika makan di tempat
$id_meja_value = ($metode === 'Makan di Tempat' && $id_meja) ? intval($id_meja) : 'NULL';

// Simpan ke tabel pesanan 
$insert_pesanan = mysqli_query($conn, "
    INSERT INTO pesanan (id_pelanggan, metode, catatan, tanggal, id_meja)
    VALUES ($id_pelanggan, '$metode', '$catatan', '$tanggal', $id_meja_value)
");
if (!$insert_pesanan) {
    die("❌ Gagal menyimpan pesanan: " . mysqli_error($conn));
}
$id_pesanan = mysqli_insert_id($conn);

// Tandai meja sebagai terisi
if ($metode === 'Makan di Tempat' && $id_meja) {
    mysqli_query($conn, "UPDATE meja SET status = 'terisi' WHERE id_meja = $id_meja");
}

// Simpan detail pesanan
foreach ($produk as $id_produk => $jumlah) {
    $id_produk = intval($id_produk);
    $jumlah = intval($jumlah);

    if ($jumlah > 0) {
        $harga_res = mysqli_query($conn, "SELECT harga FROM produk WHERE id_produk = $id_produk");
        if ($row = mysqli_fetch_assoc($harga_res)) {
            $harga = intval($row['harga']);
            $subtotal = $harga * $jumlah;

            $insert_detail = mysqli_query($conn, "
                INSERT INTO detail_pesanan (id_pesanan, id_produk, jumlah, harga_satuan, subtotal)
                VALUES ($id_pesanan, $id_produk, $jumlah, $harga, $subtotal)
            ");
            if (!$insert_detail) {
                die("❌ Gagal menyimpan detail pesanan: " . mysqli_error($conn));
            }
        }
    }
}

// Tambah ke antrian
$last_antrian = mysqli_query($conn, "SELECT MAX(posisi_antrian) AS max_pos FROM antrian");
$row_last = mysqli_fetch_assoc($last_antrian);
$posisi_baru = ($row_last && $row_last['max_pos']) ? $row_last['max_pos'] + 1 : 1;

$insert_antrian = mysqli_query($conn, "
    INSERT INTO antrian (id_pesanan, posisi_antrian, status_antrian)
    VALUES ($id_pesanan, $posisi_baru, 'antri')
");
if (!$insert_antrian) {
    die("❌ Gagal menyimpan antrian: " . mysqli_error($conn));
}

// Redirect
header("Location: detail_pesanan.php?id=$id_pesanan");
exit;
?>
