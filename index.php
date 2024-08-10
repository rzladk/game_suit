<?php
session_start();
if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

//pagination
//KONFIG
$jumlahdataPerhalaman = 2;
$jumlahdata = count(query("SELECT * FROM mahasiswa"));
$jumlahhalaman = ceil($jumlahdata / $jumlahdataPerhalaman);
$halamanaktif = ( isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
$awaldata = ($jumlahdataPerhalaman * $halamanaktif) - $jumlahdataPerhalaman;

$mahasiswa = query("SELECT * FROM mahasiswa LIMIT $awaldata, $jumlahdataPerhalaman");

// ketika tombol cari ditekan
if (isset($_POST["cari"])) {
    $mahasiswa = cari($_POST["keyword"]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Daftar Mahasiswa</title>
    <style>
        .loader {
            width: 40px;
            position: absolute;
            top: 130px;
            left: 300px;
            z-index: -1;
            display: none;
        }
    </style>
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/script.js"></script>
</head>
<body>
    <a href="logout.php" class="logout">Logout</a> | <a href="cetak.php" target="_blank">Cetak</a>

    <h1>Daftar Mahasiswa</h1>

    <a href="tambah.php" class="tombol">Tambah</a>

    <br><br>

<form action="" method="post">
    
    <input type="text" name="keyword" size="40" autofocus placeholder="masukkan keyword pencarian.." autocomplete="off" id="keyword">
    <button type="submit" name="cari" id="tombol-cari">Cari</button>

    <img src="img/spinner.gif" alt="" class="loader">
    
</form>
    <br><br>

    <!-- nav -->
    <?php if($halamanaktif > 1 ) : ?>
        <a href="?halaman=<?= $halamanaktif - 1;?>">&laquo;</a>
    <?php endif; ?>
    
    <?php for($i = 1; $i <= $jumlahhalaman; $i++ ) : ?>
        <?php if($i == $halamanaktif) : ?>
            <a href="?halaman=<?= $i; ?>" style = "font-weight : bold; color : red;"><?php echo $i; ?></a>
        <?php else : ?>
            <a href="?halaman=<?= $i;?>"><?= $i; ?></a>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if($halamanaktif < $jumlahhalaman ) : ?>
    <a href="?halaman=<?= $halamanaktif + 1;?>">&raquo;</a>
    <?php endif; ?>

    <br>

    <div id="container">

    <form action="" method="get">
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No.</th>
            <th>Aksi</th>
            <th>Gambar</th>
            <th>NPM</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Jurusan</th>
        </tr>

        <?php $i = 1; ?>
        <?php foreach ($mahasiswa as $row) : ?>
        <tr>
            <td><?php echo $row["id"]; ?></td>
            <td>
                <a href="ubah.php?id=<?= $row["id"]; ?>">Ubah</a>  
                
                <a href="hapus.php?id=<?= $row["id"]; ?>" onclick="return confirm('yakin?')">Hapus</a></td>
            <td><img src="img/<?= $row["gambar"]; ?>" width="50"></td>
            <td><?php echo $row["npm"]; ?></td>
            <td><?php echo $row["nama"]; ?></td>
            <td><?php echo $row["email"]; ?></td>
            <td><?php echo $row["jurusan"]; ?></td>
        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
    </table>
    </div>
</body>
</html>