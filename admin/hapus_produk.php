<?php
include('../koneksi.php');
include('navbar_admin.php');

if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];
    // Query untuk menghapus produk dari database
    $sql = "DELETE FROM produk WHERE id = $id_produk";
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Hapus Produk - Admin</title>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body class="banner">
        <div class="container mt-5">
            <h1>Hapus Produk</h1>
            <p>Apakah Anda yakin ingin menghapus produk ini?</p>
            <div>
                <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#hapusModal">Hapus</a>
                <a href="produk_manajemen.php" class="btn btn-secondary">Batal</a>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="hapusModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Hapus Produk</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin menghapus produk ini?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <a href="hapus_produk.php?id=<?php echo $id_produk; ?>" class="btn btn-danger">Hapus</a>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            // Check if the query was successful
            if ($koneksi->query($sql) === TRUE) {
                echo '<script>
                        alert("Produk berhasil dihapus.");
                        window.location.href = "lihat_produk.php";
                      </script>';
            } else {
                echo '<script>
                        alert("Error: ' . $sql . '\\n' . $koneksi->error . '");
                        window.location.href = "lihat_produk.php";
                      </script>';
            }
            ?>

        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>

<?php
} else {
    echo "ID produk tidak diberikan.";
    exit;
}
?>
