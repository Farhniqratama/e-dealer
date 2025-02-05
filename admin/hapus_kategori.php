<?php
include('../koneksi.php');

if (isset($_GET['id'])) {
    $id_kategori = $_GET['id'];
    // Query untuk menghapus kategori dari database
    $sql = "DELETE FROM kategori WHERE id = $id_kategori";

    if ($koneksi->query($sql) === TRUE) {
        echo '<script>
                alert("Kategori berhasil dihapus.");
                window.location.href = "tambah_kategori.php";
              </script>';
    } else {
        echo '<script>
                alert("Error: ' . $sql . '\\n' . $koneksi->error . '");
                window.location.href = "tambah_kategori.php";
              </script>';
    }
} else {
    echo "ID kategori tidak diberikan.";
    exit;
}
?>
