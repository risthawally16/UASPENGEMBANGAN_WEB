<?php
// Kredensial database yang diperlukan

$host     = "localhost";
$uname    = "root";
$pass     = "";
$database = "uasweb";

$connect = mysqli_connect($host, $uname, $pass, $database) OR die(mysql_error());

function query($query){
  global $conn;
  $result = mysqli_query($conn, $query);
  $rows =[];
  while ($row = mysqli_fetch_assoc($result)){
    $rows[] = $row;
  }
  return $rows;
}

function tambah ($data){
  global $conn;
  //ambil data dari tiap form
  $judul   = htmlspecialchars( $data["judul"]);
  $pengarang    = htmlspecialchars( $data["pengarang"]);
  $tahun   = htmlspecialchars( $data["tahun"]);
  $penerbit = htmlspecialchars( $data["penerbit"]);
  $kategori = htmlspecialchars( $data["kategori"]);

  //query insert data
  $query ="INSERT INTO buku 
        VALUE 
      ('','$judul','$pengarang', '$tahun','$penerbit','$kategori')
      ";
  mysqli_query($conn, $query);
  
  return mysqli_affected_rows($conn);
  
}


function ubah ($data){
  global $conn;
  //ambil data dari tiap form
  $id    = htmlspecialchars($data["id"]);
  $judul    = htmlspecialchars($data["nim"]);
  $pengarang     = htmlspecialchars($data["nama"]);
  $tahun   = htmlspecialchars($data["judulbuku"]);
  $penerbit = htmlspecialchars($data["prodi"]);
  $kategori = htmlspecialchars( $data["email"]);

  //query insert data
  $query ="UPDATE buku SET
        judul   = '$judul',
        pengarang  = '$pengarang',
        tahun   = '$tahun',
        penerbit = '$penerbit',
        kategori  = '$kategori'
      WHERE id  = '$id
      ";
  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}

function hapus($id){
  global $conn;
  mysqli_query($conn,"DELETE FROM buku WHERE id= $id");

  return mysqli_affected_rows($conn);
}

function cari ($keyword){
  $query = "SELECT * FROM buku 
        WHERE
        judul   LIKE '%$keyword%' OR
        pengarang  LIKE '%$keyword%' OR
        tahun   LIKE '%$keyword%' OR
        penerbit LIKE '%$keyword%' OR
        kategori LIKE '%$keyword%'
      ";
  return query ($query);
}


function registrasi($data){
  global $connect;
  $username  = strtolower(stripslashes($data["username"]));
  $password    = mysqli_real_escape_string($connect,$data["password"]);
  $password2   = mysqli_real_escape_string($connect,$data["password2"]);

  //cek username udah ada atau belum
  $result = mysqli_query($connect,"SELECT username FROM anggota WHERE
            username ='$username'");
  if (mysqli_fetch_assoc($result)){
    echo "<script>
        alert('username sudah terdaftar')
        </script>
      ";
    return false;
  }

  //cek konfirmasi password
  if($password !== $password2){
    echo "<script>
      alert('konfirmasi password tidak sesuai');
      </script>";
    return false;

  }

  //encripsi password
  $password = password_hash($password, PASSWORD_DEFAULT);



  //tambahkan user baru ke database
  mysqli_query($connect, "INSERT INTO anggota VALUE('','$username','$password')");

  return mysqli_affected_rows($connect);

}
?>