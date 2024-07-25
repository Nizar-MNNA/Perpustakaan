<?php
$host = 'localhost';
$dbuser = 'postgres';
$dbpass = 'Sasuke08790';
$port = '5432';
$dbname = 'perpustakaan';
$conn_string = "host={$host} port={$port} dbname={$dbname} user={$dbuser} password={$dbpass}";

$connect = pg_connect($conn_string);

// === FUNCTION KHUSUS ADMIN START ===

// MENAMPILKAN DATA KATEGORI BUKU
function queryReadData($dataKategori)
{
  global $connect;
  $result = pg_query($connect, $dataKategori);
  $items = [];
  while ($item = pg_fetch_assoc($result)) {
    $items[] = $item;
  }
  return $items;
}

// Menambahkan data buku 
function tambahBuku($dataBuku)
{
  global $connect;

  $cover = uploadImage();
  $pdf = uploadPDF();
  $kategoriBuku = $dataBuku["kategori"];
  $judulBuku = htmlspecialchars($dataBuku["judul"]);
  $pengarangBuku = htmlspecialchars($dataBuku["pengarang"]);
  $penerbitBuku = htmlspecialchars($dataBuku["penerbit"]);
  $tahunTerbit = $dataBuku["tahun_terbit"];
  $jumlahHalaman = $dataBuku["jumlah_halaman"];
  $deskripsiBuku = htmlspecialchars($dataBuku["deskripsi"]);

  if (!$cover || !$pdf) {
    return 0;
  }

  $name = htmlspecialchars($pdf['name']);
  $size = htmlspecialchars($pdf['size']);
  $type = htmlspecialchars($pdf['type']);
  $path = htmlspecialchars($pdf['path']);

  $queryInsertDataBuku = "INSERT INTO buku(cover, kategori, judul, pengarang, penerbit, tahun_terbit, jumlah_halaman, deskripsi, name, size, type, path) VALUES('$cover', '$kategoriBuku', '$judulBuku', '$pengarangBuku', '$penerbitBuku', '$tahunTerbit', $jumlahHalaman, '$deskripsiBuku', '$name', '$size', '$type', '$path')";

  $result = pg_query($connect, $queryInsertDataBuku);
  return pg_affected_rows($result);
}

// Function upload pdf
function uploadPDF()
{
  $namaFile = $_FILES["pdf"]["name"];
  $ukuranFile = $_FILES["pdf"]["size"];
  $error = $_FILES["pdf"]["error"];
  $tmpName = $_FILES["pdf"]["tmp_name"];

  // cek apakah ada file yg diupload
  if ($error === 4) {
    echo "<script>
    alert('Silahkan upload file PDF terlebih dahulu!')
    </script>";
    return 0;
  }

  // cek kesesuaian format file
  $pdf = "pdf";
  $ekstensiFile = explode('.', $namaFile);
  $ekstensiFile = strtolower(end($ekstensiFile));

  if ($ekstensiFile !== $pdf) {
    echo "<script>
    alert('Format file tidak sesuai, harus PDF');
    </script>";
    return 0;
  }

  // batas ukuran file
  if ($ukuranFile > 50000000) { // 5MB limit
    echo "<script>
    alert('Ukuran file terlalu besar!');
    </script>";
    return 0;
  }

  //generate nama file baru yang unik
  $namaFileBaru = uniqid();
  $namaFileBaru .= ".";
  $namaFileBaru .= $ekstensiFile;

  $filePath = '../../DBpdf/' . $namaFileBaru;
  move_uploaded_file($tmpName, $filePath);

  return [
    'name' => $namaFile,
    'size' => $ukuranFile,
    'type' => $_FILES["pdf"]["type"],
    'path' => $filePath
  ];
}

