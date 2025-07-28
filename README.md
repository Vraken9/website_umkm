Website Pemesanan Mandiri UMKM

Platform website sederhana dan efisien untuk membantu pelaku UMKM dalam mengelola pemesanan, pembayaran, dan laporan keuangan **tanpa potongan dari pihak ketiga seperti GoFood/GrabFood/ShopeeFood**.


Latar Belakang Masalah

UMKM di Indonesia memegang peranan besar dalam ekonomi nasional, namun seringkali terjebak dalam ketergantungan terhadap platform food delivery besar yang memotong 20–30% per transaksi. Hal ini menurunkan margin keuntungan dan mengurangi kemandirian usaha kecil.

Proyek ini bertujuan membangun sistem pemesanan mandiri yang dapat digunakan langsung oleh UMKM melalui website.

🌟 Fitur Unggulan

✅ Website mandiri tanpa potongan komisi  
✅ Pemesanan online: makan di tempat / diantar  
✅ Dukungan pembayaran: tunai, transfer, QRIS, e-wallet, hingga crypto  
✅ Upload bukti pembayaran & verifikasi admin  
✅ Sistem antrian real-time  
✅ Dashboard admin lengkap: laporan, manajemen menu, data pelanggan, dll  
✅ Review pelanggan & evaluasi pelayanan  
✅ Laporan keuangan & pengeluaran usaha


👥 Pengguna Sistem (Aktor)

- **Pelanggan**: Melihat menu, melakukan pemesanan, memilih metode bayar, memberikan ulasan.
- **Admin / Pemilik Toko**: Mengelola menu, pesanan, konfirmasi pembayaran, laporan.
- **Karyawan (Delivery)**: Mengantar pesanan sesuai antrian sistematis.


🔧 Teknologi

- `PHP`
- `MySQL`
- `HTML/CSS (Tailwind)`
- `XAMPP` (untuk local development)


🧠 Struktur Basis Data

Sistem terdiri dari 12 tabel utama:

- `admin`, `pelanggan`, `produk`, `kategori`, `meja`, `pesanan`
- `detail_pesanan`, `pembayaran`, `review`, `karyawan`, `biaya`, `antrian`

Basis data sudah dinormalisasi hingga **3NF (Third Normal Form)**.

📁 Cara Menjalankan Proyek

1. Install [XAMPP](https://www.apachefriends.org/index.html) dan aktifkan `Apache` & `MySQL`.
2. Clone atau download repositori ini ke folder `htdocs/`.
3. Import file `website_umkm.sql` ke `phpMyAdmin`.
4. Jalankan di browser dengan alamat:  
   `http://localhost/website_umkm/`
   dan masuk sebagai admin dengan alamat :
   `http://localhost/website_umkm/login_admin.php`
   dengan memasukan username : admin123
   dan password              : admin123


