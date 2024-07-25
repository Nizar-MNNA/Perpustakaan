<?php 
require "../../backend/config.php"; 

$nrpMember = $_GET["id"];
if(deleteMember($nrpMember) > 0) {
    echo "<script>
    alert('Member berhasil dihapus!');
    document.location.href = 'member.php';
    </script>";
  }else {
    echo "<script>
    alert('Member gagal dihapus!');
    document.location.href = 'member.php';
    </script>";
}
?>