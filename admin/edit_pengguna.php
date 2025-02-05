<?php
include('../koneksi.php');
include('navbar_admin.php');

// Pastikan ada parameter ID pengguna yang diberikan melalui URL
if (isset($_GET['id'])) {
    $id_pengguna = $_GET['id'];

    // Query untuk mengambil data pengguna berdasarkan ID
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id_pengguna);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Memuat data dari database ke variabel
        $username = $row['username'];
        $nama_lengkap = $row['nama_lengkap'];
        $email = $row['email'];
        $role = $row['role']; // Jika Anda ingin mengedit role pengguna juga
        
        // Ketika formulir disubmit, proses update data pengguna
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username_baru = $_POST['username'];
            $nama_lengkap_baru = $_POST['nama_lengkap'];
            $email_baru = $_POST['email'];
            $role_baru = $_POST['role'];

            // Query untuk update data pengguna
            $update_sql = "UPDATE users SET username=?, nama_lengkap=?, email=?, role=? WHERE id=?";
            $stmt_update = $koneksi->prepare($update_sql);
            $stmt_update->bind_param("ssssi", $username_baru, $nama_lengkap_baru, $email_baru, $role_baru, $id_pengguna);

            if ($stmt_update->execute()) {
                echo '<script>
                        alert("Data pengguna berhasil diperbarui!");
                        window.location.href = "lihat_pengguna.php";
                      </script>';
                exit();
            } else {
                echo "Error updating record: " . $stmt_update->error;
            }

            if ($koneksi->query($sql) === TRUE) {
                // Jika query berhasil, tampilkan SweetAlert sukses
                echo '<script>
                        Swal.fire({
                          title: "Sukses!",
                          text: "Produk berhasil ditambahkan.",
                          icon: "success",
                          confirmButtonText: "OK"
                        }).then(function() {
                          window.location.href = "tambah_produk.php";
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
                          window.location.href = "tambah_produk.php";
                        });
                      </script>';
            }

        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="banner">
    <div class="container mt-5">
        <h1>Edit Pengguna</h1>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id_pengguna; ?>">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?php echo htmlspecialchars($nama_lengkap); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="admin" <?php if ($role == 'admin') echo 'selected'; ?>>Admin</option>
                    <option value="user" <?php if ($role == 'user') echo 'selected'; ?>>User</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="lihat_pengguna.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <?php include('../footer.php'); ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
    } else {
        echo "Pengguna tidak ditemukan.";
    }
} else {
    echo "ID pengguna tidak diberikan.";
}
?>
