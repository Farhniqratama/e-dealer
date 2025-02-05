<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: ../login.php");
    exit();
}

include('../koneksi.php');

if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];
    $sql = "SELECT * FROM produk WHERE id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id_produk);
    $stmt->execute();
    $result = $stmt->get_result();
    $produk = $result->fetch_assoc();

    // Pastikan produk ditemukan
    if (!$produk) {
        echo "Produk tidak ditemukan.";
        exit();
    }

    $nama_produk = $produk['nama_produk'];
    $harga = $produk['harga'];
    $deskripsi = $produk['deskripsi'];
} else {
    echo "Produk tidak ditemukan.";
    exit();
}

// Memproses form jika ada data yang dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $jumlah = $_POST['jumlah'];
    $total_harga = $_POST['total_harga']; // Total harga sudah dihitung di sini

    // Simpan data transaksi sementara di session
    $_SESSION['transaksi_data'] = [
        'id_produk' => $id_produk,
        'nama' => $nama,
        'email' => $email,
        'alamat' => $alamat,
        'no_hp' => $no_hp,
        'jumlah' => $jumlah,
        'total_harga' => $total_harga
    ];

    // Redirect ke checkout_sukses.php setelah simpan data ke session
    header("Location: checkout_sukses.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Transaksi - Dealer Online</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="banner">

<div class="container mt-5">
    <h1>Form Transaksi</h1>
    <div class="row mt-4">
        <div class="col-md-4">
            <img src="../uploads/<?php echo $produk['gambar']; ?>" class="img-fluid" alt="Gambar Produk" style="max-width: 350px;">
        </div>
        <div class="col-md-8">
            <h2><?php echo $nama_produk; ?></h2>
            <h3>Harga: Rp <?php echo number_format($harga, 0, ',', '.'); ?></h3>
            <form method="POST">
                <input type="hidden" name="id_produk" value="<?php echo $id_produk; ?>">
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" class="form-control" id="nama" name="nama" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" autocomplete="off" required></textarea>
                </div>
                <div class="form-group">
                    <label for="no_hp">No. Handphone:</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="jumlah">Jumlah:</label>
                    <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" max="1" value="1" readonly>
                </div>
                <div class="form-group">
                    <label for="total_harga">Total Harga:</label>
                    <input type="text" class="form-control" id="total_harga" name="total_harga" value="<?php echo number_format($harga, 0, ',', '.'); ?>" readonly>
                </div>
                <button type="submit" class="btn btn-primary">Beli Sekarang</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
