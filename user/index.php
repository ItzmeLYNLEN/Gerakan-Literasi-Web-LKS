<?php
include "../db.php";

session_start();
if (!isset($_SESSION['user'])) {
  echo "<script>alert('Mohon login terlebih dahulu')
  location.replace('../login.php')</script>";
}

$users = $conn->query("SELECT * FROM users");

if (isset($_POST['register'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $role = $_POST['role'];
    $direktori = "berkas/";
    $photo = $_FILES['photo']['name'];
    move_uploaded_file($_FILES['photo']['tmp_name'],$direktori.$photo);

    $simpan = $conn->query("INSERT INTO users VALUES(NULL,'$fname', '$lname', '$email', '$password','$gender', '$photo' ,'$role', NULL)");

    if ($simpan) {
        echo '<script>alert("Akun Berhasil Ditambahkan");
        location.replace("index.php");</script>';
    } else {
        echo '<script>alert("Akun Gagal Ditambah");
        location.replace("index.php");</script>';
    }
}
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $delete = $conn->query("DELETE FROM users WHERE id = '$id'");
        if ($delete) {
          echo '<script>alert("Akun Berhasil Dihapus");
          location.replace("index.php");</script>';
        }
      }

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Users</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/style.css">
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
          <a class="nav-link " href="../index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="index.php">User</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../category">Category</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../writter">Content</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Settings
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="../profile">Profile</a></li>
            <li><a class="dropdown-item" href="../logout.php">Log Out</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

    <div class="container">
        <div class="row justify-content-center pt-3 mt-3">
            <div class="col-lg-10">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="fw-bold mb-4 text-center">Add Users <i class="bi bi-person-plus-fill"></i></h3>
                        <hr>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-grup mb-3">
                                        <label class="form-label" for="">First Name</label>
                                        <input type="text" required id="fname" name="fname" class="form-control">
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
                                </div>
                                <div class="col-lg-6">
                                        <div class="form-grup mb-3">
                                        <label class="form-label" for="">Gender</label>
                                        <select class="form-select" name="gender" id="gender">
                                            <option value="1">Laki-laki</option>
                                            <option value="2">Perempuan</option>
                                        </select>
                                        </div>
                                        <div class="form-grup mb-3">
                                        <label class="form-label" for="">Photo</label>
                                        <input type="file" id="photo" required name="photo" class="form-control">
                                        </div>
                                        <div class="form-grup mb-3">
                                            <label class="form-label" for="">Role</label>
                                            <select class="form-select" name="role" id="role">
                                                <option value="writter">Writter</option>
                                                <option value="member">Member</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                        </div>
                                </div>
                                <hr>
                                <div class="form-group text-end">
                                <button class="btn btn-primary btn-lg w-100" type="submit" name="register">Add <i class="bi bi-person-fill-check"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-2">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-body">
                    <table class=" table table-hover">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Nama Depan</th>
                                <th>Nama Belakang</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Role</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($users as $user) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $user['first_name'] ?></td>
                                    <td><?= $user['last_name'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <td><?= $user['gender'] ?></td>
                                    <td><?= $user['role'] ?></td>
                                    <td><?= $user['created_at'] ?></td>
                                    <td class="text-center">
                                        <a href="edit.php?id=<?= $user['id'] ?>" class="btn btn-warning text-white btn-sm">Edit <i class="bi bi-pencil-fill"></i></a>
                                        <form action="" method="POST">
                                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                            <button type="submit" name="delete" class="btn btn-danger text-white btn-sm">Delete <i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>