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

	//upload gambar

	$gambar = upload();
	if ( !$gambar) { //jika gambar false
		return false; //maka fungsi tambah  gagal
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
	$tmpName = $_FILES['gambar']['tmp_name'];

	// cek apakah tidak ada gambar yang diupload
	if ($error === 4) {// 4 artinya tidak ada gambar yang diupload
	echo "<script> alert('Pilih gambar terlebih dahulu !')
			</script>";
	return false; // jadi jika function upload gagal begitu juga function tambah
					}

// cek apakah yang diupload adalah gambar
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
	$ekstensiGambar = explode('.', $namaFile); // untuk memecah string menjadi array contoh dimas.jpg = ['dimas','jpg']	
	$ekstensiGambar = strtolower(end($ekstensiGambar)); // end untuk mengambil urutan array terakhir yaitu jpg. strtolower memaksa untuk huruf kecil			
	if (!in_array($ekstensiGambar, $ekstensiGambarValid) ) {
		echo "<script> alert('yang anda upload bukan gambar!');
				</script>";
		return false;		}

		if ($ukuranFile > 100000000) {
			echo "<script> alert('ukuran gambar terlalu besar!');
			</script>";
			return false;
		}

	// lolos pengecekan, gambar siap diupload
	// generat nama gambar baru

	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;
	 

	move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
	return $namaFileBaru;

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

function registrasi($data) { 
	global $conn;

	$username = strtolower (stripslashes($data["username"]));
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn, $data["password2"]);

	// cek username sudah ada atau belum

	$result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
	if (mysqli_fetch_assoc($result) ) {
		echo "<script>
		alert('username sudah terdaftar!') </script>";
		return false;
	}

	// cek konfirmasi password

	if($password !== $password2) {
		echo "<script> alert('konfirmasi password tidak sesuai!'); </script>";
		return false;
	}

	// enkripsi password

	$password = password_hash($password, PASSWORD_DEFAULT);

	// tambahkan userbaru ke database

	mysqli_query($conn, "INSERT INTO users VALUES('', '$username', '$password')");
	return mysqli_affected_rows($conn);  
}

 ?>