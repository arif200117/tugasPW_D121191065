<?php

require 'functions.php';

if (!isset($_GET['Id'])) {
  header("Location: index.php");
  exit;
}
//ambil id dari URL
$Id = $_GET['Id'];

//query mahasiswa berdasarkan id
$m = query("SELECT * FROM mahasiswa WHERE Id = $Id");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h3>Detail Mahasiswa</h3>
  <ul>
    <li><img src="img/<?= $m['Gambar']; ?>" width="250px" height="300px"></li>
    <li>Nama : <?= $m['Nama']; ?></li>
    <li>Nim : <?= $m['Nim']; ?></li>
    <li>Email : <?= $m['Email']; ?></li>
    <li> <a href="hapus.php?Id=<?= $m['Id']; ?>" onclick="return confirm('Apakah Anda Yakin?');">Hapus</a></li>
    <li><a href="index.php">Kembali ke Daftar Mahasiswa</a></li>
  </ul>
</body>

</html>