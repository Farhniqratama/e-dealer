<?php
// Include file koneksi ke database dan navbar_admin.php
include('../koneksi.php');
include('navbar_admin.php');

// Query untuk mengambil data kategori
$sqlKategori = "SELECT * FROM kategori";
$resultKategori = $koneksi->query($sqlKategori);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Produk - Admin</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Include SweetAlert library -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</head>
<body class="banner">
  <div class="container mt-5">
    <h1>Tambah Produk</h1>
    <form method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="nama_produk">Nama Produk</label>
        <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
      </div>
      <div class="form-group">
        <label for="kategori">Kategori</label>
        <select class="form-control" id="kategori" name="kategori" required>
          <?php while ($row = $resultKategori->fetch_assoc()): ?>
            <option value="<?php echo $row['id']; ?>"><?php echo $row['nama_kategori']; ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="harga">Harga</label>
        <input type="number" class="form-control" id="harga" name="harga" required>
      </div>
      <div class="form-group">
        <label for="deskripsi">Deskripsi</label>
        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
      </div>
      <div class="form-group">
        <label for="gambar">Gambar Produk</label>
        <input type="file" class="form-control-file" id="gambar" name="gambar" required>
      </div>
      <button type="submit" class="btn btn-primary">Tambah Produk</button>
    </form>

    <?php
    // Proses form jika ada pengiriman data melalui POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Ambil data dari form
        $nama_produk = $_POST['nama_produk'];
        $kategori_id = $_POST['kategori'];
        $harga = $_POST['harga'];
        $deskripsi = $_POST['deskripsi'];

        // Upload gambar
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);

        // Query untuk menambahkan produk ke database
        $sql = "INSERT INTO produk (nama_produk, kategori_id, harga, deskripsi, gambar) 
                VALUES ('$nama_produk', '$kategori_id', '$harga', '$deskripsi', '$target_file')";

        if ($koneksi->query($sql) === TRUE) {
            // Jika query berhasil, tampilkan SweetAlert sukses
            echo '<script>
                    Swal.fire({
                      title: "Sukses!",
                      text: "Produk berhasil ditambahkan.",
                      icon: "success",
                      confirmButtonText: "OK"
                    }).then(function() {
                      window.location.href = "lihat_produk.php";
                    });
                  </script>';
        } else {
            // Jika query gagal, tampilkan SweetAlert error dengan pesan dari database
            echo '<script>
                    Swal.fire({
                      title: "Error!",
                      text: "Gagal menambahkan produk. ' . $koneksi->error . '",
                      icon: "error",
                      confirmButtonText: "OK"
                    }).then(function() {
                      window.location.href = "lihat_produk.php";
                    });
                  </script>';
        }
    }
    ?>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
