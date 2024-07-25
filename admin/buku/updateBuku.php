<?php
require "../../backend/config.php";
// Ambil data dari url
$review = $_GET["id"];
$reviewData = queryReadData("SELECT * FROM buku WHERE id = '$review'")[0];

$kategori = queryReadData("SELECT * FROM kategori_buku");

if (isset($_POST["update"])) {

    if (updateBuku($_POST) > 0) {
        echo "<script>
    alert('Data buku berhasil diupdate!');
    document.location.href = 'daftarBuku.php';
    </script>";
    } else {
        echo "<script>
    alert('Data buku gagal diupdate!');
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
                    <a href="../../admin/dashboardAdmin.php" class="sidebar-link">
                        <i class="fa-solid fa-gauge" style="color: #ffffff;"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../../admin/member/member.php" class="sidebar-link">
                        <i class="fa-solid fa-user" style="color: #ffffff;"></i>
                        <span>Member</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../../admin/buku/daftarBuku.php" class="sidebar-link">
                        <i class="fa-solid fa-book" style="color: #ffffff;"></i>
                        <span>Daftar Buku</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../../admin/peminjaman/peminjamanBuku.php" class="sidebar-link">
                        <i class="fa-solid fa-book-open" style="color: #ffffff;"></i>
                        <span>Peminjaman Buku</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../../admin/pengembalian/pengembalianBuku.php" class="sidebar-link">
                        <i class="fa-solid fa-book-open-reader" style="color: #ffffff;"></i>
                        <span>Pengembalian Buku</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../../admin/denda/daftarDenda.php" class="sidebar-link">
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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="../../admin/buku/daftarBuku.php" class="btn btn-primary">
                    <i class="fa-solid fa-arrow-left" style="color: #ffffff;"></i>
                </a>
            </div>
            <div class="container p-3 mt-5">
                <div class="card p-2 mt-5">
                    <h1 class="text-center fw-bold p-3">Form Edit buku</h1>
                    <form action="" method="post" enctype="multipart/form-data" class="mt-3 p-2">

                        <div class="custom-css-form">
                            <div class="mb-3">
                                <input type="hidden" name="coverLama" value="<?= $reviewData["cover"]; ?>">
                                <img src="../../DBfoto/<?= $reviewData["cover"]; ?>" width="80px" height="80px">
                                <label for="formFileMultiple" class="form-label">Cover Buku</label>
                                <input class="form-control" type="file" name="cover" id="formFileMultiple">
                            </div>
                        </div>

                        <div class="custom-css-form">
                            <div class="mb-3">
                                <label for="formFilePDF" class="form-label">File PDF</label>
                                <input class="form-control" type="file" name="pdf" id="formFilePDF">
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01">Kategori</label>
                            <select class="form-select" id="inputGroupSelect01" name="kategori">
                                <option selected><?= $reviewData["kategori"]; ?></option>
                                <?php foreach ($kategori as $item): ?>
                                    <option><?= $item["kategori"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-book"></i></span>
                            <input type="text" class="form-control" name="judul" id="judul" placeholder="Judul Buku"
                                aria-label="Username" aria-describedby="basic-addon1"
                                value="<?= $reviewData["judul"]; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Pengarang</label>
                            <input type="text" class="form-control" name="pengarang" id="exampleFormControlInput1"
                                placeholder="nama pengarang" value="<?= $reviewData["pengarang"]; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Penerbit</label>
                            <input type="text" class="form-control" name="penerbit" id="exampleFormControlInput1"
                                placeholder="nama penerbit" value="<?= $reviewData["penerbit"]; ?>">
                        </div>

                        <label for="validationCustom01" class="form-label">Tahun Terbit</label>
                        <div class="input-group mt-0">
                            <span class="input-group-text" id="basic-addon1"><i
                                    class="fa-solid fa-calendar-days"></i></span>
                            <input type="date" class="form-control" name="tahun_terbit" id="validationCustom01"
                                value="<?= $reviewData["tahun_terbit"]; ?>">
                        </div>

                        <label for="validationCustom01" class="form-label">Jumlah Halaman</label>
                        <div class="input-group mt-0">
                            <span class="input-group-text" id="basic-addon1"><i
                                    class="fa-solid fa-book-open"></i></span>
                            <input type="number" class="form-control" name="jumlah_halaman" id="validationCustom01"
                                value="<?= $reviewData["jumlah_halaman"]; ?>">
                        </div>

                        <div class="form-floating mt-3 mb-3">
                            <textarea class="form-control" placeholder="sinopsis tentang buku ini" name="deskripsi"
                                id="floatingTextarea2" style="height: 100px"><?= $reviewData["deskripsi"]; ?></textarea>
                            <label for="floatingTextarea2">Sinopsis</label>
                        </div>

                        <button class="btn btn-success" type="submit" name="update">Edit</button>
                        <a class="btn btn-danger" href="daftarBuku.php">Batal</a>
                    </form>
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