<?php
require "db.php";

session_start();
if (!isset($_SESSION['user'])) {
  echo "<script>alert('Mohon login terlebih dahulu')
  location.replace('login.php')</script>";
}
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $category = $conn->query("SELECT * FROM category WHERE id = $id")->fetch_assoc();
}
if (isset($_GET['cari'])) {
  $cari = $conn->query("SELECT * FROM content WHERE title LIKE '%" .
    $_GET['cari'] . "%'");
}

$tampil = $conn->query("SELECT * FROM content INNER JOIN users ON content.user_id = users.id");

// $tampil = $conn->query("SELECT * FROM content");

$kategori = $conn->query("SELECT * FROM category");

$users = $conn->query("SELECT * FROM users");

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/style.css">
  <title>Home Page</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
      <a class="navbar-brand" href="#">Literasi</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav nav-underline">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <?php
          $level = $_SESSION['user'] == 'writter';
          if ($level) {
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
              <a class="nav-link" href="user">User</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="category">Category</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="writter">Content</a>
            </li>
          <?php } ?>
        </ul>

        <ul class="navbar-nav ms-auto">
          <div class="dropdown-center">
            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Book Category
            </button>
            <ul class="dropdown-menu">
              <?php foreach ($kategori as $cat) {  ?>
              <li><a class="dropdown-item" href="#"><?= $cat['name'] ?></a></li>
              <?php } ?>
            </ul>
          </div>
          <form method="get" class="d-flex " role="search">
            <input class="form-control me-2" type="search" placeholder="Search" name="cari" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Settings
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="profile">Profile</a></li>
              <li><a class="dropdown-item" href="logout.php">Log Out</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <section id="banner">
    <div class="container mt-5 mb-5">
      <div class="row justify-content-center">
        <div class="col-lg-4">
          <div class="col-12">
            <h1 class="header" style="font-size: 38px;">
              <span class="fw-bold">Baca, Ceritakan,<br>dan Sebar Ceritamu.</span>
            </h1>
          </div>
          <p class="desc">Ini adalah platform untuk membaca buku online dan mengunggah cerita di mana saja dan kapan saja. Kamu bisa menemukan berbagai buku menarik mulai dari novel sampai quotes di sini. Ayo mulai baca sekarang!</p>
        </div>
        <div class="col-lg-6">
          <img class="ms-5 py-3" id="lani" src="assets/img/book.jpg" alt="" width="92%" height="auto">
        </div>
      </div>
      <hr>
    </div>

  </section>


  <section id="about">
    <div class="container mt-5 mb-5">
      <div class="row">
        <div class="col-12">
          <h1 class="text-center md-5">Membaca Semakin Mudah</h1>
        </div>
      </div>

      <div class="row justify-content-center align-items-center pt-5">
        <div class="col-12 col-md-6 col-lg-4">
          <p class="text-center"><img src="assets/img/design-1.png" alt=""></p>
          <h3 class="text-center">Berbagi Dan Bersosialisasi.</h3>
          <p class="text-center">Temukan dan jalin pertemanan. Dapatkan aktivitas teman dan partnermu.</p>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
          <p class="text-center"><img src="assets/img/design-2.png" alt=""></p>
          <h3 class="text-center">Buat Dan Sebar Luaskan Karyamu.</h3>
          <p class="text-center">Tambah dan bagikan karyamu untuk memotivasi yang lain.</p>
        </div>
      </div>
      <hr>
    </div>
  </section>

  <section id="project">
    <div class="container mt-5 mb-5">
      <div class="row">
        <div class="col-md-3">
          <h5 class="fw-bold">Buku Untukmu</h5>
        </div>
        <div class="col-md-9">
          <div class="row">
            <?php foreach ($tampil as $show) { ?>
              <div class="col-md-6 mt-4">
                <div class="card">
                  <div class="card-body">
                    <div class="header pb-3">
                      <img class="w-100" src="writter/berkas/<?= $show['thumbnail'] ?>" alt="">
                      <h6 class="fw-bold text-center mt-2"><?= $show['title'] ?></h6>
                      <span class="text-muted"><?= $show['first_name']  . $show['last_name'] ?></span><br>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="text-end">
                      <a href="content.php?id=<?= $show['id'] ?>">
                        <button class="btn btn-sm text-primary fw-bold">
                          Mulai Membaca
                        </button>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?><br>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="bg-light text-center text-white">
    
    <div class="text-center p-3" style="background-color: black;">
      © 2023 Copyright Gerakan Literasi, Created With
      <i class="bi bi-heart-fill text-danger"></i> By <a href="https://www.instagram.com/dzikraa_24" class="fw-bold text-white text-decoration-none">Daoa</a>
    </div>
  </footer>



  <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>