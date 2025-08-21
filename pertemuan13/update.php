<?php
 require 'functions.php';


 // ambil data di URL

 $id = $_GET["id"];
 // query data mahasiswa berdasarkan id

 $mhs = query("SELECT * FROM mahasiswa WHERE id =$id")[0];

// cek apakah tombol submit sudah ditekan atau belum
if(isset($_POST["submit"])) {

	var_dump($_POST); die; 

//cek apakah data berhasil diupdate atau tidak
if (update ($_POST) > 0 ) {
	echo "
	<script>
		alert('data berhasil diupdate !');
		document.location.href = 'index.php';
	</script>
		";
} else {
	echo "
		<script>
		alert('data gagal diupdate !');
		document.location.href = 'index.php';
	</script>
	";
}



	
}
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Update Data Mahasiswa</title>
</head>
<body>
	<h1>Update data mahasiswa</h1>

	<form method="post">
		<input type="hidden" name="id" value="<?= $mhs["id"]; ?>">
		<ul>
			<li>
				<label for="nrp">NRP : </label> 
				<input type="text" name="nrp" id="nrp" required value="<?= $mhs["nrp"]; ?>">
				<?php //for dan id harus sama ?>
			</li>

			<li>
				<label for="nama">Nama : </label> 
				<input type="text" name="nama" id="nama" required value="<?= $mhs["nama"]; ?>">
			</li>

			<li>
				<label for="email">Email : </label> 
				<input type="text" name="email" id="email" required value="<?= $mhs["email"]; ?>">
			</li>

			<li>
				<label for="jurusan">Jurusan : </label> 
				<input type="text" name="jurusan" id="jurusan" required value="<?= $mhs["jurusan"]; ?>">
			</li>

			<li>
				<label for="gambar">Gambar : </label> 
				<input type="file" name="gambar" id="gambar" required value="<?= $mhs["gambar"]; ?>">
			</li>

			<button type="submit" name="submit">Update Data !</button>
		</ul>
	</form>

</body>
</html>