// Function upload gambar 
function uploadImage()
{
  $namaFile = $_FILES["cover"]["name"];
  $ukuranFile = $_FILES["cover"]["size"];
  $error = $_FILES["cover"]["error"];
  $tmpName = $_FILES["cover"]["tmp_name"];

  // cek apakah ada gambar yg diupload
  if ($error === 4) {
    echo "<script>
    alert('Silahkan upload cover buku terlebih dahulu!')
    </script>";
    return 0;
  }

  // cek kesesuaian format gambar
  $jpg = "jpg";
  $jpeg = "jpeg";
  $png = "png";
  $formatGambarValid = [$jpg, $jpeg, $png];
  $ekstensiGambar = explode('.', $namaFile);
  $ekstensiGambar = strtolower(end($ekstensiGambar));

  if (!in_array($ekstensiGambar, $formatGambarValid)) {
    echo "<script>
    alert('Format file tidak sesuai');
    </script>";
    return 0;
  }

  // batas ukuran file
  if ($ukuranFile > 2000000) {
    echo "<script>
    alert('Ukuran file terlalu besar!');
    </script>";
    return 0;
  }

  //generate nama file baru yang unik
  $namaFileBaru = uniqid();
  $namaFileBaru .= ".";
  $namaFileBaru .= $ekstensiGambar;

  move_uploaded_file($tmpName, '../../DBfoto/' . $namaFileBaru);
  return $namaFileBaru;
}

// MENAMPILKAN SESUATU SESUAI DENGAN INPUTAN USER PADA * SEARCH ENGINE *
function search($keyword)
{

  // search data buku
  $querySearch = "SELECT * FROM buku 
  WHERE judul ILIKE '%$keyword%' OR kategori ILIKE '%$keyword%';
  ";
  return queryReadData($querySearch);

  // search data pengembalian || member !!!
  $dataPengembalian = "SELECT * FROM pengembalian 
  WHERE 
  id '%$keyword%' OR
  id_buku ILIKE '%$keyword%' OR
  judul ILIKE '%$keyword%' OR
  kategori ILIKE '%$keyword%' OR
  nrp ILIKE '%$keyword%' OR
  nama ILIKE '%$keyword%' OR
  nama_admin ILIKE '%$keyword%' OR
  tgl_pengembalian ILIKE '%$keyword%' OR
  keterlambatan ILIKE '%$keyword%' OR
  denda ILIKE '%$keyword%'";
  return queryReadData($dataPengembalian);
}

function searchMember($keyword)
{
  // search member terdaftar || admin
  $searchMember = "SELECT * FROM member WHERE 
   nrp ILIKE '%$keyword%' OR 
   nama ILIKE '%$keyword%' OR 
   jurusan ILIKE '%$keyword%'
   ";
  return queryReadData($searchMember);
}


// DELETE DATA Buku
function delete($bukuId)
{
  global $connect;
  $queryDeleteBuku = "DELETE FROM buku WHERE id = '$bukuId'
  ";
  $result = pg_query($connect, $queryDeleteBuku);

  return pg_affected_rows($result);
}

// UPDATE || EDIT DATA BUKU 
function updateBuku($dataBuku)
{
  global $connect;

  $gambarLama = htmlspecialchars($dataBuku["coverLama"]);
  $pdfLama = htmlspecialchars($dataBuku["pdfLama"]);
  $idBuku = htmlspecialchars($_GET["id"]);
  $kategoriBuku = $dataBuku["kategori"];
  $judulBuku = htmlspecialchars($dataBuku["judul"]);
  $pengarangBuku = htmlspecialchars($dataBuku["pengarang"]);
  $penerbitBuku = htmlspecialchars($dataBuku["penerbit"]);
  $tahunTerbit = $dataBuku["tahun_terbit"];
  $jumlahHalaman = $dataBuku["jumlah_halaman"];
  $deskripsiBuku = htmlspecialchars($dataBuku["deskripsi"]);

  // Handle cover image upload
  if ($_FILES["cover"]["error"] === 4) {
    $cover = $gambarLama;
  } else {
    $cover = uploadImage();
  }

  // Handle PDF upload
  if ($_FILES["pdf"]["error"] === 4) {
    $pdf = $pdfLama;
  } else {
    $pdf = uploadPDF();
  }

  $queryUpdate = "UPDATE buku SET 
    cover = '$cover',
    id = '$idBuku',
    kategori = '$kategoriBuku',
    judul = '$judulBuku',
    pengarang = '$pengarangBuku',
    penerbit = '$penerbitBuku',
    tahun_terbit = '$tahunTerbit',
    jumlah_halaman = $jumlahHalaman,
    deskripsi = '$deskripsiBuku',
    pdf = '$pdf'
    WHERE id = '$idBuku'
    ";

  $result = pg_query($connect, $queryUpdate);
  return pg_affected_rows($result);
}

// Hapus member yang terdaftar
function deleteMember($nrpMember)
{
  global $connect;

  $deleteMember = "DELETE FROM member WHERE nrp = $nrpMember";
  $result = pg_query($connect, $deleteMember);
  return pg_affected_rows($result);
}

