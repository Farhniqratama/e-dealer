<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="admin/index.php">Dealer Online Admin</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Dashboard</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="lihat_pengguna.php">Lihat Pengguna</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="produk_manajemen.php">Manajemen Produk</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="transaksi.php">Lihat Transaksi</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="lihat_produk.php">Lihat Produk</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="tambah_kategori.php">Tambah Kategori</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../login.php">Logout</a>
      </li>
    </ul>
  </div>
</nav>
