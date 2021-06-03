<?php
include('assets/header.php');

if (isset($_POST['Tambah'])) {
  if (Tambah($_POST) > 0) {
    echo "<script> 
                    alert('data berhasil ditambahkan'); 
                    document.location.href = 'index.php';
               </script>";
  } else {
    echo "data gagal ditambahkan";
  }
}

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
  <h3>Form Tambah Data Mahasiswa</h3>
  <form action="" method="POST" enctype="multipart/form-data">
    <ul>

      <li>
        <label>
          Nama :
          <input type="text" name="Nama" autofocus autocomplete="off" required>
        </label>
      </li>
      <li>
        <label>
          Nim :
          <input type="text" name="Nim" autocomplete="off" required>
        </label>
      </li>
      <li>
        <label>
          Email :
          <input type="text" name="Email" autocomplete="off" required>
        </label>
      </li>
      <li>
        <img src="img/image.jpg" alt="" width="120" style="display: block;" class="img-preview">

        <label>
          Gambar :
          <input type="file" name="Gambar" class="Gambar" onchange="previewImage()">
        </label>
      </li>

      <li>
        <button type="submit" name="Tambah">Tambah Data</button>
      </li>
    </ul>
  </form>

  <script src="js/script.js"></script>
</body>

</html>