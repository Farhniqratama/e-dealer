<?php
include('../koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id_pengguna = $_GET['id'];

    // Hapus data transaksi yang terkait dengan pengguna
    $sql_delete_transaksi = "DELETE FROM transaksi WHERE id_pengguna = ?";
    $stmt_delete_transaksi = $koneksi->prepare($sql_delete_transaksi);
    $stmt_delete_transaksi->bind_param("i", $id_pengguna);
    $stmt_delete_transaksi->execute();

    // Hapus data profile pengguna yang terkait dengan pengguna
    $sql_delete_profile = "DELETE FROM users_profile WHERE user_id = ?";
    $stmt_delete_profile = $koneksi->prepare($sql_delete_profile);
    $stmt_delete_profile->bind_param("i", $id_pengguna);
    $stmt_delete_profile->execute();

    // Hapus pengguna dari tabel users
    $sql_delete_user = "DELETE FROM users WHERE id = ?";
    $stmt_delete_user = $koneksi->prepare($sql_delete_user);
    $stmt_delete_user->bind_param("i", $id_pengguna);

    if ($stmt_delete_user->execute()) {
        echo '<script>
                alert("Pengguna berhasil dihapus.");
                window.location.href = "lihat_pengguna.php";
              </script>';
    } else {
        echo 'Gagal menghapus pengguna: ' . $koneksi->error;
    }
} else {
    echo 'Akses tidak sah.';
}
?>
