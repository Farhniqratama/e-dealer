<?php
include('../koneksi.php');
include('navbar_admin.php');

// Pastikan ada parameter ID transaksi yang diberikan melalui URL
if (isset($_GET['id'])) {
    $id_transaksi = $_GET['id'];

    // Query untuk mengambil informasi detail transaksi, pengguna, produk, kategori, dan riwayat transaksi
    $sql = "SELECT t.id AS id_transaksi, 
                   u.username AS username_pengguna, 
                   p.nama_produk, 
                   k.nama_kategori, 
                   t.jumlah, 
                   t.total_harga, 
                   t.tanggal_transaksi,
                   rt.nama_pembeli,
                   rt.email_pembeli,
                   rt.alamat_pembeli,
                   rt.no_hp_pembeli
            FROM transaksi t
            JOIN users u ON t.id_pengguna = u.id
            JOIN produk p ON t.id_produk = p.id
            JOIN kategori k ON p.kategori_id = k.id
            JOIN riwayat_transaksi rt ON t.id = rt.transaksi_id
            WHERE t.id = ?";
    
    // Persiapkan statement SQL
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id_transaksi);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi - Admin Panel</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="banner">
    <div class="container mt-5">
        <h1>Detail Transaksi</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Informasi Transaksi</h5>
                <table class="table">
                    <tbody>
                        <tr>
                            <th>ID Transaksi</th>
                            <td><?php echo $row['id_transaksi']; ?></td>
                        </tr>
                        <tr>
                            <th>Nama Pengguna</th>
                            <td><?php echo $row['username_pengguna']; ?></td>
                        </tr>
                        <tr>
                            <th>Nama Produk</th>
                            <td><?php echo $row['nama_produk']; ?></td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td><?php echo $row['nama_kategori']; ?></td>
                        </tr>
                        <tr>
                            <th>Jumlah</th>
                            <td><?php echo $row['jumlah']; ?></td>
                        </tr>
                        <tr>
                            <th>Total Harga</th>
                            <td>Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Transaksi</th>
                            <td><?php echo $row['tanggal_transaksi']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Informasi Pembeli</h5>
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Nama Pembeli</th>
                            <td><?php echo $row['nama_pembeli']; ?></td>
                        </tr>
                        <tr>
                            <th>Email Pembeli</th>
                            <td><?php echo $row['email_pembeli']; ?></td>
                        </tr>
                        <tr>
                            <th>Alamat Pembeli</th>
                            <td><?php echo $row['alamat_pembeli']; ?></td>
                        </tr>
                        <tr>
                            <th>No. HP Pembeli</th>
                            <td><?php echo $row['no_hp_pembeli']; ?></td>
                        </tr>
                    </tbody>
                </table>
                <a href="transaksi.php" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>

    <?php include('../footer.php'); ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
    } else {
        echo "Transaksi tidak ditemukan.";
    }
} else {
    echo "ID transaksi tidak diberikan.";
}
?>
