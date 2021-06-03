<?php

function koneksi()
{
  //koneksi ke database dan pilih database
  return mysqli_connect('localhost', 'root', '', 'latihan');
}

function query($query)
{
  $conn = koneksi();

  $result = mysqli_query($conn, $query);

  // //jika hasilnya ada 1 data
  if (mysqli_num_rows($result) == 1) {
    return mysqli_fetch_assoc($result);
  }

  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }

  return $rows;
}


function upload()
{
  $nama_file = $_FILES['Gambar']['name'];
  $tipe_file = $_FILES['Gambar']['type'];
  $ukuran_file = $_FILES['Gambar']['size'];
  $error = $_FILES['Gambar']['error'];
  $tmp_file = $_FILES['Gambar']['tmp_name'];

  // ketika tidak ada gambar yang dipilih
  if ($error == 4) {
    // echo "<script>
    //         alert('pilih gambar terlebih dahulu!');
    //       </script>";
    return 'image.jpg';
  }

  // cek ekstensi file
  $daftar_gambar = ['jpg', 'jpeg', 'png'];
  $ekstensi_file = explode('.', $nama_file);
  $ekstensi_file = strtolower(end($ekstensi_file));

  if (!in_array($ekstensi_file, $daftar_gambar)) {
    echo "<script>
            alert('yang anda pilih bukan gambar!');
          </script>";
    return false;
  }

  // cek type file
  if ($tipe_file != 'image/jpeg' && $tipe_file != 'image/png') {
    echo "<script>
            alert('yang anda pilih bukan gambar!');
          </script>";
    return false;
  }

  // cek ukuran file
  // maksimal 5Mb == 5000000
  if ($ukuran_file > 5000000) {
    echo "<script>
            alert('ukuran terlalu besar!');
          </script>";
    return false;
  }

  // lolos pengecekan
  // siap upload file
  // generate nama file baru
  $nama_file_baru = uniqid(); //memberikan nama unix file secara acak
  $nama_file_baru .= '.';
  $nama_file_baru .= $ekstensi_file; //memgabungkan ekstensi
  move_uploaded_file($tmp_file, 'img/' . $nama_file_baru);

  return $nama_file_baru;
}

function Tambah($data)
{
  $conn = koneksi();

  //$Gambar = htmlspecialchars($data['Gambar']);
  $Nama = htmlspecialchars($data['Nama']);
  $Nim = htmlspecialchars($data['Nim']);
  $Email = htmlspecialchars($data['Email']);


  //upload gambar
  $Gambar = upload();
  if (!$Gambar) {
    return false;
  }

  $query = "INSERT INTO mahasiswa VALUES (null, '$Nama', '$Nim', '$Gambar', '$Email');";

  mysqli_query($conn, $query) or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}

function Hapus($Id)
{
  $conn = koneksi();

  //menghapus gambar di folder img
  $mhs = query("SELECT * FROM mahasiswa WHERE Id = $Id");
  if ($mhs['Gambar'] != 'image.jpg') {
    unlink('img/' . $mhs['Gambar']);
  }

  mysqli_query($conn, "DELETE FROM mahasiswa WHERE Id = $Id") or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}

function Ubah($data)
{
  $conn = koneksi();

  $Id = ($data['Id']);
  $gambar_lama = htmlspecialchars($data['gambar_lama']);
  $Nama = htmlspecialchars($data['Nama']);
  $Nim = htmlspecialchars($data['Nim']);
  $Email = htmlspecialchars($data['Email']);


  //upload gambar
  $Gambar = upload();
  if (!$Gambar) {
    return false;
  }

  if ($Gambar == 'image.jpg') {
    $Gambar = $gambar_lama;
  }

  $query = "UPDATE mahasiswa SET
                Gambar = '$Gambar',
                Nama = '$Nama',
                Nim = '$Nim',
                Email = '$Email',
              WHERE Id = $Id";

  mysqli_query($conn, $query) or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}

function Cari($keyword)
{
  $conn = koneksi();

  $query = "SELECT * FROM mahasiswa WHERE 
                Nama LIKE '%$keyword%' OR
                Nim LIKE '%$keyword%' OR
                Email LIKE '%$keyword%'";


  $result = mysqli_query($conn, $query);
  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }

  return $rows;
}

// function Login($data)
// {
//   $conn = koneksi();

//   $username = htmlspecialchars($data['username']);
//   $password = htmlspecialchars($data['password']);

//   if ($user = query("SELECT * FROM user WHERE username = '$username'")) {
//     if (password_verify($password, $user['password'])) {
//       $_SESSION['$login'] = true;

//       header("Location: index.php");
//       exit;
//     }
//   }
//   return [
//     'error' => true,
//     'pesan' => 'Username/Password Salah'
//   ];
// }

function Registrasi($data)
{
  $conn = koneksi();

  $username = htmlspecialchars($data['username']);
  $password1 = mysqli_real_escape_string($conn, $data['password1']);
  $password2 = mysqli_real_escape_string($conn, $data['password2']);

  //jika ada field yang kosong
  if (empty($username) || empty($password1) || empty($password2)) {
    echo "<script> 
                alert ('Username/Password tidak boleh kosong');
                document.location.href = 'registrasi.php';
            </script>";
    return false;
  }

  //jika username sudah ada
  if (query("SELECT * FROM user WHERE username = '$username'")) {
    echo "<script> 
                alert ('Username sudah terdaftar');
                document.location.href = 'registrasi.php';
            </script>";
    return false;
  }

  //jika konfirmasi tidak sesuai
  if ($password1 !== $password2) {
    echo "<script> 
                alert ('Konfirmasi Password tidak sesuai');
                document.location.href = 'registrasi.php';
            </script>";
    return false;
  }

  //jika password kurang dari 6 digit
  if (strlen($password1) < 6) {
    echo "<script> 
                alert ('Password terlalu pendek');
                document.location.href = 'registrasi.php';
            </script>";
    return false;
  }

  //jika kondisi sudah sesuai
  $password_baru = password_hash($password1, PASSWORD_DEFAULT);

  $query = "INSERT INTO user VALUES (null, '$username', '$password_baru')";

  mysqli_query($conn, $query) or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}
