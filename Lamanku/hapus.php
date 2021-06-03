<?php
include('assets/header.php');
$Id = $_GET['Id'];

if (Hapus($Id) > 0) {
  echo "<script>
        alert('Data berhasil dihapus');
        document.location.href = 'index.php';
        </script>";
} else {
  echo 'Data gagal dihapus';
}
