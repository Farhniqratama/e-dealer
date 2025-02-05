<?php
include('../koneksi.php');
include('navbar_user.php');

$user_id = $_SESSION['user_id'];

// Query untuk mengambil data pengguna dan profil pengguna berdasarkan ID pengguna
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
    $error_message = "Data profil pengguna tidak ditemukan.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Profil Pengguna</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="banner">
    <div class="container mt-5">
        <h1>Detail Profil Pengguna</h1>

        <?php if (isset($user_profile)) { ?>
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Informasi Profil Pengguna</h5>
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>ID Pengguna</th>
                                <td><?php echo htmlspecialchars($user_profile['user_id']); ?></td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td><?php echo htmlspecialchars($user_profile['username']); ?></td>
                            </tr>
                            <tr>
                                <th>Password</th>
                                <td><?php echo htmlspecialchars($user_profile['password']); ?></td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td><?php echo htmlspecialchars($user_profile['nama_lengkap']); ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo htmlspecialchars($user_profile['email']); ?></td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td><?php echo htmlspecialchars($user_profile['nama']); ?></td>
                            </tr>
                            <tr>
                            <th>Foto KTP</th>
                                <?php if (!empty($user_profile['foto_ktp'])): ?>
                                    <td><img src="../uploads/<?php echo htmlspecialchars($user_profile['foto_ktp']); ?>" alt="Foto KTP" width="100"></td>
                                <?php else: ?>
                                    <td><em>Belum diisi</em></td>
                                <?php endif; ?>
                            </tr>
                            <tr>
                                <th>Foto KK</th>
                                <?php if (!empty($user_profile['foto_kk'])): ?>
                                    <td><img src="../uploads/<?php echo htmlspecialchars($user_profile['foto_kk']); ?>" alt="Foto KK" width="100"></td>
                                <?php else: ?>
                                    <td><em>Belum diisi</em></td>
                                <?php endif; ?>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td><?php echo htmlspecialchars($user_profile['alamat']); ?></td>
                            </tr>
                            <tr>
                                <th>No. HP</th>
                                <td><?php echo htmlspecialchars($user_profile['no_hp']); ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="edit_profile.php" class="btn btn-primary">Edit Profil</a>
                </div>
            </div>
        <?php } elseif (isset($error_message)) { ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php } ?>
    </div>

    <?php include('../footer.php'); ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
