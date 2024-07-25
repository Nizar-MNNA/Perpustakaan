<?php
session_start();

if (!isset($_SESSION["signIn"])) {
    header("Location: ../../sign/member/sign_in.php");
    exit;
}
require "../../backend/config.php";
// Tangkap id buku dari URL (GET)
$idBuku = $_GET["id"];
$query = queryReadData("SELECT * FROM buku WHERE id = '$idBuku'");
//Menampilkan data siswa yg sedang login
$nrpSiswa = $_SESSION["member"]["nrp"];
$dataSiswa = queryReadData("SELECT * FROM member WHERE nrp = $nrpSiswa");
$admin = queryReadData("SELECT * FROM admin");

// Peminjaman 
if (isset($_POST["pinjam"])) {

    if (pinjamBuku($_POST) > 0) {
        echo "<script>
    alert('Buku berhasil dipinjam');
    </script>";
    } else {
        echo "<script>
    alert('Buku gagal dipinjam!');
    </script>";
    }

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
            <h2 class="mt-5">Form peminjaman Buku</h2>
            <div class="card">
                <h5 class="card-header">Data Lengkap buku</h5>
                <div class="card-body d-flex flex-wrap gap-5 justify-content-center">
                    <?php foreach ($query as $item): ?>
                        <p class="card-text"><img src="../../DBfoto/<?= $item["cover"]; ?>" width="180px" height="185px"
                                style="border-radius: 5px;"></p>
                        <form action="" method="post">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Id Buku</span>
                                <input type="text" class="form-control" placeholder="id buku" aria-label="Username"
                                    aria-describedby="basic-addon1" value="<?= $item["id"]; ?>" readonly>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Kategori</span>
                                <input type="text" class="form-control" placeholder="kategori" aria-label="kategori"
                                    aria-describedby="basic-addon1" value="<?= $item["kategori"]; ?>" readonly>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Judul</span>
                                <input type="text" class="form-control" placeholder="judul" aria-label="judul"
                                    aria-describedby="basic-addon1" value="<?= $item["judul"]; ?>" readonly>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Pengarang</span>
                                <input type="text" class="form-control" placeholder="pengarang" aria-label="pengarang"
                                    aria-describedby="basic-addon1" value="<?= $item["pengarang"]; ?>" readonly>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Penerbit</span>
                                <input type="text" class="form-control" placeholder="penerbit" aria-label="penerbit"
                                    aria-describedby="basic-addon1" value="<?= $item["penerbit"]; ?>" readonly>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Tahun Terbit</span>
                                <input type="date" class="form-control" placeholder="tahun_terbit" aria-label="tahun_terbit"
                                    aria-describedby="basic-addon1" value="<?= $item["tahun_terbit"]; ?>" readonly>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Jumlah Halaman</span>
                                <input type="number" class="form-control" placeholder="jumlah halaman"
                                    aria-label="jumlah halaman" aria-describedby="basic-addon1"
                                    value="<?= $item["jumlah_halaman"]; ?>" readonly>
                            </div>
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="deskripsi singkat buku" id="floatingTextarea2"
                                    style="height: 100px" readonly><?= $item["deskripsi"]; ?></textarea>
                                <label for="floatingTextarea2">Deskripsi Buku</label>
                            </div>
                        <?php endforeach; ?>
                    </form>
                </div>
            </div>

            <div class="card mt-4">
                <h5 class="card-header">Data lengkap Siswa</h5>
                <div class="card-body d-flex flex-wrap gap-4 justify-content-center">
                    <p><img src="../../foto/memberLogo.png" width="150px"></p>
                    <form action="" method="post">
                        <?php foreach ($dataSiswa as $item): ?>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">nrp</span>
                                <input type="number" class="form-control" placeholder="nrp" aria-label="nrp"
                                    aria-describedby="basic-addon1" value="<?= $item["nrp"]; ?>" readonly>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Nama</span>
                                <input type="text" class="form-control" placeholder="nama" aria-label="nama"
                                    aria-describedby="basic-addon1" value="<?= $item["nama"]; ?>" readonly>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Jenis Kelamin</span>
                                <input type="text" class="form-control" placeholder="jenis kelamin"
                                    aria-label="jenis kelamin" aria-describedby="basic-addon1"
                                    value="<?= $item["jenis_kelamin"]; ?>" readonly>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Kelas</span>
                                <input type="text" class="form-control" placeholder="kelas" aria-label="kelas"
                                    aria-describedby="basic-addon1" value="<?= $item["kelas"]; ?>" readonly>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Jurusan</span>
                                <input type="text" class="form-control" placeholder="jurusan" aria-label="jurusan"
                                    aria-describedby="basic-addon1" value="<?= $item["jurusan"]; ?>" readonly>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">No Tlp</span>
                                <input type="no_tlp" class="form-control" placeholder="no tlp" aria-label="no tlp"
                                    aria-describedby="basic-addon1" value="<?= $item["no_tlp"]; ?>" readonly>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Tanggal Daftar</span>
                                <input type="date" class="form-control" placeholder="tgl_pendaftaran"
                                    aria-label="tgl_pendaftaran" aria-describedby="basic-addon1"
                                    value="<?= $item["tgl_pendaftaran"]; ?>" readonly>
                            </div>
                        <?php endforeach; ?>
                    </form>
                </div>
            </div>
            <div class="card mt-4">
                <h5 class="card-header">Form Pinjam Buku</h5>
                <div class="card-body">
                    <form action="" method="post">
                        <!--Ambil data id buku-->
                        <?php foreach ($query as $item): ?>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Id Buku</span>
                                <input type="text" name="id_buku" class="form-control" placeholder="id buku"
                                    aria-label="id" aria-describedby="basic-addon1" value="<?= $item["id"]; ?>"
                                    readonly>
                            </div>
                        <?php endforeach; ?>
                        <!-- Ambil data nrp user yang login-->
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">nrp</span>
                            <input type="number" name="nrp" class="form-control" placeholder="nrp" aria-label="nrp"
                                aria-describedby="basic-addon1"
                                value="<?php echo htmlentities($_SESSION["member"]["nrp"]); ?>" readonly>
                        </div>
                        <!--Ambil data id admin-->
                        <select name="id_admin" class="form-select" aria-label="Default select example">
                            <option selected>Pilih id admin</option>
                            <?php foreach ($admin as $item): ?>
                                <option><?= $item["id"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="input-group mb-3 mt-3">
                            <span class="input-group-text" id="basic-addon1">Tanggal pinjam</span>
                            <input type="date" name="tgl_peminjaman" id="tgl_peminjaman" class="form-control"
                                placeholder="id buku" aria-label="tgl_peminjaman" aria-describedby="basic-addon1"
                                onchange="setReturnDate()" required>
                        </div>
                        <div class="input-group mb-3 mt-3">
                            <span class="input-group-text" id="basic-addon1">Tenggat Pengembalian</span>
                            <input type="date" name="tgl_pengembalian" id="tgl_pengembalian" class="form-control"
                                placeholder="tgl_pengembalian" aria-label="tgl_pengembalian"
                                aria-describedby="basic-addon1" readonly>
                        </div>

                        <a class="btn btn-danger" href="../buku/daftarBuku.php"> Batal</a>
                        <button type="submit" class="btn btn-success" name="pinjam">Pinjam</button>
                    </form>
                </div>
            </div>

            <div class="alert alert-danger mt-4" role="alert"><span class="fw-bold">Catatan :</span> Setiap
                keterlambatan pada pengembalian buku akan dikenakan sanksi berupa denda.</div>

        </div>
    </div>

    <footer class="p-3 mb-2 bg-info-subtle text-info-emphasis">
        <div class="container-fluid d-flex justify-content-between">
            <p class="mt-2"><span class="text-primary"> Moh. Nizar Nugraha Adi</span> © 2024</p>
            <p class="mt-2 text-primary"></p>
        </div>
    </footer>

    <script src="../../script/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>