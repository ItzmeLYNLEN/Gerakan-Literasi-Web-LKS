<?php

require "../db.php";
session_start();
if (!isset($_SESSION['user'])) {
    echo "<script>alert('Mohon login terlebih dahulu')
  location.replace('../login.php')</script>";
}

$id_user = $conn->query("SELECT * FROM users");

$id_cat = $conn->query("SELECT * FROM category");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $content = $conn->query("SELECT * FROM content WHERE id = $id")->fetch_assoc();
}

function createSlug($string) {
    $slug = strtolower(trim($string));
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    return $slug;
  }

if (isset($_POST['update'])) {
    $judul = $_POST['judul'];
    $slug = createSlug($judul);
    $body = $_POST['body'];
    $cat = $_POST['cat'];
    $user = $_POST['user'];
    $direktori = "berkas/";
    $thumbnail = $_FILES['thumbnail']['name'];
    move_uploaded_file($_FILES['thumbnail']['tmp_name'],$direktori.$thumbnail);

    $simpan = mysqli_query($conn, "UPDATE content SET
    title = '$judul',
    slug = '$slug',
    body = '$body',
    category_id = '$cat',
    user_id = '$user',
    thumbnail = '$thumbnail'WHERE id = '$id'");

    if ($simpan) {
        echo '<script>alert("Konten Berhasil Diperbarui");
    location.replace("index.php");</script>';
    } else {
        echo '<script>alert("Konten Gagal Diperbarui");
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

<div class="container">
        <a href="index.php"><button class="btn btn-warning btn-lg text-white mt-4"><i class="bi bi-arrow-90deg-left"></i> Kembali</i></button></a>
    </div>

<div class="container">
        <div class="row justify-content-center pt-3 mt-3">
            <div class="col-lg-10">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="fw-bold mb-4 text-center">Update Content</h3>
                        <hr>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-grup mb-3">
                                        <label class="form-label" for="">Judul</label>
                                        <input type="text" required id="judul" name="judul" class="form-control" value="<?= $content['title'] ?>">
                                    </div>
                                    <div class="form-grup mb-3">
                                        <label class="form-label" for="">Body</label>
                                        <input type="text" required id="body" name="body" class="form-control" value="<?= $content['body'] ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                        <div class="form-grup mb-3">
                                        <label class="form-label" for="">Thumbnail</label>
                                        <input type="file" id="thumbnail" required name="thumbnail" class="form-control" value="<?= $content['thumbnail'] ?>">
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
                                <button class="btn btn-primary btn-lg w-100" type="submit" name="update">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>