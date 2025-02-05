<?php
include('../koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id_transaksi = $_GET['id'];

    // Hapus data transaksi berdasarkan ID
    $sql_delete_trans = "DELETE FROM transaksi WHERE id = ?";
    $stmt_delete_trans = $koneksi->prepare($sql_delete_trans);
    $stmt_delete_trans->bind_param("i", $id_transaksi);

    if ($stmt_delete_trans->execute()) {
        // Hapus juga riwayat transaksi yang terkait jika perlu
        $sql_delete_riwayat = "DELETE FROM riwayat_transaksi WHERE transaksi_id = ?";
        $stmt_delete_riwayat = $koneksi->prepare($sql_delete_riwayat);
        $stmt_delete_riwayat->bind_param("i", $id_transaksi);
        $stmt_delete_riwayat->execute();

        echo "<script>
                if (confirm('Transaksi berhasil dihapus.'))
                {
                    window.location.href = 'transaksi.php';
                } else {
                    window.location.href = 'transaksi.php';
                }
              </script>";
    } else {
        echo "Gagal menghapus transaksi: " . $koneksi->error;
    }
} else {
    echo "Akses tidak sah.";
}
?>
