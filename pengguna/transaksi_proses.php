<?php
session_start();

// Periksa apakah session 'id' dan 'role' sudah ada
if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit();
}

// Jika bukan user, redirect ke halaman yang sesuai
if ($_SESSION['role'] != 'user') {
    header("Location: ../login.php");
    exit();
}
include('../koneksi.php');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form transaksi
    $id_pengguna = $_SESSION['id_pengguna']; // Sesuaikan dengan cara Anda mendapatkan ID pengguna yang sedang login
    $id_produk = $_POST['id_produk'];
    $total_harga = $_POST['total_harga'];
    $status = 'Pending'; // Atur status transaksi sesuai kebutuhan

    // Lakukan insert data transaksi ke database
    $sql_insert = "INSERT INTO transaksi (id_produk, id_pengguna, total_harga, status) VALUES ('$id_produk', '$id_pengguna', '$total_harga', '$status')";
    if ($koneksi->query($sql_insert) === TRUE) {
        echo "Transaksi berhasil dilakukan.";
        // Anda bisa tambahkan redirect atau tindakan lanjutan setelah transaksi berhasil
    } else {
        echo "Error: " . $sql_insert . "<br>" . $koneksi->error;
    }
}
?>
