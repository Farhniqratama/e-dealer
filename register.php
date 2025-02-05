<?php
include('koneksi.php');

// Inisialisasi variabel untuk pesan
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $role = 'user'; // Set default role sebagai user

    // Query untuk menyimpan data pengguna baru ke database menggunakan prepared statement
    $stmt = $koneksi->prepare("INSERT INTO users (username, password, nama_lengkap, email, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $password, $nama_lengkap, $email, $role);

    if ($stmt->execute()) {
        $message = "Registrasi berhasil. Silakan login.";
    } else {
        $message = "Registrasi gagal. Error: " . $stmt->error;
    }

    $stmt->close(); // Hanya memanggil close() sekali di sini
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Dealer Online</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="banner">

  <div class="container mt">
    <h1>Register</h1>
    <form method="POST">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" autocomplete="off">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" autocomplete="off">
      </div>
      <div class="form-group">
        <label for="nama_lengkap">Nama Lengkap</label>
        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" autocomplete="off">
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" autocomplete="off">
      </div>
      <button type="submit" class="btn btn-primary">Register</button>
    </form>
    <p>Sudah punya akun? <a href="login.php">Login</a></p>
  </div>

  <!-- Modal untuk pesan hasil registrasi -->
  <div class="modal fade" id="registrationModal" tabindex="-1" role="dialog" aria-labelledby="registrationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="registrationModalLabel">Registrasi Pengguna</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p id="registrationMessage"><?php echo $message; ?></p>
        </div>
        <div class="modal-footer">
          <a class="btn btn-primary" href="login.php">Login</a>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    <?php if (!empty($message)): ?>
      $(document).ready(function() {
        $('#registrationModal').modal('show');
      });
    <?php endif; ?>
  </script>
</body>
</html>
