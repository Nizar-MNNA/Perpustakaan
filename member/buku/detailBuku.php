<?php
require "../../backend/config.php";
$idBuku = $_GET["id"];
$query = queryReadData("SELECT * FROM buku WHERE id = '$idBuku'");
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
    <title>Admin Dashboard</title>
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="lni lni-grid-alt"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#"><img src="../../foto/logo.png" class="img-fluid"></a>
                    <hr>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="../../member/dashboardMember.php" class="sidebar-link">
                        <i class="fa-solid fa-gauge" style="color: #ffffff;"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../../member/buku/daftarBuku.php" class="sidebar-link">
                        <i class="fa-solid fa-book" style="color: #ffffff;"></i>
                        <span>Daftar Buku</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../../member/formPeminjaman/TransaksiPeminjaman.php" class="sidebar-link">
                        <i class="fa-solid fa-book-open" style="color: #ffffff;"></i>
                        <span>Peminjaman Buku</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../../member/formPeminjaman/TransaksiPengembalian.php" class="sidebar-link">
                        <i class="fa-solid fa-book-open-reader" style="color: #ffffff;"></i>
                        <span>Pengembalian Buku</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../../member/formPeminjaman/TransaksiDenda.php" class="sidebar-link">
                        <i class="fa-solid fa-money-bill"></i>
                        <span>Denda</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="../../signOut.php" class="sidebar-link">
                    <i class="lni lni-exit"></i>
                    <span>Sign Out</span>
                </a>
            </div>
        </aside>
        <div class="main p-3">
            <h2 class="mt-5">Detail Buku</h2>
            <div class="d-flex justify-content-center">
                <div class="card" style="width: 18rem;">
                    <?php foreach ($query as $item): ?>
                        <img src="../../DBfoto/<?= $item["cover"]; ?>" class="card-img-top" alt="coverBuku" height="250px">
                        <div class="card-body">
                            <h5 class="card-title"><?= $item["judul"]; ?></h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Kategori : <?= $item["kategori"]; ?></li>
                            <li class="list-group-item">Pengarang : <?= $item["pengarang"]; ?></li>
                            <li class="list-group-item">Penerbit : <?= $item["penerbit"]; ?></li>
                            <li class="list-group-item">Tahun terbit : <?= $item["tahun_terbit"]; ?></li>
                            <li class="list-group-item">Jumlah halaman : <?= $item["jumlah_halaman"]; ?></li>
                            <li class="list-group-item">Deskripsi buku : <?= $item["deskripsi"]; ?></li>
                        </ul>
                    <?php endforeach; ?>
                    <div class="card-body">
                        <a href="daftarBuku.php" class="btn btn-danger">Batal</a>
                        <a href="../formPeminjaman/pinjamBuku.php?id=<?= $item["id"]; ?>"
                            class="btn btn-success">Pinjam</a>
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