<?php
session_start();

if(!isset($_SESSION["signIn"]) ) {
  header("Location: ../sign/admin/sign_in.php");
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Member Dashboard</title>
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="lni lni-grid-alt"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#"><img src="../foto/logo.png" class="img-fluid"></a>
                    <hr>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="dashboardMember.php" class="sidebar-link">
                        <i class="fa-solid fa-gauge" style="color: #ffffff;"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="buku/daftarBuku.php" class="sidebar-link">
                        <i class="fa-solid fa-book" style="color: #ffffff;"></i>
                        <span>Daftar Buku</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../member/formPeminjaman/TransaksiPeminjaman.php" class="sidebar-link">
                        <i class="fa-solid fa-book-open" style="color: #ffffff;"></i>
                        <span>Peminjaman Buku</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../member/formPeminjaman/TransaksiPengembalian.php" class="sidebar-link">
                        <i class="fa-solid fa-book-open-reader" style="color: #ffffff;"></i>
                        <span>Pengembalian Buku</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../member/formPeminjaman/TransaksiDenda.php" class="sidebar-link">
                        <i class="fa-solid fa-money-bill"></i>
                        <span>Denda</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="signOut.php" class="sidebar-link">
                    <i class="lni lni-exit"></i>
                    <span>Sign Out</span>
                </a>
            </div>
        </aside>
        <div class="main p-3">
            <?php
            $date = date('Y-m-d H:i:s');
            $day = date('l');
            $dayOfMonth = date('d');
            $month = date('F');
            $year = date('Y');
            ?>

            <h1 class="mt-5 fw-bold">Dashboard - <span class="fs-4 text-secondary">
                    <?php echo $day . " " . $dayOfMonth . " " . " " . $month . " " . $year; ?> </span></h1>

            <div class="alert alert-success" role="alert">Selamat datang member - <span
                    class="fw-bold text-capitalize"><?php echo $_SESSION['member']['nama']; ?></span> di Dashboard
                AyoPerpus</div>

            <div class="mt-4 p-3">
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <div class="cardImg">
                        <a href="buku/daftarBuku.php">
                            <img src="../foto/Buku.png" alt="daftar buku" style="max-width: 100%;" width="600px">
                        </a>
                    </div>

                    <div class="cardImg">
                        <a href="../member/formPeminjaman/TransaksiPeminjaman.php">
                            <img src="../foto/peminjaman.png" alt="daftar buku" style="max-width: 100%;" width="600px">
                        </a>
                    </div>
                    <div class="cardImg">
                        <a href="../member/formPeminjaman/TransaksiPengembalian.php">
                            <img src="../foto/Pengembalian.png" alt="daftar buku" style="max-width: 100%;"
                                width="600px">
                        </a>
                    </div>

                    <div class="cardImg">
                        <a href="../member/formPeminjaman/TransaksiDenda.php">
                            <img src="../foto/denda.png" alt="daftar buku"
                                style="max-width: 100%;" width="600px">
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <footer class="p-3 mb-2 bg-info-subtle text-info-emphasis">
        <div class="container-fluid d-flex justify-content-between">
            <p class="mt-2"><span class="text-primary"> Moh. Nizar Nugraha Adi</span> © 2024</p>
            <p class="mt-2 text-primary"></p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>