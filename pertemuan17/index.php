<?php
session_start();

if ( !isset ($_SESSION["login"]) ) {
	header("Location: login.php");
	exit;
}

require 'functions.php';

// pagination
// konfigurasi

$JumlahDataPerhalaman = 2;
$JumlahData = count(query("SELECT *FROM mahasiswa"));
$JumlahHalaman = ceil($JumlahData / $JumlahDataPerhalaman); //floor bulatin keatas, ceil sebaliknya
$HalamanAktif = ( isset($_GET["halaman"]) ) ? $_GET["halaman"] : 1;
$AwalData = ( $JumlahDataPerhalaman * $HalamanAktif) - $JumlahDataPerhalaman;

$mahasiswa = query("SELECT * FROM mahasiswa LIMIT $AwalData, $JumlahDataPerhalaman");


// tombol cari ditekan
if(isset($_POST["cari"]) ) {
	$mahasiswa = cari($_POST["keyword"]);	
}

 ?>


<!DOCTYPE HTML>
<HTML>
<head>
	<title>Halaman Admin</title>
</head>
<body>

<a href="logout.php">Metu</a>

<h1>Daftar Mahasiswa</h1>

<a href="tambah.php">Tambah Data Mahasiswa</a> <br><br>

<form action="" method="post">
	<input type="text" name="keyword" size="40" autofocus placeholder="masukkan keyword pencarian.." autocomplete="off">
	<button type="submit" name="cari">Cari!</button>
</form>
<br><br>
<!--Navigasi -->
<?php for($i = 1; $i <= $JumlahHalaman; $i++) : ?>
<a href="?halaman=<?= $i; ?>"> <?= $i ?> </a>
<?php endfor; ?>



<br>
<table border="1" cellpadding="10" cellspacing="0">

<tr>
	<th>No.</th>
	<th>Aksi</th>
	<th>Gambar</th>
	<th>NRP</th>
	<th>Nama</th>
	<th>Email</th>
	<th>Jurusan</th>
</tr>
<?php $i = 1; ?>
<?php foreach ($mahasiswa as $row) :	?>
<tr>
	<td> <?= $i; ?> </td>
	<td>
		<a href="update.php?id= <?= $row["id"];?>" >ubah</a> |
		<a href="hapus.php?id= <?= $row["id"]; ?> "onclick=" return confirm('yakin ?');">hapus</a>
    </td>
    <td> <img src="img/<?= $row["gambar"]; ?>" width="100"></td>
    <td><?= $row["nrp"]; ?></td>
    <td><?= $row["nama"]; ?> </td>
    <td><?= $row["email"]; ?></td>
    <td><?= $row["jurusan"]; ?></td>
</tr>
<?php $i++; ?>
<?php endforeach; ?>
 
</table>

</body>
</HTML>
