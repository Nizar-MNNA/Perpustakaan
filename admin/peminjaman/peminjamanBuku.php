<?php
// Halaman pengelolaan peminjaman buku perpustakaan
require "../../backend/config.php";
$dataPeminjam = queryReadData("SELECT peminjaman.id_peminjaman, peminjaman.id_buku, buku.judul, peminjaman.nrp, member.nama, member.kelas, member.jurusan, peminjaman.id_admin,  peminjaman.tgl_peminjaman, peminjaman.tgl_pengembalian 
FROM peminjaman 
INNER JOIN member ON peminjaman.nrp = member.nrp
INNER JOIN buku ON peminjaman.id_buku = buku.id");
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
                <caption>List of Peminjaman</caption>
                <div class="table-responsive mt-3">
                    <table class="table table-striped table-hover">
                        <thead class="text-center">
                            <tr>
                                <th class="bg-primary text-light">Id Peminjaman</th>
                                <th class="bg-primary text-light">Id Buku</th>
                                <th class="bg-primary text-light">Judul Buku</th>
                                <th class="bg-primary text-light">Nisn Siswa</th>
                                <th class="bg-primary text-light">Nama siswa</th>
                                <th class="bg-primary text-light">Kelas</th>
                                <th class="bg-primary text-light">Jurusan</th>
                                <th class="bg-primary text-light">Id Admin</th>
                                <th class="bg-primary text-light">Tanggal Peminjaman</th>
                                <th class="bg-primary text-light">Tanggal Pengembalian</th>
                            </tr>
                        </thead>
                        <?php foreach ($dataPeminjam as $item): ?>
                            <tr>
                                <td><?= $item["id_peminjaman"]; ?></td>
                                <td><?= $item["id_buku"]; ?></td>
                                <td><?= $item["judul"]; ?></td>
                                <td><?= $item["nrp"]; ?></td>
                                <td><?= $item["nama"]; ?></td>
                                <td><?= $item["kelas"]; ?></td>
                                <td><?= $item["jurusan"]; ?></td>
                                <td><?= $item["id_admin"]; ?></td>
                                <td><?= $item["tgl_peminjaman"]; ?></td>
                                <td><?= $item["tgl_pengembalian"]; ?></td>
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