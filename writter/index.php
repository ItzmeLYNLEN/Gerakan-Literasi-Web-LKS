<?php
require "../db.php";

session_start();
if (!isset($_SESSION['user'])) {
    echo "<script>alert('Mohon login terlebih dahulu')
  location.replace('login.php')</script>";
}

$id_user = $conn->query("SELECT * FROM users");

$id_cat = $conn->query("SELECT * FROM category");

$contents = $conn->query("SELECT * FROM content");

function createSlug($string) {
    $slug = strtolower(trim($string));
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    return $slug;
  }

if (isset($_POST['add'])) {
    $judul = $_POST['judul'];
    $slug = createSlug($judul);
    $body = $_POST['body'];
    $cat = $_POST['cat'];
    $user = $_POST['user'];
    $direktori = "berkas/";
    $thumbnail = $_FILES['thumbnail']['name'];
    move_uploaded_file($_FILES['thumbnail']['tmp_name'],$direktori.$thumbnail);

    $simpan = $conn->query("INSERT INTO content VALUES(NULL,'$judul', '$slug', '$body', '$thumbnail', NULL, NULL ,'$cat', '$user' , NULL)");

    if ($simpan) {
        echo '<script>alert("Konten Berhasil Ditambahkan");
        location.replace("index.php");</script>';
    } else {
        echo '<script>alert("Konten Gagal Ditambah");
        location.replace("index.php");</script>';
    }
}
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $delete = $conn->query("DELETE FROM content WHERE id = '$id'");
        if ($delete) {
          echo '<script>alert("Konten Berhasil Dihapus");
          location.replace("index.php");</script>';
        }
      }

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Content</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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
        </li>
        <?php 
        $level = $_SESSION['user'] == 'writter';
        if($level) {
        ?>
        <li class="nav-item">
          <a class="nav-link" href="writter">Content</a>
        </li>
        <?php } ?>
        <?php
        $level = $_SESSION['user'] == 'admin';
        if ($level) {
        
        ?>
        <li class="nav-item">
          <a class="nav-link" href="../user">User</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../category">Category</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="writter">Content</a>
        </li>
        <?php } ?>
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Settings
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#">Profile</a></li>
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
                        <h3 class="fw-bold mb-4 text-center">Add Content <i class="bi bi-collection"></i></h3>
                        <hr>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-grup mb-3">
                                        <label class="form-label" for="">Judul</label>
                                        <input type="text" required id="judul" name="judul" class="form-control">
                                    </div>
                                    <div class="form-grup mb-3">
                                        <label class="form-label" for="">Body</label>
                                        <input type="text" required id="body" name="body" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                        <div class="form-grup mb-3">
                                        <label class="form-label" for="">Thumbnail</label>
                                        <input type="file" id="thumbnail" required name="thumbnail" class="form-control">
                                        </div>
                                        <div class="form-grup mb-3">
                                            <label class="form-label" for="">Id User</label>
                                            <select class="form-select" name="user" id="user">
                                            <?php
                                            foreach ($id_user as $show) { ?>
                                                <option value="<?= $show['id'] ?>"><?= $show['first_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                        </div>
                                    <div class="form-grup mb-3">
                                        <label class="form-label" for="">Id Category</label>
                                        <select class="form-select" name="cat" id="cat">
                                            <?php
                                            foreach ($id_cat as $show) { ?>
                                                <option value="<?= $show['id'] ?>"><?= $show['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group text-end">
                                <button class="btn btn-primary btn-lg w-100" type="submit" name="add">Add <i class="bi bi-folder-plus"></i></button>
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
                                <th>Judul</th>
                                <th>Slug</th>
                                <th>Thumbnail</th>
                                <th>Id Category</th>
                                <th>Id User</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($contents as $content) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $content['title'] ?></td>
                                    <td><?= $content['slug'] ?></td>
                                    <td><?= $content['thumbnail'] ?></td>
                                    <td><?= $content['category_id'] ?></td>
                                    <td><?= $content['user_id'] ?></td>
                                    <td><?= $content['created_at'] ?></td>
                                    <td class="text-center">
                                        <a href="edit.php?id=<?= $content['id'] ?>" class="btn btn-warning text-white btn-sm">Edit <i class="bi bi-pencil-fill"></i></a>
                                        <form action="" method="POST">
                                            <input type="hidden" name="id" value="<?= $content['id'] ?>">
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