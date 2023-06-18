<?php

require "../db.php";
session_start();
if (!isset($_SESSION['user'])) {
  echo "<script>alert('Mohon login terlebih dahulu')
  location.replace('../login.php')</script>";
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $category = $conn->query("SELECT * FROM category WHERE id = $id")->fetch_assoc();
}
if(isset($_POST['update'])){
    $nama = $_POST['nama'];
    $slug = $_POST['slug'];

  $simpan = mysqli_query($conn, "UPDATE category SET name = '$nama', slug = '$slug' WHERE id = '$id'");
  if($simpan) {
    echo '<script>alert("Datanya Berhasil Diperbarui");
    location.replace("index.php");</script>';
  }else{
    echo '<script>alert("Data Gagal Diperbarui");
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Edit Category</title>
</head>
<body>
<div class="container">
    <a href="index.php"><button class="btn btn-warning btn-lg text-white mt-4"><i class="bi bi-arrow-90deg-left"></i> Kembali</i></button></a>
  </div>
  <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow mb-3">
                    <div class="card-header bg-dark">
                        <h3 class="mb-0 text-white">Tambah Category </h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-grup mb-3">
                                        <label class="form-label" for="">Nama</label>
                                        <input type="text" required name="nama" class="form-control" value="<?= $category['name'] ?>">
                                    </div>
                                    
                                </div>
                                <div class="form-group text-end">
                                    <button type="submit" name="update" class="btn btn-success btn-lg w-100 mt-4">Perbarui <i class="bi bi-arrow-clockwise"></i></button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>