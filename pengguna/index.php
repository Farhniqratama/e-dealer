<?php
include('../koneksi.php');
include('navbar_user.php');

// Query untuk mengambil semua kategori dari database
$sqlKategori = "SELECT * FROM kategori";
$resultKategori = $koneksi->query($sqlKategori);

// Variabel untuk menampung kategori yang dipilih, defaultnya null
$kategori_id = null;

// Jika ada parameter kategori di URL, ambil nilainya
if (isset($_GET['kategori'])) {
    $kategori_id = $_GET['kategori'];
}

// Query untuk mengambil produk sesuai dengan kategori yang dipilih (jika ada)
if ($kategori_id !== null) {
    $sqlProduk = "SELECT * FROM produk WHERE kategori_id = $kategori_id";
} else {
    $sqlProduk = "SELECT * FROM produk";
}

$resultProduk = $koneksi->query($sqlProduk);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dealer Online - Produk</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="banner">
  <div class="container-fluid mt-5 text">
    <h1>Daftar Produk</h1>

    <!-- Filter Kategori -->
    <div class="row mt-4 ">
      <div class="col-md-3 mb-3">
        <h5>Pilih Kategori</h5>
        <ul class="list-group">
          <?php while ($row = $resultKategori->fetch_assoc()): ?>
            <li class="list-group-item ">
              <a class="no-decor" href="?kategori=<?php echo $row['id']; ?>"><?php echo $row['nama_kategori']; ?></a>
            </li>
          <?php endwhile; ?>
        </ul>
      </div>

      <!-- Daftar Produk -->
      <div class="col-md-9">
        <div class="row">
          <?php while ($row = $resultProduk->fetch_assoc()): ?>
            <div class="col-md-4 mb-4 ">
              <div class="card warna-text h-100">
                <img src="../uploads/<?php echo $row['gambar']; ?>" class="card-img-top" alt="...">
                <div class="card-body ">
                  <h5 class="card-title "><?php echo $row['nama_produk']; ?></h5>
                  <p class="card-text text-truncate"><?php echo $row['deskripsi']; ?></p>
                  <p class="card-text">Harga: Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
                  <a href="detail_produk.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Detail Produk</a>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      </div>
    </div>
  </div>

  

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
