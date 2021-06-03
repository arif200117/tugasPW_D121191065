<?php
include('assets/header.php');
?>

<body>

    <br>
    <h3>Daftar Mahasiswa</h3>
    <div class="container">
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>

            <?php if (empty($mahasiswa)) : ?>
                <tr>
                    <td colspan="4">
                        <p>Data Mahasiswa Not Found</p>
                    </td>
                </tr>
            <?php endif ?>

            <?php $i = 1;
            foreach ($mahasiswa as $m) : ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><img src="img/<?= $m['Gambar']; ?>" width="60px"></td>
                    <td><?= $m['Nama']; ?></td>
                    <td>
                        <a href="detail.php?Id=<?= $m['Id']; ?>">Lihat Detail</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <br>
    <a href="tambah.php">Tambah Data Mahasiswa</a>
    <br>
    <script src="js/script.js"></script>
</body>
<?php
include('assets/footer.php');
?>