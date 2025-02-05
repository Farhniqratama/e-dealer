<?php
include('../koneksi.php');
include('navbar_admin.php');

// Query untuk mengambil semua produk dari database
$sql = "SELECT * FROM produk";
$result = $koneksi->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Produk - Admin Panel</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="banner">
  <div class="container mt-5">
    <h1>Manajemen Produk</h1>
    <a href="tambah_produk.php" class="btn btn-primary mb-3">Tambah Produk Baru</a>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Nama Produk</th>
            <th scope="col">Harga</th>
            <th scope="col">Gambar</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo $row['id']; ?></td>
              <td><?php echo $row['nama_produk']; ?></td>
              <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
              <td><img src="../uploads/<?php echo $row['gambar']; ?>" class="img-thumbnail" width="100" height="100" alt="..."></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <?php include('../footer.php'); ?>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
