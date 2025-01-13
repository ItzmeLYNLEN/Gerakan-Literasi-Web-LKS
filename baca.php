<?php
require "db.php";

session_start();
if (!isset($_SESSION['user'])) {
    echo "<script>alert('Mohon login terlebih dahulu'); location.replace('login.php');</script>";
    exit();
}

// Jumlah buku per halaman
$books_per_page = 12;

// Ambil halaman saat ini (default halaman 1)
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;

// Hitung offset untuk query
$offset = ($page - 1) * $books_per_page;

// Cek jika ada pencarian
$search_query = isset($_GET['cari']) ? $_GET['cari'] : '';
$search_condition = !empty($search_query) ? "WHERE title LIKE '%$search_query%'" : '';

// Query total jumlah buku (sesuai pencarian jika ada)
$total_books = $conn->query("SELECT COUNT(*) AS total FROM content $search_condition")->fetch_assoc()['total'];

// Hitung jumlah halaman
$total_pages = ceil($total_books / $books_per_page);

// Query untuk mendapatkan data buku sesuai halaman dan pencarian
$tampil = $conn->query("SELECT * FROM content $search_condition LIMIT $books_per_page OFFSET $offset");

// Query untuk kategori
$kategori = $conn->query("SELECT * FROM category");

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
                        <a class="nav-link "  href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="baca.php">Baca</a>
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
                    <form method="get" class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" name="cari" value="<?= htmlspecialchars($search_query) ?>" aria-label="Search">
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

    <section id="carousel-books" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-primary">Buku Pilihan</h2>
            <p class="text-muted">Berikut adalah rekomendasi buku terbaik untuk Anda</p>
        </div>

        <div id="booksCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php foreach ($tampil as $index => $book) { ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <div class="card">
                                    <img src="writter/berkas/<?= $book['thumbnail'] ?>" class="card-img-top" alt="<?= $book['title'] ?>" style="height: 300px; object-fit: cover;">
                                    <div class="card-body text-center">
                                        <h5 class="card-title"><?= htmlspecialchars($book['title']) ?></h5>
                                        <a href="content.php?id=<?= $book['id'] ?>" class="btn btn-primary">Baca Sekarang</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#booksCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#booksCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>

<section id="books-section" class="py-5 bg-light">
    <div class="container">
        <!-- Header Section -->
        <div class="text-center mb-5">
            <h2 class="fw-bold text-primary">Koleksi Buku</h2>
            <p class="text-muted">Temukan buku-buku terbaik yang kami sediakan untuk Anda</p>
        </div>

        <!-- Layout dengan Grid Cards -->
        <div class="row g-4">
            <?php foreach ($tampil as $book) { ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm border-0">
                        <!-- Thumbnail Buku -->
                        <div class="position-relative">
                            <img src="writter/berkas/<?= $book['thumbnail'] ?>" class="card-img-top" alt="<?= $book['title'] ?>" style="height: 200px; object-fit: cover; border-radius: 8px;">
                            <div class="badge bg-info position-absolute top-0 end-0 m-2">Baru</div>
                        </div>

                        <!-- Informasi Buku -->
                        <div class="card-body">
                            <h5 class="card-title text-dark text-truncate"><?= htmlspecialchars($book['title']) ?></h5>
                        </div>

                        <!-- Footer Card -->
                        <div class="card-footer bg-white text-center">
                            <a href="content.php?id=<?= $book['id'] ?>" class="btn btn-outline-primary btn-sm">Baca Sekarang</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation example" class="mt-4">
            <ul class="pagination justify-content-center">
                <!-- Tombol Previous -->
                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <!-- Nomor Halaman -->
                <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                    <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php } ?>

                <!-- Tombol Next -->
                <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
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

