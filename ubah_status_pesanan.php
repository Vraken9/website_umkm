<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id_pesanan']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Inisialisasi query update
    $query = "UPDATE pesanan SET status_pesanan = '$status'";

    // Jika status diantar, pilih karyawan delivery secara bergiliran
    if ($status === 'diantar') {
        $result_karyawan = mysqli_query($conn, "
            SELECT id_karyawan FROM karyawan
            WHERE jabatan = 'delivery'
            ORDER BY id_karyawan ASC
        ");

        $karyawan_list = [];
        while ($row = mysqli_fetch_assoc($result_karyawan)) {
            $karyawan_list[] = $row['id_karyawan'];
        }

        if (count($karyawan_list) > 0) {
            $result_last = mysqli_query($conn, "
                SELECT id_karyawan_delivery FROM pesanan
                WHERE id_karyawan_delivery IS NOT NULL
                ORDER BY id_pesanan DESC LIMIT 1
            ");

            if ($last = mysqli_fetch_assoc($result_last)) {
                $last_id = $last['id_karyawan_delivery'];
                $last_index = array_search($last_id, $karyawan_list);
                $next_index = ($last_index !== false) ? ($last_index + 1) % count($karyawan_list) : 0;
            } else {
                $next_index = 0;
            }

            $selected_karyawan = $karyawan_list[$next_index];
            $query .= ", id_karyawan_delivery = $selected_karyawan";
        }
    }

    // Jika status selesai, maka update status meja menjadi tersedia
    if ($status === 'selesai') {
        $cek_meja = mysqli_query($conn, "SELECT id_meja FROM pesanan WHERE id_pesanan = $id");
        if ($meja = mysqli_fetch_assoc($cek_meja)) {
            $id_meja = $meja['id_meja'];
            if ($id_meja) {
                mysqli_query($conn, "UPDATE meja SET status = 'tersedia' WHERE id_meja = $id_meja");
            }
        }
    }

    // Eksekusi update pesanan
    $query .= " WHERE id_pesanan = $id";
    $update_result = mysqli_query($conn, $query);

    // Sinkronisasi ke tabel antrian
    if ($update_result) {
        $sync_antrian = mysqli_query($conn, "
            UPDATE antrian
            SET status_antrian = (
                CASE 
                    WHEN '$status' = 'diproses' THEN 'diproses'
                    WHEN '$status' = 'diantar' THEN 'dikirim'
                    WHEN '$status' = 'selesai' THEN 'selesai'
                    ELSE 'diproses'
                END
            )
            WHERE id_pesanan = $id
        ");

        if ($sync_antrian) {
            header("Location: dashboard_admin.php");
            exit;
        } else {
            echo "✅ Pesanan berhasil diupdate, tetapi gagal update antrian: " . mysqli_error($conn);
        }
    } else {
        echo "❌ Gagal mengubah status pesanan: " . mysqli_error($conn);
    }
}
?>
