<?php
include('../koneksi.php');
include('navbar_admin.php');

// Query untuk mengambil data yang diminta dengan JOIN antara transaksi dan riwayat_transaksi
$sql = "SELECT t.id AS id_transaksi, t.id_produk, t.id_pengguna, t.total_harga, t.tanggal_transaksi,
               rt.id AS id_riwayat, rt.nama_pembeli, rt.email_pembeli, rt.alamat_pembeli, rt.no_hp_pembeli
        FROM transaksi t
        INNER JOIN riwayat_transaksi rt ON t.id = rt.transaksi_id";

$result = $koneksi->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Transaksi</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="banner">
  <div class="container-fluid mt-5 bg-white">
    <h2>Data Transaksi</h2>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID Transaksi</th>
            <th>ID Produk</th>
            <th>ID Pengguna</th>
            <th>Nama Pembeli</th>
            <th>Email Pembeli</th>
            <th>Alamat Pembeli</th>
            <th>No. HP Pembeli</th>
            <th>Total Harga</th>
            <th>Tanggal Transaksi</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>" . $row['id_transaksi'] . "</td>
                      <td>" . $row['id_produk'] . "</td>
                      <td>" . $row['id_pengguna'] . "</td>
                      <td>" . $row['nama_pembeli'] . "</td>
                      <td>" . $row['email_pembeli'] . "</td>
                      <td>" . $row['alamat_pembeli'] . "</td>
                      <td>" . $row['no_hp_pembeli'] . "</td>
                      <td>Rp " . number_format($row['total_harga'], 0, ',', '.') . "</td>
                      <td>" . $row['tanggal_transaksi'] . "</td>
                      <td>
                        <a href='detail_transaksi.php?id=" . $row['id_transaksi'] . "' class='btn btn-info btn-sm'>Detail</a>
                        <a href='hapus_transaksi.php?id=" . $row['id_transaksi'] . "' class='btn btn-danger btn-sm'>Hapus</a>
                      </td>
                    </tr>";
            }
          } else {
            echo "<tr><td colspan='10'>Tidak ada data transaksi yang ditemukan.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
