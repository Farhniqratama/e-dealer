<?php
include('../koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    // Lakukan insert data produk ke database
    $sql_insert = "INSERT INTO produk (nama_produk, harga) VALUES ('$nama_produk', '$harga')";
    if ($koneksi->query($sql_insert) === TRUE) {
        echo "Produk berhasil ditambahkan.";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $koneksi->error;
    }
}
?>
