<!DOCTYPE html>
<html lang="en">
<head>
  <title>Buku Perpustakaan</title>
  <Link rel ="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>
  <h2>Daftar Buku Perpustakaan</h2>
  <h2>Silahkan pilih buku untuk dipinjam</h2>
  

  <?php
  require 'autoload.php';
  $query = "SELECT * FROM buku";
  $result= mysqli_query($connect, $query) OR die(mysql_error());
  ?>

  <table border="1" cellspacing="0" cellpadding="4">
    <thead>
      <tr>
        <th>Judul</th>
        <th>Pengarang</th>
        <th>Tahun</th>   
        <th>Penerbit</th>
        <th>Kategori</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = mysqli_fetch_assoc($result)){ ?>
        <tr>
          <td>
            <a href="<?= './detail.php?id='. $row['id'] ?>">
              <?= $row['judul']; ?>
            </a>
          </td>
          <td><?= $row['pengarang']; ?></td>
          <td><?= $row['tahun']; ?></td>
          <td><?= $row['penerbit']; ?></td>
          <td><?= $row['kategori']; ?></td>
        </tr>
      <?php } ?>
   </tbody>
  </table>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>