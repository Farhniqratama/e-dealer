<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: ../login.php");
    exit();
}

include('../koneksi.php');

// Ambil data transaksi dari session
if (isset($_SESSION['transaksi_data'])) {
    $transaksi_data = $_SESSION['transaksi_data'];
    unset($_SESSION['transaksi_data']); // Hapus data transaksi dari session setelah digunakan
} else {
    // Jika data transaksi tidak ada, kembali ke halaman sebelumnya atau halaman utama
    header("Location: index.php");
    exit();
}

// Simpan data transaksi ke tabel transaksi
$id_pengguna = $_SESSION['user_id'];
$id_produk = $transaksi_data['id_produk'];
$nama = $transaksi_data['nama'];
$email = $transaksi_data['email'];
$alamat = $transaksi_data['alamat'];
$no_hp = $transaksi_data['no_hp'];
$jumlah = $transaksi_data['jumlah'];
$total_harga = floatval(str_replace(',', '', $transaksi_data['total_harga'])); // Ubah ke float, hilangkan tanda koma

$sql_transaksi = "INSERT INTO transaksi (id_pengguna, id_produk, jumlah, total_harga, tanggal_transaksi) 
                  VALUES (?, ?, ?, ?, NOW())";
$stmt_transaksi = $koneksi->prepare($sql_transaksi);
$stmt_transaksi->bind_param("iiid", $id_pengguna, $id_produk, $jumlah, $total_harga);

if ($stmt_transaksi->execute()) {
    // Simpan data ke tabel riwayat_transaksi
    $transaksi_id = $stmt_transaksi->insert_id; // Ambil ID transaksi yang baru saja dimasukkan
    $sql_riwayat = "INSERT INTO riwayat_transaksi (transaksi_id, nama_pembeli, email_pembeli, alamat_pembeli, no_hp_pembeli)
                    VALUES (?, ?, ?, ?, ?)";
    $stmt_riwayat = $koneksi->prepare($sql_riwayat);
    $stmt_riwayat->bind_param("issss", $transaksi_id, $nama, $email, $alamat, $no_hp);

    if ($stmt_riwayat->execute()) {
        // Tampilkan pesan sukses dengan modal
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Checkout Sukses - Dealer Online</title>
            <link rel="stylesheet" href="../css/style.css">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <style>
                body {
                    background-color: #f8f9fa;
                    font-family: Arial, sans-serif;
                }
                .container {
                    max-width: 800px;
                    margin: auto;
                    padding: 20px;
                    background-color: #fff;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    border-radius: 8px;
                }
                .modal-title {
                    color: #007bff;
                    font-size: 24px;
                    font-weight: bold;
                }
                .modal-content {
                    padding: 20px;
                    border-radius: 12px;
                }
                .detail-list {
                    list-style: none;
                    padding-left: 0;
                }
                .detail-list li {
                    margin-bottom: 10px;
                }
                .btn-primary {
                    background-color: #007bff;
                    border: none;
                    padding: 10px 20px;
                    border-radius: 5px;
                    color: #fff;
                    font-weight: bold;
                    transition: background-color 0.3s ease;
                }
                .btn-primary:hover {
                    background-color: #0056b3;
                }
            </style>
        </head>
        <body>

        <div class="container mt-5">
            <div class="modal-content">
                <h5 class="modal-title text-center mb-4">Checkout Sukses!</h5>
                <p class="text-center">Terima kasih, transaksi Anda telah berhasil.</p>
                <hr>
                <ul class="detail-list">
                    <li><strong>Nama:</strong> <?php echo htmlspecialchars($nama); ?></li>
                    <li><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></li>
                    <li><strong>Alamat:</strong> <?php echo htmlspecialchars($alamat); ?></li>
                    <li><strong>No HP:</strong> <?php echo htmlspecialchars($no_hp); ?></li>
                    <li><strong>Jumlah:</strong> <?php echo htmlspecialchars($jumlah); ?></li>
                    <li><strong>Total Harga:</strong> Rp <?php echo number_format($total_harga, 0, ',', '.'); ?></li>
                </ul>
                <hr>
                <div class="text-center">
                    <a href="../pengguna/index.php" class="btn btn-primary">Kembali ke Halaman Utama</a>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        </body>
        </html>

        <?php
    } else {
        echo "Terjadi kesalahan saat menyimpan riwayat transaksi: " . $koneksi->error;
    }
} else {
    echo "Terjadi kesalahan saat menyimpan transaksi: " . $koneksi->error;
}

$stmt_transaksi->close();
$stmt_riwayat->close();
?>
    