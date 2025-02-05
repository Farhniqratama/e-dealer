<?php
include('../koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_produk = $_POST['id_produk'];
    $id_pengguna = $_POST['id_pengguna'];
    $total_harga = $_POST['total_harga'];
    $status = $_POST['status'];

    // Lakukan insert data transaksi ke database
    $sql_insert = "INSERT INTO transaksi (id_produk, id_pengguna, total_harga, status) VALUES ('$id_produk', '$id_pengguna', '$total_harga', '$status')";
    if ($koneksi->query($sql_insert) === TRUE) {
        echo "Transaksi berhasil ditambahkan.";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $koneksi->error;
    }
}
?>

