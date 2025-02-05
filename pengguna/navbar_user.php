<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: ../login.php");
    exit();
}
?>


<!-- navbar_user.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Dealer Online</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Beranda</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="riwayat_transaksi.php">Riwayat Transaksi</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="detail_profile.php">Lihat Profil</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../login.php">Logout</a>
      </li>
    </ul>
  </div>
</nav>
