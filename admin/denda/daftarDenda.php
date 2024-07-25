<?php
//Halaman pengelolaan pengembalian Buku Perustakaaan
require "../../backend/config.php";
$dataDenda = queryReadData("SELECT pengembalian.id, pengembalian.id_buku, buku.judul, pengembalian.nrp, member.nama, member.jurusan, admin.nama_admin, pengembalian.buku_kembali, pengembalian.keterlambatan, pengembalian.denda
FROM pengembalian
INNER JOIN buku ON pengembalian.id_buku = buku.id
INNER JOIN member ON pengembalian.nrp = member.nrp
INNER JOIN admin ON pengembalian.id_admin = admin.id
WHERE pengembalian.denda > 0");
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
                    <a href="../dashboardAdmin.php" class="sidebar-link">
                        <i class="fa-solid fa-gauge" style="color: #ffffff;"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../member/member.php" class="sidebar-link">
                        <i class="fa-solid fa-user" style="color: #ffffff;"></i>
                        <span>Member</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../buku/daftarBuku.php" class="sidebar-link">
                        <i class="fa-solid fa-book" style="color: #ffffff;"></i>
                        <span>Daftar Buku</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../peminjaman/peminjamanBuku.php" class="sidebar-link">
                        <i class="fa-solid fa-book-open" style="color: #ffffff;"></i>
                        <span>Peminjaman Buku</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../pengembalian/pengembalianBuku.php" class="sidebar-link">
                        <i class="fa-solid fa-book-open-reader" style="color: #ffffff;"></i>
                        <span>Pengembalian Buku</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../denda/daftarDenda.php" class="sidebar-link">
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
            <div class="mt-5">
                <caption>List of denda</caption>
                <div class="table-responsive mt-3">
                    <table class="table table-striped table-hover">
                        <thead class="text-center">
                            <tr>
                                <th class="bg-primary text-light">id buku</th>
                                <th class="bg-primary text-light">Judul buku</th>
                                <th class="bg-primary text-light">nrp</th>
                                <th class="bg-primary text-light">Nama siswa</th>
                                <th class="bg-primary text-light">Jurusan</th>
                                <th class="bg-primary text-light">Nama admin</th>
                                <th class="bg-primary text-light">Hari pengembalian</th>
                                <th class="bg-primary text-light">Keterlambatan</th>
                                <th class="bg-primary text-light">Denda</th>
                            </tr>
                        </thead>
                        <?php foreach ($dataDenda as $item): ?>
                            <tr>
                                <td><?= $item["id_buku"]; ?></td>
                                <td><?= $item["judul"]; ?></td>
                                <td><?= $item["nrp"]; ?></td>
                                <td><?= $item["nama"]; ?></td>
                                <td><?= $item["jurusan"]; ?></td>
                                <td><?= $item["nama_admin"]; ?></td>
                                <td><?= $item["buku_kembali"]; ?></td>
                                <td><?= $item["keterlambatan"]; ?></td>
                                <td><?= $item["denda"]; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
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