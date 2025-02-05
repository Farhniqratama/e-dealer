<?php
include('../koneksi.php');
include('navbar_user.php');

if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];
    $sql = "SELECT * FROM produk WHERE id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id_produk);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row_produk = $result->fetch_assoc();
        $nama_produk = $row_produk['nama_produk'];
        $gambar = $row_produk['gambar'];
        $harga = $row_produk['harga'];
        $deskripsi = $row_produk['deskripsi'];
    } else {
        echo "Produk tidak ditemukan.";
        exit();
    }
} else {
    echo "ID Produk tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - <?php echo $nama_produk; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="banner">
    <div class="container mt-5 ">
        <h1><?php echo $nama_produk; ?></h1>
        <div class="row mt-4">
            <div class="col-md-4">
                <img src="../uploads/<?php echo $gambar; ?>" class="img-fluid" alt="Gambar Produk">
            </div>
            <div class="col-md-8">
                <h2>Harga: Rp <?php echo number_format($harga, 0, ',', '.'); ?></h2>
                <p><?php echo $deskripsi; ?></p>
                <a href="transaksi_form.php?id=<?php echo $id_produk; ?>" class="btn btn-primary">Beli Sekarang</a>
            </div>
        </div>
    </div>

    <?php include('../footer.php'); ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
