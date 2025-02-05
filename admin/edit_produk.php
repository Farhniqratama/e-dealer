<?php
include('../koneksi.php');
include('navbar_admin.php');

// Cek apakah parameter ID produk ada di URL
if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];
    
    // Query untuk mengambil data produk berdasarkan id
    $sql = "SELECT * FROM produk WHERE id = $id_produk";
    $result = $koneksi->query($sql);
    
    // Jika data produk ditemukan
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Produk tidak ditemukan.";
        exit;
    }
} else {
    echo "ID produk tidak diberikan.";
    exit;
}

// Proses update produk jika ada POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    
    // Proses update foto produk jika ada file yang diunggah
    if ($_FILES['gambar']['size'] > 0) {
        $file_name = $_FILES['gambar']['name'];
        $file_tmp = $_FILES['gambar']['tmp_name'];
        $file_type = $_FILES['gambar']['type'];

        // Cek tipe file yang diunggah
        $allowed_types = array('image/jpeg', 'image/png');
        if (in_array($file_type, $allowed_types)) {
            // Direktori penyimpanan file gambar
            $uploads_dir = '../uploads/';
            $target_file = $uploads_dir . basename($file_name);

            // Pindahkan file yang diunggah ke direktori upload
            if (move_uploaded_file($file_tmp, $target_file)) {
                // Update data produk ke database termasuk gambar baru
                $sql_update = "UPDATE produk SET nama_produk = '$nama_produk', harga = '$harga', deskripsi = '$deskripsi', gambar = '$file_name' WHERE id = $id_produk";
                if ($koneksi->query($sql_update) === TRUE) {
                    echo "Produk berhasil diupdate.";
                    // Ambil data produk yang baru diupdate
                    $sql_refresh = "SELECT * FROM produk WHERE id = $id_produk";
                    $result_refresh = $koneksi->query($sql_refresh);
                    if ($result_refresh->num_rows > 0) {
                        $row = $result_refresh->fetch_assoc();
                    }
                } else {
                    echo "Error: " . $sql_update . "<br>" . $koneksi->error;
                }
            } else {
                echo "Terjadi kesalahan saat mengunggah file gambar.";
            }
        } else {
            echo "Tipe file yang diunggah harus JPEG atau PNG.";
        }
    } else {
        // Update data produk ke database tanpa mengubah gambar
        $sql_update = "UPDATE produk SET nama_produk = '$nama_produk', harga = '$harga', deskripsi = '$deskripsi' WHERE id = $id_produk";
        if ($koneksi->query($sql_update) === TRUE) {
            echo "Produk berhasil diupdate.";
            // Ambil data produk yang baru diupdate
            $sql_refresh = "SELECT * FROM produk WHERE id = $id_produk";
            $result_refresh = $koneksi->query($sql_refresh);
            if ($result_refresh->num_rows > 0) {
                $row = $result_refresh->fetch_assoc();
            }
        } else {
            echo "Error: " . $sql_update . "<br>" . $koneksi->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Produk - Admin Panel</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="banner">
  <div class="container mt-5">
    <h1>Edit Produk</h1>
    <form method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="nama_produk">Nama Produk</label>
        <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?php echo isset($row['nama_produk']) ? $row['nama_produk'] : ''; ?>" required>
      </div>
      <div class="form-group">
        <label for="deskripsi">Deskripsi</label>
        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"><?php echo isset($row['deskripsi']) ? $row['deskripsi'] : ''; ?></textarea>
      </div>
      <div class="form-group">
        <label for="harga">Harga</label>
        <input type="text" class="form-control" id="harga" name="harga" value="<?php echo isset($row['harga']) ? $row['harga'] : ''; ?>" required>
      </div>
      <div class="form-group">
        <label for="gambar">Gambar Produk</label>
        <input type="file" class="form-control-file" id="gambar" name="gambar">
      </div>
      <button type="submit" class="btn btn-primary">Update Produk</button>
    </form>
  </div>

  <?php include('../footer.php'); ?>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
