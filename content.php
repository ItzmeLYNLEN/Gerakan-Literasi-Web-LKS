<?php
require "db.php";

session_start();
if (!isset($_SESSION['user'])) {
    echo "<script>alert('Mohon login terlebih dahulu'); location.replace('login.php');</script>";
    exit();
}


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Query untuk mendapatkan data konten, kategori, dan penulis
    $query = "
        SELECT content.title, content.body, content.created_at, 
               category.name AS category_name, 
               users.first_name, users.last_name
        FROM content
        JOIN category ON content.category_id = category.id
        JOIN users ON content.user_id = users.id
        WHERE content.id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $content = $stmt->get_result()->fetch_assoc();

    if (!$content) {
        echo "<script>alert('Konten tidak ditemukan!'); location.replace('index.php');</script>";
        exit();
    }
} else {
    echo "<script>alert('ID tidak valid!'); location.replace('index.php');</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/style.css">
    <title><?= htmlspecialchars($content['title']) ?></title>
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
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Settings
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item" href="logout.php">Log Out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <section id="about-me">
            <div class="row">
                <div class="col-md-3">
                    <h5 class="fw-bold" align="left">Judul</h5>
                    <p align="right"><?= htmlspecialchars($content['title']) ?></p>
                    <hr>
                    <h5 class="fw-bold" align="left">Kategori</h5>
                    <p align="right"><?= htmlspecialchars($content['category_name']) ?></p>
                    <hr>
                    <h5 class="fw-bold" align="left">Ditulis Oleh</h5>
                    <p align="right"><?= htmlspecialchars($content['first_name'] . " " . $content['last_name']) ?></p>
                    <hr>
                    <h5 class="fw-bold" align="left">Diterbitkan</h5>
                    <p align="right"><?= htmlspecialchars($content['created_at']) ?></p>
                    <hr>
                    <div class="container">
                        <a href="baca.php">
                            <button class="btn btn-warning btn-lg text-white mt-4"><i class="bi bi-arrow-90deg-left"></i> Kembali</button>
                        </a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="col-md-3">
                        <h5 class="fw-bold">Halaman</h5>
                    </div>
                    <div class="container">
                        <p class="text-muted"><?= nl2br(htmlspecialchars($content['body'])) ?></p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
