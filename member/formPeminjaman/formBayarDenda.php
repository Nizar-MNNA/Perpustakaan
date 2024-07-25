<?php
session_start();

if (!isset($_SESSION["signIn"])) {
    header("Location: ../../sign/member/sign_in.php");
    exit;
}
require "../../backend/config.php";

if (isset($_POST["bayar"])) {

    if (bayarDenda($_POST) > 0) {
        echo "<script>
    alert('Denda berhasil dibayar');
    document.location.href = 'TransaksiDenda.php';
    </script>";
    } else {
        echo "<script>
    alert('Denda gagal dibayar');
    </script>";
    }

}

$dendaSiswa = $_GET["id"];
$query = queryReadData("SELECT pengembalian.id, buku.judul, member.nama, pengembalian.buku_kembali, pengembalian.keterlambatan, pengembalian.denda
FROM pengembalian
INNER JOIN buku ON pengembalian.id_buku = buku.id
INNER JOIN member ON pengembalian.nrp = member.nrp
WHERE pengembalian.id = $dendaSiswa");

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
                    <a href="buku/daftarBuku.php" class="sidebar-link">
                        <i class="fa-solid fa-book" style="color: #ffffff;"></i>
                        <span>Daftar Buku</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="peminjaman/peminjamanBuku.php" class="sidebar-link">
                        <i class="fa-solid fa-book-open" style="color: #ffffff;"></i>
                        <span>Peminjaman Buku</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="pengembalian/pengembalianBuku.php" class="sidebar-link">
                        <i class="fa-solid fa-book-open-reader" style="color: #ffffff;"></i>
                        <span>Pengembalian Buku</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="denda/daftarDenda.php" class="sidebar-link">
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
            <div class="mt-5 card p-3 mb-5">
                <form action="" method="post">
                    <h3>Form bayar denda</h3>
                    <?php foreach ($query as $item): ?>
                        <input type="hidden" name="id_pengembalian" id="id_pengembalian"
                            value="<?= $item["id"]; ?>">

                        <div class="mt-4 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Nama</label>
                            <input type="text" class="form-control" placeholder="Nama siswa" name="nama" id="nama"
                                value="<?= $item["nama"]; ?>" readonly>
                        </div>

                        <div class="d-flex flex-wrap gap-4">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Buku yang dipinjam</label>
                                <input type="text" class="form-control" placeholder="Judul Buku" name="judul" id="judul"
                                    value="<?= $item["judul"]; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Tanggal dikembalikan</label>
                                <input type="date" class="form-control" name="buku_kembali" id="buku_kembali"
                                    value="<?= $item["buku_kembali"]; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Besar Denda</label>
                                <input type="number" class="form-control" name="denda" id="denda"
                                    value="<?= $item["denda"]; ?>" readonly>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Jumlah Denda yang dibayar</label>
                        <input type="number" class="form-control" name="bayarDenda" id="bayarDenda" required>
                    </div>

                    <button type="reset" class="btn btn-warning text-light">Reset</button>
                    <button type="submit" class="btn btn-success" name="bayar">Bayar</button>
                </form>
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