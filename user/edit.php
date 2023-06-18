<?php

require "../db.php";
session_start();
if (!isset($_SESSION['user'])) {
    echo "<script>alert('Mohon login terlebih dahulu')
  location.replace('../login.php')</script>";
}

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
    $role = $_POST['role'];
    $direktori = "berkas/";
    $photo = $_FILES['photo']['name'];
    move_uploaded_file($_FILES['photo']['tmp_name'],$direktori.$photo);

    $simpan = mysqli_query($conn, "UPDATE users SET
    first_name = '$fname',
    last_name = '$lname',
    email = '$email',
    password = '$password',
    gender = '$gender',
    photo = '$photo',
    role = '$role' WHERE id = '$id'");

    if ($simpan) {
        echo '<script>alert("Akun Berhasil Diperbarui");
    location.replace("index.php");</script>';
    } else {
        echo '<script>alert("Akun Gagal Diperbarui");
    location.replace("index.php");</script>';
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Users</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    <div class="container">
        <a href="index.php"><button class="btn btn-warning btn-lg text-white mt-4"><i class="bi bi-arrow-90deg-left"></i> Kembali</i></button></a>
    </div>

    <div class="container">
        <div class="row justify-content-center pt-3 mt-3">
            <div class="col-lg-10">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="fw-bold mb-4 text-center">Edit Users <i class="bi bi-person-plus-fill"></i></h3>
                        <hr>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-grup mb-3">
                                        <label class="form-label" for="">Nama Depan</label>
                                        <input type="text" required id="fname" name="fname" class="form-control" value="<?= $user['first_name'] ?>">
                                    </div>
                                    <div class="form-grup mb-3">
                                        <label class="form-label" for="">Nama Belakang</label>
                                        <input type="text" required id="lname" name="lname" class="form-control" value="<?= $user['last_name'] ?>">
                                    </div>
                                    <div class="form-grup mb-3">
                                        <label class="form-label" for="">Email</label>
                                        <input type="text" required id="email" name="email" class="form-control" value="<?= $user['email'] ?>">
                                    </div>
                                    <div class="form-grup mb-3">
                                        <label class="form-label" for="">Password</label>
                                        <input type="text" required id="password" name="password" class="form-control" value="<?= $user['password'] ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">

                                    <div class="form-grup mb-3">
                                        <label class="form-label" for="">Gender</label>
                                        <select class="form-select" name="gender" id="gender">
                                            <option value="1">Laki-laki</option>
                                            <option value="2">Perempuan</option>
                                        </select>
                                        <div class="form-grup mb-3">
                                            <label class="form-label" for="">Photo</label>
                                            <input type="file" required id="photo" name="photo" class="form-control" value="<?= $user['photo'] ?>">
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
                                </div>
                                <hr>
                                <div class="form-group text-end">
                                    <button class="btn btn-primary btn-lg w-100" type="submit" name="update">Perbarui <i class="bi bi-person-fill-check"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>