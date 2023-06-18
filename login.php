  <?php
  include "db.php";

  session_start();

  if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $data_user = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' AND password = '$pass'");
    $cek = mysqli_num_rows($data_user);
    $r = mysqli_fetch_array($data_user);
    $emails = $r['email'];
    $password = $r['password'];
    $level = $r['role'];
    $id = $r['id'];
    if ($email == $emails && $pass == $password) {
      $_SESSION['user'] = $level;
      header('location:index.php');
    }else{
      echo "<script>alert('login gagal')
             location.replace('login.php')</script>";
    }
  }


//   if (isset($_POST['login'])) {
//     $email = $_POST['email'];
//     $password = $_POST['password'];

//     $selectUser = $conn->query("SELECT * FROM users WHERE email = '$email' AND password = '$password'");
//     $cek = mysqli_num_rows($selectUser);


//     if ($cek > 0) {
//         $_SESSION['user'] = $selectUser->fetch_assoc();
//         if ($_SESSION['user']['role'] == 'admin') {
//             var_dump($_SESSION['user']);
//           echo "<script>alert('login sukses')
//             location.replace('index.php')</script>";
//         }elseif ($_SESSION['user']['role'] == 'writter') {
//           echo "<script>alert('login sukses')
//             location.replace('index.php')</script>";
//         }else  {
//           echo "<script>alert('login sukses')
//             location.replace('index.php')</script>";
//       }
//     } else {
//       echo "<script>alert('login gagal')
//         location.replace('login.php')</script>";
//     }
//   }
  ?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>

    <div class="container pt-5">
        <div class="row justify-content-center pt-5 mt-5">
            <div class="col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="fw-bold mb-4 text-center"><i class="bi bi-lock"></i> Login</h3>
                        <hr>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control form-control-lg" id="email" name="email" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control form-control-lg" id="password" name="password" required>
                            </div>
                            <hr>
                            <button class="btn btn-primary btn-lg w-100" type="submit" name="login">Login <i class="bi bi-person-fill-check"></i></button>
                            <p class="text-center mt-2">Belum Punya akun? <a class="fw-bold" href="register.php">Daftar</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>