<?php
include('../koneksi.php');
include('navbar_user.php');

// Pastikan ada pengguna yang login
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Mengambil data pengguna dan profil pengguna dari database
$sql_profile = "
    SELECT u.id AS user_id, u.username, u.password, u.nama_lengkap, u.email, up.nama, up.foto_ktp, up.foto_kk, up.alamat, up.no_hp
    FROM users u
    LEFT JOIN users_profile up ON u.id = up.user_id
    WHERE u.id = ?
";
$stmt_profile = $koneksi->prepare($sql_profile);
$stmt_profile->bind_param("i", $user_id);
$stmt_profile->execute();
$result_profile = $stmt_profile->get_result();

if ($result_profile->num_rows > 0) {
    $user_profile = $result_profile->fetch_assoc();
} else {
    echo "Data profil pengguna tidak ditemukan.";
    exit();
}

// Memproses data ketika form di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];

    // Memproses file upload untuk foto KTP dan foto KK
    $foto_ktp = $user_profile['foto_ktp'];
    $foto_kk = $user_profile['foto_kk'];

    if (!empty($_FILES['foto_ktp']['name'])) {
        $foto_ktp = basename($_FILES['foto_ktp']['name']);
        $target_ktp = "../uploads/" . $foto_ktp;
        move_uploaded_file($_FILES['foto_ktp']['tmp_name'], $target_ktp);
    }

    if (!empty($_FILES['foto_kk']['name'])) {
        $foto_kk = basename($_FILES['foto_kk']['name']);
        $target_kk = "../uploads/" . $foto_kk;
        move_uploaded_file($_FILES['foto_kk']['tmp_name'], $target_kk);
    }

    // Update tabel users
    $sql_update_users = "UPDATE users SET username=?, password=?, nama_lengkap=?, email=? WHERE id=?";
    $stmt_update_users = $koneksi->prepare($sql_update_users);
    $stmt_update_users->bind_param("ssssi", $username, $password, $nama_lengkap, $email, $user_id);
    $stmt_update_users->execute();

    // Update tabel users_profile
    $sql_update_profile = "UPDATE users_profile SET nama=?, foto_ktp=?, foto_kk=?, alamat=?, no_hp=? WHERE user_id=?";
    $stmt_update_profile = $koneksi->prepare($sql_update_profile);
    $stmt_update_profile->bind_param("sssssi", $nama, $foto_ktp, $foto_kk, $alamat, $no_hp, $user_id);
    $stmt_update_profile->execute();

    echo '<script>
            alert("Profil berhasil diperbarui!");
            window.location.href = "detail_profile.php";
          </script>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil Pengguna</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="banner">
    <div class="container mt-5">
        <h1>Edit Profil Pengguna</h1>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user_profile['username']); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" value="<?php echo htmlspecialchars($user_profile['password']); ?>" required>
            </div>
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?php echo htmlspecialchars($user_profile['nama_lengkap']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user_profile['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($user_profile['nama']); ?>" required>
            </div>
            <div class="form-group">
                <label for="foto_ktp">Foto KTP</label>
                <input type="file" class="form-control" id="foto_ktp" name="foto_ktp">
                <img src="../uploads/<?php echo htmlspecialchars($user_profile['foto_ktp']); ?>" alt="Foto KTP" width="100">
            </div>
            <div class="form-group">
                <label for="foto_kk">Foto KK</label>
                <input type="file" class="form-control" id="foto_kk" name="foto_kk">
                <img src="../uploads/<?php echo htmlspecialchars($user_profile['foto_kk']); ?>" alt="Foto KK" width="100">
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?php echo htmlspecialchars($user_profile['alamat']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="no_hp">No. HP</label>
                <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($user_profile['no_hp']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="detail_profile.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <?php include('../footer.php'); ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
