<?php
 require 'functions.php';

// cek apakah tombol submit sudah ditekan atau belum
if(isset($_POST["submit"])) {
	

//cek apakah data berhasil ditambahkan atau tidak
if (tambah ($_POST) > 0 ) {
	echo "
	<script>
		alert('data berhasil ditambahkan !');
		document.location.href = 'index.php';
	</script>
		";
} else {
	echo "
		<script>
		alert('data gagal ditambahkan !');
		document.location.href = 'index.php';
	</script>
	";
}



	
}
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Tambah Data Mahasiswa</title>
</head>
<body>
	<h1>Tambah data mahasiswa</h1>

	<form action="" method="post" enctype="multipart/form-data">
		<ul>
			<li>
				<label for="nrp">NRP : </label> 
				<input type="text" name="nrp" id="nrp" required>
				<?php //for dan id harus sama ?>
			</li>

			<li>
				<label for="nama">Nama : </label> 
				<input type="text" name="nama" id="nama" required>
			</li>

			<li>
				<label for="email">Email : </label> 
				<input type="text" name="email" id="email" required>
			</li>

			<li>
				<label for="jurusan">Jurusan : </label> 
				<input type="text" name="jurusan" id="jurusan" required>
			</li>

			<li>
				<label for="gambar">Gambar : </label> 
				<input type="file" name="gambar" id="gambar" required>
			</li>

			<button type="submit" name="submit">Tambah Data !</button>
		</ul>
	</form>

</body>
</html>