// Hapus history pengembalian data BUKU
function deleteDataPengembalian($idPengembalian)
{
  global $connect;

  $deleteDataPengembalianBuku = "DELETE FROM pengembalian WHERE id = $idPengembalian";
  $result = pg_query($connect, $deleteDataPengembalianBuku);
  return pg_affected_rows($result);
}


// === FUNCTION KHUSUS ADMIN END ===


// === FUNCTION KHUSUS MEMBER START ===
// Peminjaman BUKU
function pinjamBuku($dataBuku)
{
  global $connect;

  $idBuku = $dataBuku["id_buku"];
  $nrp = $dataBuku["nrp"];
  $idAdmin = $dataBuku["id_admin"];
  $tglPinjam = $dataBuku["tgl_peminjaman"];
  $tglKembali = $dataBuku["tgl_pengembalian"];
  // cek apakah user memiliki denda 
  $cekDenda = pg_query($connect, "SELECT denda FROM pengembalian WHERE nrp = $nrp AND denda > 0");
  if (pg_num_rows($cekDenda) > 0) {
    $item = pg_fetch_assoc($cekDenda);
    $jumlahDenda = $item["denda"];
    if ($jumlahDenda > 0) {
      echo "<script>
       alert('Anda belum melunasi denda, silahkan lakukan pembayaran terlebih dahulu !');
       </script>";
      return 0;
    }
  }
  // cek batas user meminjam buku berdasarkan nrp
  $nrpResult = pg_query($connect, "SELECT nrp FROM peminjaman WHERE nrp = $nrp");
  if (pg_fetch_assoc($nrpResult)) {
    echo "<script>
    alert('Anda sudah meminjam buku, Harap kembalikan dahulu buku yg anda pinjam!');
    </script>";
    return 0;
  }

  $queryPinjam = "INSERT INTO peminjaman(id_buku, nrp, id_admin, tgl_peminjaman, tgl_pengembalian) VALUES('$idBuku', $nrp, $idAdmin, '$tglPinjam', '$tglKembali')";
  $result = pg_query($connect, $queryPinjam);
  return pg_affected_rows($result);
}

// Pengembalian BUKU
function pengembalian($dataBuku)
{
  global $connect;

  // Variabel pengembalian
  $idPeminjaman = $dataBuku["id_peminjaman"];
  $idBuku = $dataBuku["id_buku"];
  $nrp = $dataBuku["nrp"];
  $idAdmin = $dataBuku["id_admin"];
  $tenggatPengembalian = $dataBuku["tgl_pengembalian"];
  $bukuKembali = $dataBuku["buku_kembali"];
  $keterlambatan = $dataBuku["keterlambatan"];
  $denda = $dataBuku["denda"];

  $keterlambatan = ($bukuKembali > $tenggatPengembalian) ? 'YA' : 'TIDAK';

  if ($keterlambatan === 'YA') {
    echo "<script>
    alert('Anda terlambat mengembalikan buku, harap bayar denda sesuai dengan jumlah yang ditentukan!');
    </script>";
  }

  // Memasukkan data kedalam tabel pengembalian
  $queryPengembalian = "INSERT INTO pengembalian(id_peminjaman, id_buku, nrp, id_admin, buku_kembali, keterlambatan, denda) VALUES($idPeminjaman, '$idBuku', $nrp, $idAdmin, '$bukuKembali', '$keterlambatan', $denda)";

  // Menghapus data siswa yang sudah mengembalikan buku
  $hapusDataPeminjam = "DELETE FROM peminjaman WHERE id_peminjaman = $idPeminjaman";
  $result = pg_query($connect, $hapusDataPeminjam);
  if ($result) {
    echo "<script>
    alert('Data berhasil dihapus');
    </script>";
  } else {
    echo "<script>
    alert('Gagal menghapus data');
    </script>";
  }
  $result = pg_query($connect, $queryPengembalian);
  return pg_affected_rows($result);
}

function bayarDenda($data)
{
  global $connect;
  $idPengembalian = $data["id_pengembalian"];
  $jmlDenda = $data["denda"];
  $jmlDibayar = $data["bayarDenda"];
  $calculate = $jmlDenda - $jmlDibayar;

  $bayarDenda = "UPDATE pengembalian SET denda = $calculate WHERE id = $idPengembalian";
  $result = pg_query($connect, $bayarDenda);
  return pg_affected_rows($result);
}

// === FUNCTION KHUSUS MEMBER END ===
?>