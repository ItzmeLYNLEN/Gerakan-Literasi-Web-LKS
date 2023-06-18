<?php
  include "db.php";

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
         location.replace("login.php");</script>';
    } else {
        echo '<script>alert("Akun Gagal Ditambah");
        location.replace("register.php");</script>';
    }
}
  ?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center pt-3 mt-3">
            <div class="col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="fw-bold mb-4 text-center"><i class="bi bi-lock"></i> Register</h3>
                        <hr>
                        <form action="" method="POST" enctype="multipart/form-data">
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
                                    <div class="form-grup mb-3">
                                        <label class="form-label" for="">Role</label>
                                        <select class="form-select" name="role" id="gender">
                                            <option value="writter">Writter</option>
                                            <option value="member">Member</option>
                                        </select>
                                    </div>
                                    <hr>
                                <div class="form-group text-end">
                                <button class="btn btn-primary btn-lg w-100" type="submit" name="register">Register <i class="bi bi-person-fill-check"></i></button>
                                <p class="text-center mt-2">Sudah Punya akun? <a class="fw-bold" href="login.php">Masuk</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>