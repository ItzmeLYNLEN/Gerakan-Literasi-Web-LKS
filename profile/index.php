<?php

include "../db.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user = $conn->query("SELECT * FROM users WHERE id = $id")->fetch_assoc();
}
if (isset($_POST['update'])) {
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $gender = $_POST['gender'];
  $direktori = "berkas/";
  $photo = $_FILES['photo']['name'];
  move_uploaded_file($_FILES['photo']['tmp_name'],$direktori.$photo);

  $simpan = mysqli_query($conn, "UPDATE users SET
  first_name = '$fname',
  last_name = '$lname',
  email = '$email',
  password = '$password',
  gender = '$gender',
  photo = '$photo' WHERE id = '$id'");

if ($simpan) {
  echo '<script>alert("Akun Berhasil Diperbarui");
location.replace("index.php");</script>';
} else {
  echo '<script>alert("Akun Gagal Diperbarui");
location.replace("index.php");</script>';
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <title>Profile</title>
</head>
<body>
    
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="../">Literasi</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav nav-underline">
        <li class="nav-item">
          <a class="nav-link " href="../">Home</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Settings
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="../logout.php">Log Out</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-7">
        <div class="card shadow-sm">
                    <div class="card-body">
                    <div class="row">
                                <div class="col-lg-3 text-center">
                                    <img src="../user/berkas/" class="img-fluid rounded-circle profile-image shadow">
                                </div>
                            </div>
                        <h3 class="fw-bold mb-4 text-center">Profile</h3>
                        <hr>
                        <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-grup mb-3">
                                        <label class="form-label" for="">First Name</label>
                                        <input type="text" required id="fname" name="fname" class="form-control" <?= $user['first_name'] ?>>
                                    </div>
                                    <div class="form-grup mb-3">
                                        <label class="form-label" for="">Last Name</label>
                                        <input type="text" required id="lname" name="lname" class="form-control">
                                    </div>
                                    <div class="form-grup mb-3">
                                        <label class="form-label" for="">Email</label>
                                        <input type="text" required id="email" name="email" class="form-control">
                                    </div>
                                    <div class="form-grup mb-3">
                                        <label class="form-label" for="">Password</label>
                                        <input type="text" required id="password" name="password" class="form-control">
                                    </div>
                                    <div class="form-grup mb-3">
                                        <label class="form-label" for="">Gender</label>
                                        <select class="form-select" name="gender" id="gender">
                                            <option value="1">Laki-laki</option>
                                            <option value="2">Perempuan</option>
                                        </select>
                                        <div class="form-grup mb-3">
                                        <label class="form-label" for="">Photo</label>
                                        <input type="file" id="photo" required name="photo" class="form-control">
                                        </div>
                                    <hr>
                                <div class="form-group text-end">
                                <button class="btn btn-primary btn-lg w-100" type="submit" name="update">Save</button>
                        </form>
                    </div>
                </div>
        </div>
    </div>
</div>

<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>