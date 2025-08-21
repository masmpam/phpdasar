<?php 
//koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "phpdasar");


function query($query) {
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while( $row = mysqli_fetch_assoc($result)) {
		$rows[]= $row;
			}
	return $rows;
}

function tambah($data) {
	global $conn;

	// ambil data dari tiap elemen dalam form
	$nrp = htmlspecialchars($data["nrp"]);
	$nama = htmlspecialchars($data["nama"]);
	$email = htmlspecialchars($data["email"]);
	$jurusan = htmlspecialchars($data["jurusan"]);
	
	// Upload gambar
	$gambar = upload();
	if ( !$gambar) {
		return false;
	}


// query insert data
	$query = "INSERT INTO mahasiswa
	VALUES
	('','$nrp', '$nama', '$email', '$jurusan', '$gambar')
	";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function upload() {

	$namaFile = $_FILES['gambar']['name'];
	$ukuranFile = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmpName =$_FILES['gambar']['tmp_name'];

	// cek apakah tidak ada gambar yang diupload

	if ($error === 4) {
		echo "<script>
				alert ('pilih gambar terlebih dahulu !');
				</script>";
				return false;
			}
}

function hapus($id) {
	global $conn;
	mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");
	return mysqli_affected_rows($conn);
}

function update($data){
	global $conn;

	// ambil data dari tiap elemen dalam form
	$id = $data["id"];
	$nrp = ($data["nrp"]);
	$nama = ($data["nama"]);
	$email = ($data["email"]);
	$jurusan = ($data["jurusan"]);
	$gambar = ($data["gambar"]);

// query insert data
	$query = "UPDATE mahasiswa SET
			nrp = '$nrp',
			nama = '$nama',
			email = '$email',
			jurusan = '$jurusan',
			gambar = '$gambar'
			WHERE id = $id
			";

	mysqli_query($conn, $query); //jalankan querynya

	return mysqli_affected_rows($conn); //kembalikan angka ketika ada data yang berhasil diupdate
}

function cari($keyword) {
	$query = "SELECT * FROM mahasiswa
				WHERE
				nama LIKE '%$keyword%' OR
				nrp LIKE  '%$keyword%' OR
				email LIKE '%$keyword%' OR
				jurusan LIKE '%$keyword%'
				";
				return query($query);
}

 ?>