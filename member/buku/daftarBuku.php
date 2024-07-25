<?php
session_start();

if (!isset($_SESSION["signIn"])) {
    header("Location: ../../sign/member/sign_in.php");
    exit;
}

require "../../backend/config.php";
$buku = queryReadData("SELECT * FROM buku");
if (isset($_POST["search"])) {
    $buku = search($_POST["keyword"]);
}
if (isset($_POST["filsafat"])) {
    $buku = queryReadData("SELECT * FROM buku WHERE kategori = 'filsafat'");
}
if (isset($_POST["informatika"])) {
    $buku = queryReadData("SELECT * FROM buku WHERE kategori = 'informatika'");
}
if (isset($_POST["novel"])) {
    $buku = queryReadData("SELECT * FROM buku WHERE kategori = 'novel'");
}
if (isset($_POST["pengembangan diri"])) {
    $buku = queryReadData("SELECT * FROM buku WHERE kategori = 'pengembangan diri'");
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
    <title>Admin Dashboard</title>
</head>
<style>
    .layout-card-custom {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 1.5rem;
    }
</style>

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
            <!--Btn filter data kategori buku-->
            <div class="d-flex gap-2 mt-5 justify-content-center">
                <form action="" method="post">
                    <div class="layout-card-custom">
                        <button class="btn btn-primary" type="submit">Semua</button>
                        <button type="submit" name="filsafat" class="btn btn-outline-primary">filsafat</button>
                        <button type="submit" name="informatika" class="btn btn-outline-primary">informatika</button>
                        <button type="submit" name="novel" class="btn btn-outline-primary">novel</button>
                        <button type="submit" name="pengembangan diri" class="btn btn-outline-primary">pengembangan
                            diri</button>
                    </div>
                </form>
            </div>

            <form action="" method="post" class="mt-5">
                <div class="input-group d-flex justify-content-end mb-3">
                    <input class="border p-2 rounded rounded-end-0 bg-tertiary" type="text" name="keyword" id="keyword"
                        placeholder="cari judul atau kategori buku...">
                    <button class="border border-start-0 bg-light rounded rounded-start-0" type="submit"
                        name="search"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>

            <!--Card buku-->
            <div class="layout-card-custom">
                <?php foreach ($buku as $item): ?>
                    <div class="card" style="width: 15rem;">
                        <img src="../../DBfoto/<?= $item["cover"]; ?>" class="card-img-top" alt="coverBuku" height="250px">
                        <div class="card-body">
                            <h5 class="card-title"><?= $item["judul"]; ?></h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Kategori : <?= $item["kategori"]; ?></li>
                        </ul>
                        <div class="card-body">
                            <a class="btn btn-success" href="detailBuku.php?id=<?= $item["id"]; ?>">Detail</a>
                            <a class="btn btn-primary" href="<?= $item["path"]; ?>" download><i class="fa-solid fa-download"
                                    style="color: #ffffff;"></i></a>
                        </div>
                    </div>
                <?php endforeach; ?>
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