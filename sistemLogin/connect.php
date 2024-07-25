<?php
$host = 'localhost';
$dbuser = 'postgres';
$dbpass = 'Sasuke08790';
$port = '5432';
$dbname = 'perpustakaan';
$conn_string = "host={$host} port={$port} dbname={$dbname} user={$dbuser} password={$dbpass}";

$connect = pg_connect($conn_string); 

//member
function signUp($data) {
  global $connect;

  $nrp = $data["nrp"];
  $nama = strtolower($data["nama"]);
  $password = $data["password"];
  $confirmPw = $data["confirmPw"];
  $jk = $data["jenis_kelamin"];
  $kelas = $data["kelas"];
  $jurusan = $data["jurusan"];
  $noTlp = $data["no_tlp"];
  $tglDaftar = $data["tgl_pendaftaran"];

  // cek nrp
  $nrpResult = pg_query_params($connect, "SELECT nrp FROM member WHERE nrp = $1", array($nrp));
  if (pg_fetch_assoc($nrpResult)) {
      echo "<script>alert('nrp sudah terdaftar, silahkan gunakan nrp lain!');</script>";
      return 0;
  }

  // cek kesamaan confirm password dan password
  if ($password !== $confirmPw) {
      echo "<script>alert('password / confirm password tidak sesuai');</script>";
      return 0;
  }

  // Insert data menggunakan parameterized query
  $querySignUp = "INSERT INTO member VALUES($1, $2, $3, $4, $5, $6, $7, $8)";
  $params = array($nrp, $nama, $password, $jk, $kelas, $jurusan, $noTlp, $tglDaftar);
  $result = pg_query_params($connect, $querySignUp, $params);
  return pg_affected_rows($result);
}


?>