<?php
include('../koneksi.php');
include('navbar_admin.php');

// Inisialisasi variabel untuk menyimpan pesan hasil operasi
$message = '';

// Memproses form jika ada data yang dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nama_kategori = $_POST['nama_kategori'];

    // Query untuk menyimpan kategori baru ke dalam database
    $sql = "INSERT INTO kategori (nama_kategori) VALUES (?)";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("s", $nama_kategori);

    // Eksekusi query
    if ($stmt->execute()) {
        $message = "Kategori berhasil ditambahkan.";
    } else {
        $message = "Gagal menambahkan kategori: " . $stmt->error;
    }
}

// Query untuk mengambil semua kategori yang ada di database
$sql_kategori = "SELECT id, nama_kategori FROM kategori";
$result_kategori = $koneksi->query($sql_kategori);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kategori - Admin Panel</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="banner">
    <div class="container mt-5">
        <h1>Manajemen Kategori</h1>
        <!-- Form untuk menambahkan kategori baru -->
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="nama_kategori">Nama Kategori</label>
                <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>

        <!-- Menampilkan pesan hasil operasi -->
        <?php if (!empty($message)): ?>
            <div class="alert alert-success mt-3" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Daftar kategori yang sudah ada -->
        <h2 class="mt-5">Daftar Kategori</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_kategori->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nama_kategori']; ?></td>
                        <td>
                            <!-- Tombol Hapus dengan Modal Konfirmasi -->
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusModal<?php echo $row['id']; ?>">
                                Hapus
                            </button>

                            <!-- Modal Konfirmasi Hapus -->
                            <div class="modal fade" id="hapusModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="hapusModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="hapusModalLabel<?php echo $row['id']; ?>">Konfirmasi Hapus Kategori</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus kategori "<?php echo $row['nama_kategori']; ?>"?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <a href="hapus_kategori.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Hapus</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php include('../footer.php'); ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
